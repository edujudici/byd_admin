<?php

namespace App\Http\Api;

use App\Http\Api\CompanyInterface;
use App\Models\Company;

class CompanyServiceImpl implements CompanyInterface {

	private $company;

	public function __construct(Company $company)
	{
		$this->company = $company;
	}

	public function getData()
	{
		$company = $this->company->first();
		return response()->api($company);
	}
	
	public function save($request)
	{
		if (!empty($request->id))
		{
			debug('edit company');
			$this->company =  $this->company->find($request->id);
		}

		if (!empty($request->file))
		{
			$this->company->COM_IMAGE_ID  = getImageId($request->file);
		}

		$this->company->COM_ADDRESS   = $request->address;             
		$this->company->COM_EMAIL     = $request->email;           
		$this->company->COM_TELEPHONE = $request->telephone;               
		$this->company->COM_IFRAME    = $request->iframe;            
		$this->company->save();

		return response()->api($this->company);
	}
}