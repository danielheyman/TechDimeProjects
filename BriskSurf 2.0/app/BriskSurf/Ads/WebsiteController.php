<?php namespace BriskSurf\Ads;

use Auth;
use Carbon;
use URL;
use View;
use Input;
use Redirect;
use Settings;
use BriskSurf\Events\MegaCounterManager;
use BriskSurf\Events\CounterManager;

class WebsiteController extends \BriskSurf\Helpers\BaseController 
{
	protected $validators;
	protected $megaCounter;
	protected $counter;
	protected $website;

	public function __construct(WebsiteModel $website, AdsValidatorsBank $validators, MegaCounterManager $megaCounter, CounterManager $counter)
	{
		$this->website = $website;
		$this->validators = $validators;
		$this->megaCounter = $megaCounter;
		$this->counter = $counter;

		parent::getNotifications();
	}

	public function getWebsites()
	{
		$user = Auth::user();
		$websites = $user->websites;

		$quick_assign = array("mass" => "Mass Assign");

		foreach($websites as $website) $quick_assign[$website->id] = $website->url;

		if(count($quick_assign) == 1) $quick_assign = false;

		return View::make('ads::websites')->with("user", $user)->with('websites', $websites)->with('quick_assign', $quick_assign);
	}

	public function assignWebsiteCredits()
	{
		$user = Auth::user();
		$websites = $user->websites;

		$this->validators->get("websiteAssign")->addInput(['websites' => $websites, 'user' => $user]);

		if ($this->validators->get("websiteAssign")->fails()) return Redirect::to('websites')->withErrors($this->validators->get("websiteAssign")->errors())->withInput();

		$quick_assign = Input::get('quick_assign');
		$credits_assign = floatval(Input::get('number_of_credits'));

		if($quick_assign == "mass")
		{
			foreach($websites as $website) $website->increment('credits', round($credits_assign / count($websites),2) );
		}
		else $websites->find($quick_assign)->increment('credits', $credits_assign);

		$user->decrement('credits', $credits_assign);

		return Redirect::to('websites')->withErrors(["global" => "Credits assigned to your websites"]);
	}

	public function getWebsiteSettings($id)
	{
		$user = Auth::user();

		$website = $this->website->where("_id", $id)->whereUserId($user->id)->first();

		if($website == null) return View::make('templates.message')->with(array('subject' => 'Oops!', 'message' => 'We could not find this website. Click <a href="' . URL::to('websites') . '">here</a> to go back.'));

		return View::make('ads::website_settings')->with('user', $user)->with('website', $website)->with('targeting', Settings::get("memberships")[$user->membership]['targeting']);
	}

	public function postWebsiteSettings($id)
	{
		$user = Auth::user();
		
		$website = $this->website->where("_id", $id)->whereUserId($user->id)->first();

		if($website == null) return Redirect::to('websites/' . $id);

		$this->validators->get("websiteSettings")->addInput(['website' => $website]);

		if ($this->validators->get("websiteSettings")->fails()) return Redirect::to('websites/' . $id)->withErrors($this->validators->get("websiteSettings")->errors())->withInput();
		
		$user->credits = $user->credits + ($website->credits - Input::get('credits'));
		$user->auto_assign = $user->auto_assign + (Input::get('auto_assign') - $website->auto_assign);
		$user->save();

		$website->credits = floatval(Input::get('credits'));
		$website->auto_assign = intval(Input::get('auto_assign'));
		$website->enabled = (Input::get('enabled') == "1") ? true : false;
		if(Settings::get("memberships")[$user->membership]['targeting'])
		{
			$website->hours  = explode(",", Input::get('hours'));
			$website->days  = explode(",", Input::get('days'));
		}
		else
		{
			$website->hours  = array();
			$website->days  = array();
		}
		$website->save();

		return Redirect::to('websites/' . $id)->withErrors(["global" => "Settings updated successfully"]);
	}

	public function getWebsiteGraph($id)
	{
		$ratings_raw = $this->megaCounter->graph(array(
			"type" => "website_rating",
			"website" => $id
		), Carbon::now()->subDays(14), Carbon::now(), array("ratings", "out_of"));

		$ratings = array();
		$total_ratings = 0;
		$total_out_of = 0;
		foreach($ratings_raw["ratings"] as $date => $rating)
		{
			$total_ratings += $rating;
			$total_out_of += $ratings_raw["out_of"][$date];
			$ratings[$date] = ($rating == 0) ? 0 : $rating / $ratings_raw["out_of"][$date] * 3;
		}
		$average_rating = ($total_ratings == 0) ? 0 : $total_ratings / $total_out_of * 3;


		$views = $this->counter->graphDays(array(
			"type" => "website_views",
			"website" => $id
		), Carbon::now()->subDays(14), Carbon::now());

		return View::make('ads::website_graph')->with('views', $views)->with('ratings', $ratings)->with('average_rating', $average_rating);
	}

	public function postWebsites()
	{
		$user = Auth::user();

		if($this->validators->get("addWebsite")->fails()) return Redirect::to('websites')->withErrors($this->validators->get("addWebsite")->errors())->withInput();
		
		$website = new $this->website;
		$website->url = Input::get('website');
		$website->enabled = true;
		$website->credits = 0;
		$website->views = 0;
		$website->days = array();
		$website->hours = array();
		$website->auto_assign = 0;
		$user->websites()->save($website);

		return Redirect::to('websites');
	}

	public function toggleWebsites($id)
	{
		$website = $this->website->where('_id', $id)->whereUserId(Auth::user()->id)->first(['enabled']);
		if($website != null)
		{
			$website->enabled = !$website->enabled;
			$website->save();
		}
		return Redirect::to('websites');
	}

	public function deleteWebsites($id)
	{
		$user = Auth::user();

		$website = $this->website->where('_id', $id)->where('user_id', $user->id)->first();
		if($website != null) 
		{
			if($website->credits != 0) $user->increment("credits", $website->credits);
			if($website->auto_assign != 0) $user->decrement("auto_assign", $website->auto_assign);
			$website->delete();
		}
		return Redirect::to('websites');
	}
}