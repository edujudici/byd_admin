<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\ServicesOfferInterface;

class ServicesOfferController extends Controller
{
    protected $servicesOfferI;
    
    public function __construct(ServicesOfferInterface $servicesOfferI)
    {
        $this->servicesOfferI = $servicesOfferI;
    }

    public function show()
    {
        $response = $this->servicesOfferI->getData();               
        return view('servicesOffer')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->servicesOfferI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->servicesOfferI->delete($req->id);
    }
}
