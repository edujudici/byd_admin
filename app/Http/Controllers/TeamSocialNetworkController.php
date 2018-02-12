<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\TeamSocialNetworkInterface;

class TeamSocialNetworkController extends Controller
{
    protected $teamI;
    
    public function __construct(TeamSocialNetworkInterface $teamSocialNetworkI)
    {
        $this->teamSocialNetworkI = $teamSocialNetworkI;
    }

    public function show()
    {
        $response = $this->teamSocialNetworkI->getData();               
        return view('teamSocialNetwork')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->teamSocialNetworkI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->teamSocialNetworkI->delete($req->id);
    }
}
