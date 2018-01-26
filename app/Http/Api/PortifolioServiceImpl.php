<?php

namespace App\Http\Api;

use App\Http\Api\PortfolioInterface;
use App\Models\Portfolio;

class PortfolioServiceImpl implements PortfolioInterface {

	protected $portfolio;
    
    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }
    
    public function getData()
    {
        $data = [
            'portfolio' => $this->portfolio->all()
        ];
        return response()->api($data);
    }
}