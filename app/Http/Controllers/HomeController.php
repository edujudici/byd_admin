<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\HomeInterface;

class HomeController extends Controller
{
    protected $homeI;

    public function __construct(HomeInterface $homeI)
    {
        $this->homeI = $homeI;
    }

    public function show()
    {
    	return view('home');
    }

    public function test()
    {

    	$url = 'http://31.220.56.32/image-link/1/b479c6779a09a596';
    	$response = curlMake($url);
    	debug($response);  
    }
}
