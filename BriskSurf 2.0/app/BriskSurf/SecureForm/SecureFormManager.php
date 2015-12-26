<?php namespace BriskSurf\SecureForm;

use BriskSurf\Helpers\Result;

class SecureFormManager
{

	public static function create()
	{
		$cheatForm = new SecureFormModel;
		$cheatForm->solution = rand( 1, 4 );
		$cheatForm->save();
		$url = \URL::to("/secure/form/" . $cheatForm->_id);
		return "<input type='hidden' name='securityURL' value='{$url}'><input type='hidden' name='securityID' value='{$cheatForm->_id}'><input type='hidden' name='security' value='false'>";
	}

	public static function check()
	{
		$securityID = \Input::get('securityID');
		$security = \Input::get('security');
		if($security == 1 || $security == 2 || $security == 3 || $security == 4)
		{
			$cheatForm = SecureFormModel::where('_id', $securityID)->get();
			if($cheatForm->isEmpty())
			{
				return new Result( [ "global" => "#02: An error has occured with the security check"] );
			} 
			else if($cheatForm->first()->solution != $security) return new Result( [ "global" => "You have entered the incorrect value for the security check"] );
			else return new Result( );
			$cheatForm->first()->delete();
		}
		else return new \ResultObject( ["global" => "#01: An error has occured with the security check"] );
	}

	public static function image($id, $number)
	{
		$cheatForm = SecureFormModel::where('_id', $id)->get();
		if($cheatForm->isEmpty()) return false;
		else
		{
			$image = ImageCreate(1, 1); 
			$color = ($cheatForm->first()->solution == $number) ? ImageColorAllocate($image, 52, 152, 219) : ImageColorAllocate($image, 44, 62, 80); 
			ImageFill($image, 0, 0, $color); 
			return $image;
		}
	}
}