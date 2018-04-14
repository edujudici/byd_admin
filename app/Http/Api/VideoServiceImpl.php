<?php

namespace App\Http\Api;

use App\Http\Api\VideoInterface;
use App\Models\Video;

class VideoServiceImpl implements VideoInterface
{

    private $portfolioType;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function getData()
    {
        $videoList = $this->video->all();
        return response()->api($videoList);
    }

    private function findById($id)
    {
        return $this->video->find($id);
    }
    
    public function save($request)
    {

        if (!empty($request->id))
        {
            debug('edit video');
            $this->video =  $this->findById($request->id);
        }

        $this->video->VID_TITLE = $request->title;
        $this->video->VID_DESCRIPTION = $request->description;
        $this->video->VID_URL = $request->url;
        $this->video->save();

        return response()->api($this->video);
    }

    public function delete($id)
    {

        $video = $this->findById($id);
        if (is_null($video))
        {
            return response()->api($video, false, 'Video not found.');
        }

        $video->delete();

        return response()->api($video);
    }
}