<?php namespace BriskSurf\Lists;

use Jenssegers\Mongodb\Model as Eloquent;

class ListModel extends Eloquent {

	protected $collection = 'lists';

	public function delete()
	{
		$this->users->where('list_id', $list->id)->delete();
		parent::delete();
	}

	public function users()
	{
		return $this->hasMany('App\BriskSurf\Lists\ListUser', 'list_id');
	}

	public function updateFromInput($input)
	{
		if($this->status == "process" || $this->status == "processing") return Redirect::to('admin/lists/' . $id);

		$data = json_decode($input['data']);

		foreach($data as $and_key => $and_value)
		{
			foreach($and_value as $or_key => $or_value)
			{
				$or_value = (array) $or_value;
				if($or_value["type"] == "attribute")
				{
					if(is_numeric($or_value["value"])) $or_value["value"] = floatval($or_value["value"]);
				}
				$data[$and_key][$or_key] = $or_value;
			}
		}

		$this->data = $data;
		$this->name = ($input['name'] == "") ? 'Why you no name me? :(' :$input['name'];
		$this->status = "process";
		$this->save();
	}
}
