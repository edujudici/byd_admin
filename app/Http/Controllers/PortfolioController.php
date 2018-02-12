<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Api\PortfolioInterface;

class PortfolioController extends Controller
{
    protected $portfolioI;
    
    public function __construct(PortfolioInterface $portfolioI)
    {
        $this->portfolioI = $portfolioI;
    }

    public function show()
    {
        $response = $this->portfolioI->getData();               
        return view('portfolio')
            ->with('response', json_encode($response));
    }

    public function save(Request $req)
    {
        return $this->portfolioI->save($req);
    }

    public function delete(Request $req)
    {
        return $this->portfolioI->delete($req->id);
    }
}
