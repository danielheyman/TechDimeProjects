<?php namespace BriskSurf\Payments;

use Jenssegers\Mongodb\Model as Eloquent;

class PackageModel extends Eloquent {

    	protected $collection = 'packages';

    	public function updateFromInput($input)
    	{
    		$this->name = $input['name'];
		$this->cost = floatval($input['cost']);
		$this->renew = ($input['renew2'] == "none" ) ? "none" : $input['renew1'] . " " . $input['renew2'];
		$this->trial = ($input['trial2'] == "none" ) ? "none" : $input['trial1'] . " " . $input['trial2'];
		$this->type = $input['type'];
		if($this->type == "credit")
		{
			$this->value = (int) $input['value_credit'];
			$this->value = $input['value_credit'];
			$this->active = $input['active_credit'];
		}
		else
		{
			$this->value = $input['value_membership'];
			$this->value = $input['value_membership'];
			if($input['active_membership'] != "false" && $this->active != $input['active_membership'])
			{
				$package_active = $this->where('active', $input['active_membership'])->first(["_id"]);
				if($package_active != null) return ['global' => "A package is already active to " . $input['active_membership'] ];
			}

			$this->active = $input['active_membership'];
		}
		
		$this->save();

		return false;
    	}

    	public function deal()
	{
		return $this->hasMany('Deal');
	}

}