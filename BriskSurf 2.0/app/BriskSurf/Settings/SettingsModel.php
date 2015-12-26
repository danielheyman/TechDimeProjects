<?php namespace BriskSurf\Settings;

use Jenssegers\Mongodb\Model as Eloquent;
use Setting;

class SettingsModel extends Eloquent {

    	public $timestamps = false;
    	
    	protected $collection = 'settings';

	public function setKeyValue($key, $value)
	{
		if( substr($key, 0, 7) == 'array__' )
		{
			$key = explode("__", $key);
			$key_name = $key;
			unset($key_name[0]);
			unset($key_name[1]);
			$key_name = implode($key_name, "_");

			$settingsArray = $this->{$key[1]};

			if(is_numeric($settingsArray[$key_name])) $value = floatval($value);
			else if(is_bool($settingsArray[$key_name])) $value = ($value == "true") ? true : false;

			$settingsArray[$key_name] = $value;
			$this->{$key[1]} = $s;
		}
		else
		{
			if(is_numeric($this->{$key})) $value = floatval($value);
			else if(is_bool($this->{$key})) $value = ($value == "true") ? true : false;

			$this->{$key} = $value;
		}

		return $this;
	}

    	public function updateFromInput($input)
    	{
		$setting = $this->find($input["id"]);
		unset($input["id"]);

		foreach($input as $key => $value) $settings = $setting->setKeyValue($key, $value);

		$setting->save();
    	}

}