<?php namespace BriskSurf\HomeReferral;

use Auth;
use Carbon;
use View;
use Route;
use Request;
use Cookie;
use User;

class HomeController extends \BriskSurf\Helpers\BaseController 
{
	public function __construct()
	{
		parent::getNotifications();
	}

	public function getHome($id = null)
	{
		if($id != null) $this->processRefUrl($id);
		
		return View::make('homeReferral::home');
	}

	public function getDashboard()
	{
		$user = Auth::user();

		$vars = array("user" => $user);

		$deals = $user->deals()->get();
		$new = array();
		foreach($deals as $value)
		{
			if($value->expires > Carbon::now()) $new[] = $value;
		}
		for($x = 0; $x < count($new) - 1; $x++)
		{
			for($y = $x + 1; $y < count($new); $y++)
			{
				if($new[$x]->expires > $new[$y]->expires)
				{
					$temp = $new[$x];
					$new[$x] = $new[$y];
					$new[$y] = $temp;
				}
			}
		}
		if(count($new) != 0) $vars["deals"] = $new;

		return View::make('homeReferral::dash')->with($vars);
	}

	function processRefUrl($id)
	{
		$user = User::whereUsername($id)->get(['_id']);

		if ( $user->isEmpty()) return;

		$user = $user->first();

		$page = explode("/", Route::getCurrentRoute()->getPath());
		array_pop($page);
		$page = implode("/", $page);

		$source = (Request::header('referer')) ? str_replace("www.", "", parse_url(Request::header('referer'))['host']) : 'direct';

		$hit = HitModel::raw()->findAndModify(
			array('meta' => array('ip' => Request::getClientIp(), 'source' => $source, 'page' => $page)), 
			array('$currentDate' => array( 'updated_at' => true ) ), 
			array('updated_at' => 1),
			array('upsert' => true, 'new' => false)
		);

		Cookie::queue('ref', $user->id, 60*24*7);
		Cookie::queue('source', $source, 60*24*7);
		Cookie::queue('page', $page, 60*24*7);

		$unique_date = ($hit == null) ? false : Carbon::createFromTimeStamp($hit['updated_at']->sec);

		process_ref_url_event($user, $source, $page, $unique_date);
	}
}