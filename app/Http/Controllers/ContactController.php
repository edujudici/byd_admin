<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\ContactInterface;

class ContactController extends Controller
{
    protected $contactI;
    
    public function __construct(ContactInterface $contactI)
    {
        $this->contactI = $contactI;
    }

    public function show()
    {
        $response = $this->contactI->getData();               
        return view('contact')
            ->with('response', json_encode($response));
    }
}
