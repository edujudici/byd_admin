<?php

namespace App\Http\Api;

use App\Http\Api\ServicesInterface;
use App\Models\Services;

class ServicesServiceImpl implements ServicesInterface
{
	protected $services;
    
    public function __construct(Services $services)
    {
        $this->services = $services;
    }
    
    public function getData()
    {
        $data = [
            'services' => $this->services->all()
        ];
        return response()->api($data);
    }
}