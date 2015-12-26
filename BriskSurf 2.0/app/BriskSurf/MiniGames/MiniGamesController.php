<?php namespace BriskSurf\MiniGames;

use Auth;
use Carbon;
use Cache;
use URL;
use View;
use Input;
use Redirect;
use Settings;
use BriskSurf\Ads\BannerModel as Banner;

class MiniGamesController extends \BriskSurf\Helpers\BaseController 
{
	public function getGame()
	{
		$user = Auth::user();
		if($user->views_today % 10 != 0) return false;

		return $this->setBanner();
	}

	public function checkGame()
	{
		$user = Auth::user();

		if(!Cache::has('minigame_complete_' . $user->id)) return false;

		$value = Cache::get('minigame_complete_' . $user->id);
		Cache::forget('minigame_complete_' . $user->id);
		return $value;
	}

	public function chooseGame()
	{
		if(!Cache::has('minigame_info')) return $this->reloadParentFrame();

		return View::make('miniGames::choose')->with('info', Cache::get('minigame_info'));
	}

	public function showGame($game)
	{
		if($game == 'banners') return $this->bannerGame();
	}

	public function postGame($game)
	{
		if($game == 'banners') return $this->postBannerGame();
	}

	public function setBanner()
	{
		$now = Carbon::now();
		$user = Auth::user();

		$query = array(
			'user_id' => array('$ne' => $user->id),
			'credits' => array('$gt' => 1),
			'enabled' => true,
			'hours' => array('$ne' => $now->format('g a')),
			'days' => array('$ne' => strtolower($now->format('l')))
		);
		$skip = Banner::whereRaw($query)->count();
		$skip = ($skip > 12) ? rand(0, $skip - 12) : 0;

		$banners_raw = Banner::whereRaw($query)->with('user')->skip($skip)->take(12)->get()->toArray();

		if(count($banners_raw) != 12) return false;

		$banners = array();
		foreach($banners_raw as $banner) $banners[$banner['_id']] = $banner;

		Cache::put('minigame_info', array(URL::to('minigame/banners'), 'Banner Fight Mini Game', 'How it works: choose your favorite banners and get rewarded when the champion is chosen'), 20);
		Cache::put('minigame_banners_' . $user->id, $banners, 20);

		return URL::to('minigame');
	}

	public function bannerGame()
	{
		$user = Auth::user();

		if(!Cache::has('minigame_banners_' . $user->id)) return $this->reloadParentFrame();

		$cache = Cache::get('minigame_banners_' . $user->id);

		if(count($cache) != 1) return View::make('miniGames::banners')->with('banners', $cache);
		
		Cache::forget('minigame_info_' . $user->id);
		Cache::forget('minigame_banners_' . $user->id);

		$credits = Settings::get("memberships")[$user->membership]['credits_per_view'] * 3;
		Cache::put('minigame_complete_' . $user->id, $credits, 20);

		return View::make('miniGames::banners_complete')->with('banner', array_values($cache)[0])->with('credits', $credits);
	}

	public function postBannerGame()
	{
		$user = Auth::user();

		$banners_cache = Cache::get('minigame_banners_' . $user->id);

		if(!$banners_cache) return $this->reloadParentFrame();

		$banners = explode(",", Input::get('banner_ids'));

		if(count($banners) != floor(count($banners_cache) / 2)) return $this->reloadParentFrame();
		
		$banners_cache_new = array();

		foreach($banners as $id)
		{
			if(!isset($banners_cache[$id]))
			{
				Cache::forget('minigame_banners_' . $user->id);
				return $this->reloadParentFrame();
			}
			
			$banners_cache_new[$id] = $banners_cache[$id];
		}

		foreach($banners_cache as $id => $data)
		{
			$banner = Banner::where("_id", $id)->where("credits", ">=", 0.2)->first();
			if($banner != null)
			{
				$banner->decrement('credits', 0.2);
				$banner->increment('views');
				banner_view_event($id);
			}
		}

		Cache::put('minigame_banners_' . $user->id, $banners_cache_new, 20);

		return Redirect::to('minigame/banners');
	}

	public function reloadParentFrame()
	{
		return "<script>window.parent.location.reload();</script>";
	}
}