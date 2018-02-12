<?php

namespace App\Http\Api;

use App\Http\Api\ServicesOfferInterface;
use App\Models\ServicesOffer;

class ServicesOfferServiceImpl implements ServicesOfferInterface {

	private $servicesOffer;

	public function __construct(ServicesOffer $servicesOffer)
	{
		$this->servicesOffer = $servicesOffer;
	}

	public function getData()
	{
		$servicesOffers = $this->servicesOffer->all();
		return response()->api($servicesOffers);
	}

	private function findById($id)
	{
		return $this->servicesOffer->find($id);
	}
	
	public function save($request)
	{

		if (!empty($request->id))
		{
			debug('edit services offer');
			$this->servicesOffer =  $this->findById($request->id);
		}

		$this->servicesOffer->SEO_TITLE = $request->title;
		$this->servicesOffer->SEO_DESCRIPTION = $request->description;
		$this->servicesOffer->SEO_ICON = $request->icon;
		$this->servicesOffer->save();

		return response()->api($this->servicesOffer);
	}

	public function delete($id)
	{

		$serviceOffer = $this->findById($id);
		if (is_null($serviceOffer))
		{
			return response()->api($serviceOffer, false, 'Service Offer not found.');
		}

		$serviceOffer->delete();

		return response()->api($serviceOffer);
	}
}