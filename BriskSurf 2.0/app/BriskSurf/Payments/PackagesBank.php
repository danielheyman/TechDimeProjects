<?php namespace BriskSurf\Payments;

class PackagesBank extends \BriskSurf\Helpers\BaseModelsBank
{
	public function __construct()
	{
		$this->models  = PackageModel::all();
	}
}