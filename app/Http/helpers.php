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

	function curlMake($url, $type = null, $options = [])
	{
		try {
			
			// $curl = new App\Http\CurlApi($url, array(
			//     //CURLOPT_POSTFIELDS => array('username' => 'user1')
			// ));

			$curl = new App\Http\CurlApi($url, $type, $options); 
			return $curl->response;
		} catch (\RuntimeException $ex) {
		    die(sprintf('Http error %s with code %d', $ex->getMessage(), $ex->getCode()));
		}
	}

	function getImageId($file)
	{

		$url = config('app.repo_get_id');
		$token = config('app.repo_token');
		
		$name = $file->getClientOriginalName();
		$mimetype = 'image/'.$file->getClientOriginalExtension();

		$options = [
			'token' => $token,
			'file' => curl_file_create($file, $mimetype, $name)
		];

    	$response = json_decode(curlMake($url, 'POST', $options));

    	debug(["======================== response curl ================================"]);
    	debug($response);

    	
    	return $response->data;
	}