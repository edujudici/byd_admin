<?php

namespace App\Http\Api;

use App\Http\Api\PortfolioInterface;
use App\Models\Portfolio;

class PortfolioServiceImpl implements PortfolioInterface
{

    private $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    public function getData()
    {
        $portfolioList = $this->portfolio->all();
        return response()->api($portfolioList);
    }

    private function findById($id)
    {
        return $this->portfolio->find($id);
    }
    
    public function save($request)
    {

        if (!empty($request->id))
        {
            debug('edit portfolio');
            $this->portfolio =  $this->findById($request->id);
        }

        if (!empty($request->file))
        {
            $this->portfolio->POR_IMAGE_ID = getImageId($request->file);
        }

        $this->portfolio->POR_TITLE = $request->title;
        $this->portfolio->POR_DESCRIPTION = $request->description;
        $this->portfolio->save();

        return response()->api($this->portfolio);
    }

    public function delete($id)
    {

        $portfolio = $this->findById($id);
        if (is_null($portfolio))
        {
            return response()->api($portfolio, false, 'Portfolio not found.');
        }

        $portfolio->delete();

        return response()->api($portfolio);
    }
}