<?php

namespace App\Http\Api;

use App\Http\Api\BannerInterface;
use App\Models\Banner;

class BannerServiceImpl implements BannerInterface {

	public function __construct(Banner $banner)
	{
		$this->banner = $banner;
	}

	public function getData()
	{
		$banners = $this->banner->all();
		return response()->api($banners);
	}
	
	public function save($request)
	{
		$banner = empty($request->id) ? new Banner : $this->findById($request->id);
		
		$banner->BAN_IMAGE_ID = 1;//TODO:
		$banner->BAN_TITLE = $request->title;
		$banner->BAN_DESCRIPTION = $request->description;
		$banner->BAN_LINK = $request->link;
		$banner->save();

		return response()->api($banner);
	}

	public function delete($id)
	{

		$banner = $this->findById($id);
		if (is_null($banner))
		{
			return response()->api($company, false, 'Banner not found.');
		}

		$banner->delete();

		return response()->api($banner);
	}
}