<?php

namespace App\Http\Api;

use App\Http\Api\ServicesInterface;
use App\Models\Services;

class ServicesServiceImpl implements ServicesInterface
{

    private $services;

	public function __construct(Services $services)
    {
        $this->services = $services;
    }

    public function getData()
    {
        $services = $this->services->all();
        return response()->api($services);
    }

    private function findById($id)
    {
        return $this->services->find($id);
    }
    
    public function save($request)
    {

        if (!empty($request->id))
        {
            debug('edit services ');
            $this->services =  $this->findById($request->id);
        }

        $this->services->SER_TITLE = $request->title;
        $this->services->SER_DESCRIPTION = $request->description;
        $this->services->SER_ICON = $request->icon;
        $this->services->save();

        return response()->api($this->services);
    }

    public function delete($id)
    {

        $service = $this->findById($id);
        if (is_null($service))
        {
            return response()->api($service, false, 'Service not found.');
        }

        $service->delete();

        return response()->api($service);
    }
}