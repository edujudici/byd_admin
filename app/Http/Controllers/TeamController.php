<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\TeamInterface;

class TeamController extends Controller
{
    protected $teamI;
    
    public function __construct(TeamInterface $teamI)
    {
        $this->teamI = $teamI;
    }

    public function show()
    {
        $response = $this->teamI->getData();               
        return view('team')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->teamI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->teamI->delete($req->id);
    }
}
