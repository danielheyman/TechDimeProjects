<?php namespace BriskSurf\Helpers;

abstract class BaseManager extends Result {

	public function __construct()
	{

	}

	public function setError($errors)
	{
		parent::__construct($errors);

		return $this;
	}

}