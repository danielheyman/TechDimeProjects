<?php namespace BriskSurf\Helpers;

class Result {
	
	protected $errors = null;

	public function __construct($data = null) 
	{
		if( ($data != null && $data != "") || (is_array($data) && count($data) != 0)) $this->errors = $data;
	}

	public function passes()
	{
		return ($this->errors == null);   
	}

	public function fails()
	{
		return !$this->passes();
	}

	public function errors()
	{
		return $this->errors;   
	}
}