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
        // $response = $this->homeI->getData();
    	return view('home');
            // ->with('response', json_encode($response));
    }
}
