<?php namespace BriskSurf\Help;

use URL;
use View;
use Settings;

class HelpController extends \BriskSurf\Helpers\BaseController 
{
	public function __construct()
	{
		parent::getNotifications();
	}

	public function getList($type)
	{
		$list = Settings::get($type)->list;

		$list = array_map( function($x) {
			$x = str_replace("#LIST#", "<ul>", $x);
			$x = str_replace("#ENDLIST#", "</ul>", $x);
			$x = str_replace("#BULLET#", "<li>", $x);
			$x = str_replace("#ENDBULLET#", "</li>", $x);
			$x = str_replace("#ENDLINK#", "</a>", $x);


			$x = preg_replace_callback("/#LINK=(.*)#/", function($matches) {
				return "<a href='" . URL::to( strtolower($matches[1]) ) . "'>";
			}, $x);

			return $x;
		}, $list);

		foreach($list as $key => $value)
		{
			$list[str_replace("_", " ", $key)] = $value;
			unset($list[$key]);
		}
		
		return View::make("templates.list")->with('list', $list);
	}
}