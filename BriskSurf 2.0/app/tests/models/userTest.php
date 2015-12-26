<?php

class UserTest extends TestCase {

	public function testAir()
	{
		$this->assertTrue(true);
	}
	/*public function testRegister()
	{
		User::truncate();

		$check = new UserChecker(array(
			'username' => 'hello27!',
			'name' => 'hello',
			'email' => 'poopgmail.com',
			'password' => 'hello'
		));
        		$check = $check->register();
        		$this->assertFalse($check->passes());
        		$errors = $check->error()->messages();

        		$this->assertCount(4, $check->error()->messages());
        		$this->assertEquals($errors->first('username'), "The username may only contain letters and numbers.");
        		$this->assertEquals($errors->first('name'), "The name format is invalid.");
        		$this->assertEquals($errors->first('email'), "The email must be a valid email address.");
        		$this->assertEquals($errors->first('password'), "The password and password confirmation must match.");
        		

        		$user = new User;
        		$user->username = 'test';
            	$user->name = 'daniel heyman';
        		$user->email = 'daniel@gmail.com';
        		$user->password = Hash::make('pasword');
        		 $this->assertTrue($user->save());
        		
        		$code = str_random(6);
        		$user->activation = $code;
        		$this->assertTrue($user->save());

		$check = new UserChecker(array(
			'username' => 'test',
			'name' => 'daniel heyman',
			'email' => 'daniel@gmail.com',
			'password' => 'password',
			'password_confirmation' => 'password'
		));
        		$check = $check->register();
        		$this->assertFalse($check->passes());
        		$errors = $check->error()->messages();

        		$this->assertCount(2, $check->error()->messages());
        		$this->assertEquals($errors->first('username'), "The username has already been taken.");
        		$this->assertEquals($errors->first('email'), "The email has already been taken.");
	}	*/

}

