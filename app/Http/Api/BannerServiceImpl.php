<?php

namespace App\Http\Api;

use App\Http\Api\BannerInterface;
use App\Models\Banner;

class BannerServiceImpl implements BannerInterface
{

	private $banner;

	public function __construct(Banner $banner)
	{
		$this->banner = $banner;
	}

	public function getData()
	{
		$banners = $this->banner->all();
		return response()->api($banners);
	}

	private function findById($id)
	{
		return $this->banner->find($id);
	}
	
	public function save($request)
	{

		if (!empty($request->id))
		{
			debug('edit banner');
			$this->banner =  $this->findById($request->id);
		}

		if (!empty($request->file))
		{
			$this->banner->BAN_IMAGE_ID = getImageId($request->file);
		}

		$this->banner->BAN_TITLE = $request->title;
		$this->banner->BAN_DESCRIPTION = $request->description;
		$this->banner->BAN_LINK = $request->link;
		$this->banner->save();

		return response()->api($this->banner);
	}

	public function delete($id)
	{

		$banner = $this->findById($id);
		if (is_null($banner))
		{
			return response()->api($banner, false, 'Banner not found.');
		}

		$banner->delete();

		return response()->api($banner);
	}
}