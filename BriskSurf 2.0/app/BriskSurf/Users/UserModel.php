<?php namespace BriskSurf\Users;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Auth\UserInterface;
use Event;
use Hash;
use Config;

class UserModel extends Eloquent implements UserInterface {

    	public function save(array $options = array())
    	{
    		$changed = $this->isDirty() ? $this->getDirty() : false;

        		parent::save($options);

    		if($changed) Event::fire("user.changed", array($this->id, array_keys($changed)));
    	}

	protected $collection = 'users';

	protected $dates = array('membership_expires', 'membership_credits', 'last_login');

	public function gravatar($size = 50)
	{
		$id = md5($this->email);
		return "http://www.gravatar.com/avatar/{$id}?s={$size}";
	}
	
	public function getFirstName()
	{
		return explode(" ", $this->name)[0];
	}

	public function scopeSearch($query, $term)
	{
		return $query->where("email", $term)->orWhere("_id", $term)->orWhere("username", $term)->orWhere("name", "LIKE", "%{$term}%")->orWhere("login_ip", $term)->orWhere("register_ip", $term)->get();
	}

	public function setEditableInput($key, $value)
	{
		if(isset( Config::get('users::settings_editable')[$key] ))
		{
			$type = Config::get('users::settings_editable')[$key];

			if($type == "date") $value = \Carbon::createFromFormat('Y/m/d H:i', $value);
			else if($type == "bool") $value = (bool) $value;
			else if($type == "number") $value = (int) $value;

			$this->{$key} = $value;
		}
		return $this;
	}

	public function updateFromInput($user_id, $input)
	{
		$user = $this->find($user_id);
		foreach($input as $key => $value) $user = $user->setEditableInput($key, $value);
		$user->save();
	}


	//Relationships
	
	public function websites()
	{
		return $this->hasMany('BriskSurf\Ads\WebsiteModel', 'user_id');
	}
	
	public function banners()
	{
		return $this->hasMany('BriskSurf\Ads\BannerModel', 'user_id');
	}
	
	public function deals()
	{
		return $this->embedsMany('BriskSurf\Payments\DealModel', 'user_id');
	}

	public function subscription()
	{
		return $this->hasMany('BriskSurf\Payments\SubscriptionModel', 'user_id');
	}

	public function lists()
	{
		return $this->hasMany('BriskSurf\Lists\ListUserModel', 'user_id');
	}
	
	
	

	public function action($type, $data = array(), $no_expire = false)
	{
		Event::fire('event.action', array(array(
			'type' => $type,
			'user' => $this->id
		), $data, $no_expire));
	}

	public function counter($type, $options = array(), $no_expire = false)
	{
		Event::fire('event.counter', array(array(
			'type' => $type,
			'user' => $this->id
		), $options, $no_expire));
	}

	public function mega($type, $fields, $completely_unique = array(), $no_expire = false)
	{
		Event::fire('event.mega', array(array(
			'type' => $type,
			'user' => $this->id
		), $fields, $completely_unique, $no_expire));
	}
	
	
	
	
	
	
	
	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword()
	{
		return $this->password;
	}

	public function getRememberToken()
	{
		return $this->rememberToken;
	}

	public function setRememberToken($value)
	{
		$this->rememberToken = $value;
	}
	
	public function getRememberTokenName() {
		return 'remember_token';
	}

}