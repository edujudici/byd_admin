<?php

namespace App\Http\Api;

use App\Http\Api\HomeInterface;
use App\Models\Banner;
use App\Models\ServicesOffer;
use App\Models\Partners;

class HomeServiceImpl implements HomeInterface
{
    	
	protected $banner;
    protected $servicesOffer;
    protected $partners;
    
    public function __construct(Banner $banner, ServicesOffer $servicesOffer, Partners $partners)
    {
        $this->banner = $banner;
        $this->servicesOffer = $servicesOffer;
        $this->partners = $partners;
    }
    
    public function getData()
    {
        $data = [
            'banners' => $this->banner->all(),
            'servicesOffer' => $this->servicesOffer->all(),
            'partners' => $this->partners->all(),
        ];
        return response()->api($data);
    }
}