<?php namespace BriskSurf\Settings;

class SettingsBank extends \BriskSurf\Helpers\BaseModelsBank
{
	public function __construct()
	{
		$this->models  = SettingsModel::all();
	}
}