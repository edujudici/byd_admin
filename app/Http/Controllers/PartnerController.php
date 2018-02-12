<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\PartnerInterface;

class PartnerController extends Controller
{
    protected $partnerI;
    
    public function __construct(PartnerInterface $partnerI)
    {
        $this->partnerI = $partnerI;
    }

    public function show()
    {
        $response = $this->partnerI->getData();               
        return view('partners')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->partnerI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->partnerI->delete($req->id);
    }
}
