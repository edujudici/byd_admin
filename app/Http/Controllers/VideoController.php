<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\VideoInterface;

class VideoController extends Controller
{
    protected $videoI;
    
    public function __construct(VideoInterface $videoI)
    {
        $this->videoI = $videoI;
    }

    public function show()
    {
        $response = $this->videoI->getData();               
        return view('video')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->videoI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->videoI->delete($req->id);
    }
}
