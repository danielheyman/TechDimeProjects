<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	* Default preparation for each test
	*/
	public function setUp()
	{
	    	parent::setUp();
	  
	    	$this->prepareForTests();

	    	$this->mock = $this->mock('Cribbb\Storage\User\UserRepository');
	}
	  
	/**
	* Creates the application.
	*
	* @return Symfony\Component\HttpKernel\HttpKernelInterface
	*/
	public function createApplication()
	{
	    	$unitTesting = true;
	  
	    	$testEnvironment = 'testing';
	  
		return require __DIR__.'/../../bootstrap/start.php';
  	}
	  
  	/**
   	* Migrate the database
   	*/
  	private function prepareForTests()
  	{
	    	Artisan::call('migrate');
  	}
  
	public function mock($class)
	{
  		$mock = Mockery::mock($class);
  		$this->app->instance($class, $mock);
  		return $mock;
	}

	public function tearDown()
	{
  		Mockery::close();
	}

}
