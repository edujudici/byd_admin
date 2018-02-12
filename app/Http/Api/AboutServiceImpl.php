<?php

namespace App\Http\Api;

use App\Http\Api\AboutInterface;
use App\Models\About;

class AboutServiceImpl implements AboutInterface
{

    private $about;

    public function __construct(About $about)
    {
        $this->about = $about;
    }

    public function getData()
    {
        $aboutList = $this->about->all();
        return response()->api($aboutList);
    }

    private function findById($id)
    {
        return $this->about->find($id);
    }
    
    public function save($request)
    {

        if (!empty($request->id))
        {
            debug('edit about ');
            $this->about =  $this->findById($request->id);
        }

        $this->about->ABO_TITLE = $request->title;
        $this->about->ABO_DESCRIPTION = $request->description;
        $this->about->ABO_TYPE = $request->type;
        $this->about->save();

        return response()->api($this->about);
    }

    public function delete($id)
    {

        $about = $this->findById($id);
        if (is_null($about))
        {
            return response()->api($about, false, 'About not found.');
        }

        $about->delete();

        return response()->api($about);
    }
}