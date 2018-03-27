<?php

namespace App\Http\Api;

use App\Http\Api\PortfolioTypeInterface;
use App\Models\PortfolioType;

class PortfolioTypeServiceImpl implements PortfolioTypeInterface
{

    private $portfolioType;

    public function __construct(PortfolioType $portfolioType)
    {
        $this->portfolioType = $portfolioType;
    }

    public function getData()
    {
        $portfolioTypeList = $this->portfolioType->all();
        return response()->api($portfolioTypeList);
    }

    private function findById($id)
    {
        return $this->portfolioType->find($id);
    }
    
    public function save($request)
    {

        if (!empty($request->id))
        {
            debug('edit portfolio type');
            $this->portfolioType =  $this->findById($request->id);
        }

        $this->portfolioType->POT_TITLE = $request->title;
        $this->portfolioType->save();

        return response()->api($this->portfolioType);
    }

    public function delete($id)
    {

        $portfolioType = $this->findById($id);
        if (is_null($portfolioType))
        {
            return response()->api($portfolioType, false, 'Portfolio type not found.');
        }

        $portfolioType->delete();

        return response()->api($portfolioType);
    }
}