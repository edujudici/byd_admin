<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\HomeInterface;

class DashboardController extends Controller
{
    protected $homeI;

    public function __construct(HomeInterface $homeI)
    {
        $this->homeI = $homeI;
    }

    public function show()
    {
    	return view('dashboard');
    }
}