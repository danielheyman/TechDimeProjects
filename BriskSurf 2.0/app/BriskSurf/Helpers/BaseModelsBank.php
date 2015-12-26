<?php namespace BriskSurf\Helpers;

abstract class BaseModelsBank
{
	protected $models;

	public function get($id)
	{
		foreach($this->models as $s)
		{
			if( $s->id == $id) return $s;
		}
		return false;
	}

	public function all()
	{
		return $this->models;
	}
}