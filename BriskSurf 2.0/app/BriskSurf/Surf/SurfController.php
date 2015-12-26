<?php namespace BriskSurf\Surf;

use Auth;
use Carbon;
use Cache;
use View;
use Input;
use Redirect;
use Settings;
use BriskSurf\Ads\BannerModel;
use BriskSurf\Ads\WebsiteModel;
use BriskSurf\MiniGames\MiniGamesController;

class SurfController extends \BriskSurf\Helpers\BaseController 
{
	protected $validators;
	protected $banner;
	protected $website;
	protected $miniGames;

	public function __construct(SurfValidatorsBank $validators, BannerModel $banner, WebsiteModel $website, MiniGamesController $miniGames)
	{
		$this->validators = $validators;
		$this->banner = $banner;
		$this->website = $website;
		$this->miniGames = $miniGames;
	}

	public function getResult($user, $type, $object)
	{
		if(Cache::has($type . '_' . $user->id)) $results = Cache::get($type . '_' . $user->id);
		else
		{
			$now = Carbon::now();

			$query = array(
				'user_id' => array('$ne' => $user->id),
				'credits' => array('$gt' => 1),
				'enabled' => true,
				'hours' => array('$ne' => $now->format('g a')),
				'days' => array('$ne' => strtolower($now->format('l')))
			);
			$skip = $object->whereRaw($query)->count();
			$skip = ($skip > 10) ? rand(0, $skip - 10) : 0;

			$results = $object->whereRaw($query)->with('user')->skip($skip)->take(10)->get()->toArray();
		}

		$rand = rand(0, count($results) - 1);
		$result =  $results[$rand];
		array_splice($results, $rand, 1);

		if(count($results) == 0) Cache::forget($type . '_' . $user->id);
		else Cache::put($type . '_' . $user->id, $results, 20);

		return $result;
	}

	public function getSurf($type = "hover")
	{
		$user = Auth::user();

		$minigame = $this->miniGames->getGame();
		if($minigame)
		{
			if($type == "classic") $page = "miniGames::surf_classic";
			else if($type == "hover") $page = "miniGames::surf";

			return View::make($page)->with(array(
				'views' => $user->views_today,
				'credits' => $user->credits,
				'credits_today' => $user->credits_today,
				'website' => $minigame
			));
		}

		$website = $this->getResult($user, "websites", new $this->website);
		$banner = $this->getResult($user, "banners", new $this->banner);

		$code = str_random(10);
		Cache::put('hash_' . $user->id, $code, 20);

		$email = md5($website['user']['email']);
		$banner_email = md5($banner['user']['email']);

		$hash = md5($code . $website['_id'] . $banner['_id']);

		$verify_human = ($user->views_today % 36 == 0);

		if($type == "classic") $page = "surf::surf_classic";
		else if($type == "hover") $page = "surf::surf";

		return View::make($page)->with(array(
			'views' => $user->views_today,
			'credits' => $user->credits,
			'credits_today' => $user->credits_today,
			'website' => $website['url'],
			'id' => $website['_id'],
			'email' => $email,
			'banner_url' => $banner['url'],
			'banner_image' => $banner['banner'],
			'banner_id' => $banner['_id'],
			'banner_email' => $banner_email,
			'hash' => $hash,
			'verify_human' => $verify_human,
			'timer' => Settings::get("memberships")[$user->membership]['timer']
		));
	}

	public function postSurf($type = "hover")
	{
		if($type == "classic") $page = "surf/classic";
		else if($type == "hover") $page = "surf";

		$minigame = $this->miniGames->checkGame();

		if(!$minigame && $this->validators->get("surf")->fails()) return Redirect::to($page)->withErrors($this->validators->get('surf')->errors());

		$user = Auth::user();

		$credits = ($minigame) ?: Settings::get("memberships")[$user->membership]['credits_per_view'];

		if($user->auto_assign > 0)
		{
			foreach($user->websites()->where('auto_assign', '>', 0)->get() as $website)
			{
				$website->increment('credits', $credits * $website->auto_assign / 100);
				$website->save();
			}
		}

		$user->increment('credits', $credits * (100 - $user->auto_assign) / 100);
		$user->increment('credits_today', $credits);
		$user->increment('views_today');
		$user->increment('views_total');

		surf_event($user, $credits);

		if($user->upline != null)
		{
			$ref = \User::whereId($user->upline)->first();
			if($ref != null)
			{
				$credits = number_format(Settings::get("memberships")[$ref->membership]['referral_percent'] / 100 * $credits, 2);
				$ref->increment("credits", $credits);

				ref_surf_event($ref, $credits);
			}
		}

		if($minigame) return Redirect::to($page);

		$website = $this->website->where("_id", Input::get('id'))->where("credits", ">=", 1)->first();
		
		if($website != null)
		{
			$website->decrement('credits');
			$website->increment('views');
			website_view_event(Input::get('id'), Input::get('rating'));
		}

		$banner = $this->banner->where("_id", Input::get('banner_id'))->where("credits", ">=", 0.2)->first();
		if($banner != null)
		{
			$banner->decrement('credits', 0.2);
			$banner->increment('views');
			banner_view_event(Input::get('banner_id'));
		}

		return Redirect::to($page);
	}
}