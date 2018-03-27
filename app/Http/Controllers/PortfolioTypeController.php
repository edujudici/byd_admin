<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\PortfolioTypeInterface;

class PortfolioTypeController extends Controller
{
    protected $portfolioTypeI;
    
    public function __construct(PortfolioTypeInterface $portfolioTypeI)
    {
        $this->portfolioTypeI = $portfolioTypeI;
    }

    public function show()
    {
        $response = $this->portfolioTypeI->getData();               
        return view('portfolioType')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->portfolioTypeI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->portfolioTypeI->delete($req->id);
    }
}
