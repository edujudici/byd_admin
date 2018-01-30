<?php

	//commands generate structure project
	//php artisan make:auth
	//php artisan migrate
	//php artisan make:seeder <seeder name>
	//php artisan migrate --seed
	//php artisan make:model <model name>
	//php artisan make:controller <controller name>
	//php artisan make:request <form request name>
	//php artisan make:provider <service provider name>
	
	//icons
	//http://fontawesome.io/3.2.1/icons/
	

	function debug($var)
	{
  		if(is_string($var)) {
		    \Log::debug('<START DEBUG>');
		   	\Log::debug($var);
		   	\Log::debug('<END DEBUG>');
  		} else {
		    \Log::debug('<START DEBUG>');
		    \Log::debug(var_export($var, true));
		    \Log::debug('<END DEBUG>');
  		}
	}

	function getImage($id)
	{

		$url = config('app.repo_link');
		$token = config('app.repo_token');

		$completeUrl = $url.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.$token;

		return file_get_contents('http://31.220.56.32/image-link/1/b479c6779a09a596');
	}

	function curlMake()
	{
		try {
			
			$curl = new App\Http\CurlApi($completeUrl, array(
			    //CURLOPT_POSTFIELDS => array('username' => 'user1')
			)); 

			debug($curl);

			return $curl;
		} catch (\RuntimeException $ex) {
		    die(sprintf('Http error %s with code %d', $ex->getMessage(), $ex->getCode()));
		}
	}
