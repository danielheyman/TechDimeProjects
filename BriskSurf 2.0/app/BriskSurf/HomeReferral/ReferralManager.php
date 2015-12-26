<?php namespace BriskSurf\HomeReferral;

use BriskSurf\Users\UserModel;
use Cookie;

class ReferralManager extends \BriskSurf\Helpers\BaseManager {

	protected $user;

	public function __construct(UserModel $user)
	{
		$this->user = $user;
	}

	public function addReferralFromCookies()
	{
		if(!Cookie::get('ref')) return $this->setError(true);
		if (is_null( $upline = $this->user->find(Cookie::get('ref'), ['_id']) ) ) return $this->setError(true);

		$upline->increment('referrals', 1);

		register_upline_event($upline);

		return $this;
	}
}