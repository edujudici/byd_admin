<?php

namespace App\Http\Api;

use App\Http\Api\PartnerInterface;
use App\Models\Partners;

class PartnerServiceImpl implements PartnerInterface {

	private $partner;

	public function __construct(Partners $partner)
	{
		$this->partner = $partner;
	}

	public function getData()
	{
		$partners = $this->partner->all();
		return response()->api($partners);
	}

	private function findById($id)
	{
		return $this->partner->find($id);
	}
	
	public function save($request)
	{

		if (!empty($request->id))
		{
			debug('edit partner');
			$this->partner =  $this->findById($request->id);
		}
		
		if (!empty($request->file))
		{
			$this->partner->PAR_IMAGE_ID = getImageId($request->file);
		}

		$this->partner->PAR_LINK = $request->link;
		$this->partner->save();

		return response()->api($this->partner);
	}

	public function delete($id)
	{

		$partner = $this->findById($id);
		if (is_null($partner))
		{
			return response()->api($company, false, 'Partner not found.');
		}

		$partner->delete();

		return response()->api($partner);
	}
}