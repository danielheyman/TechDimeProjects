<?php namespace BriskSurf\SecureForm;

class SecureFormController extends \BriskSurf\Helpers\BaseController
{
	public function getImage($id, $number)
	{
		$image = \SecureForm::image($id, $number);
		if($image == false) return [ "error" => "Secure Form not found" ];

		header('Content-Type: image/png');
		imagepng($image);
		imagedestroy($image);
		return false;
	}

}