<?php namespace BriskSurf\Ads;

use Auth;
use Carbon;
use URL;
use View;
use Input;
use Redirect;
use Settings;
use BriskSurf\Events\CounterManager;

class BannerController extends \BriskSurf\Helpers\BaseController 
{
	protected $validators;
	protected $counter;
	protected $banner;

	public function __construct(BannerModel $banner, AdsValidatorsBank $validators, CounterManager $counter)
	{
		$this->banner = $banner;
		$this->validators = $validators;
		$this->counter = $counter;

		parent::getNotifications();
	}

	public function getBanners()
	{
		$user = Auth::user();
		$banners = $user->banners;

		$quick_assign = array("mass" => "Mass Assign");

		foreach($banners as $banner) $quick_assign[$banner->id] = $banner->url;

		if(count($quick_assign) == 1) $quick_assign = false;

		return View::make('ads::banners')->with("user", $user)->with('banners', $banners)->with('quick_assign', $quick_assign);
	}

	public function getBannerSettings($id)
	{
		$user = Auth::user();

		$banner = $this->banner->where("_id", $id)->whereUserId($user->id)->first();

		if($banner == null) return View::make('templates.message')->with(array('subject' => 'Oops!', 'message' => 'We could not find this banner. Click <a href="' . URL::to('banners') . '">here</a> to go back.'));
		return View::make('ads::banner_settings')->with('user', $user)->with('banner', $banner)->with('targeting', Settings::get("memberships")[$user->membership]['targeting']);
	}

	public function postBannerSettings($id)
	{
		$user = Auth::user();
		
		$banner = $this->banner->where("_id", $id)->whereUserId($user->id)->first();

		if($banner == null) return Redirect::to('banners/' . $id);

		$this->validators->get("bannerSettings")->addInput(['banner' => $banner, 'user' => $user]);

		if ($this->validators->get("bannerSettings")->fails()) return Redirect::to('banners/' . $id)->withErrors($this->validators->get("bannerSettings")->errors())->withInput();

		$user->credits = $user->credits + ($banner->credits - Input::get('credits'));
		$user->save();

		$banner->credits = floatval(Input::get('credits'));
		$banner->enabled = (Input::get('enabled') == "1") ? true : false;
		if(Settings::get("memberships")[$user->membership]['targeting'])
		{
			$banner->hours  = explode(",", Input::get('hours'));
			$banner->days  = explode(",", Input::get('days'));
		}
		else
		{
			$banner->hours  = array();
			$banner->days  = array();
		}
		$banner->save();

		return Redirect::to('banners/' . $id)->withErrors(["global" => "Settings updated successfully"]);
	}

	public function postBanner()
	{
		$user = Auth::user();

		if($this->validators->get("addBanner")->fails()) return Redirect::to('banners')->withErrors($this->validators->get("addBanner")->errors())->withInput();

		$banner = new $this->banner;
		$banner->banner = Input::get('image_url');
		$banner->url = Input::get('target_url');
		$banner->enabled = true;
		$banner->credits = 0;
		$banner->views = 0;
		$banner->days = array();
		$banner->hours = array();
		$user->banners()->save($banner);

		return Redirect::to('banners');
	}

	public function getBannerGraph($id)
	{
		$views = $this->counter->graphDays(array(
			"type" => "banner_views",
			"banner" => $id
		), Carbon::now()->subDays(14), Carbon::now());

		return View::make('ads::banner_graph')->with('views', $views);
	}

	public function toggleBanners($id)
	{
		$banner = $this->banner->where('_id', $id)->whereUserId(Auth::user()->id)->first(['enabled']);
		if($banner != null)
		{
			$banner->enabled = !$banner->enabled;
			$banner->save();
		}
		return Redirect::to('banners');
	}

	public function deleteBanners($id)
	{
		$user = Auth::user();

		$banner = $this->banner->where('_id', $id)->where('user_id', $user->id)->first();
		if($banner != null) 
		{
			if($banner->credits != 0) $user->increment("credits", $banner->credits);
			$banner->delete();
		}
		return Redirect::to('banners');
	}

	public function assignBannerCredits()
	{
		$user = Auth::user();
		$banners = $user->banners;

		$this->validators->get("bannerAssign")->addInput(['banners' => $banners, 'user' => $user]);

		if ($this->validators->get("bannerAssign")->fails()) return Redirect::to('banners')->withErrors($this->validators->get("banner_assign")->errors())->withInput();

		$quick_assign = Input::get('quick_assign');
		$credits_assign = floatval(Input::get('number_of_credits'));

		if($quick_assign == "mass")
		{
			foreach($banners as $banner) $banner->increment('credits', round($credits_assign / count($banners),2) );
		}
		else $banners->find($quick_assign)->increment('credits', $credits_assign);

		$user->decrement('credits', $credits_assign);

		return Redirect::to('banners')->withErrors(["global" => "Credits assigned to your banners"]);
	}
}