<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\AboutInterface;

class AboutController extends Controller
{
    protected $aboutI;
    
    public function __construct(AboutInterface $aboutI)
    {
        $this->aboutI = $aboutI;
    }

    public function show()
    {
        $response = $this->aboutI->getData();               
        return view('about')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->aboutI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->aboutI->delete($req->id);
    }
}
