<?php namespace BriskSurf\Helpers;

abstract class BaseValidationResult extends Result{
	
	protected $input;
	protected $ran = false;

	public function __construct($data = null)
	{
		$this->input = \Input::all();
		if($data != null) $this->addInput($data);
	}

	public function addInput($data)
	{
		$this->input = array_merge($this->input, $data);

		return $this;
	}

	public function input($name = null)
	{
		return ($name === null) ? $this->input : $this->input[$name];
	}

	public function error($data = null)
	{
		parent::__construct($data);
	}

	public abstract function validate();
	
	public function passes()
	{
		if($this->ran == false)
		{
			$this->validate();
			$this->ran = true;
		}
		return parent::passes();
	}

	public function fails()
	{
		return !$this->passes();
	}
}