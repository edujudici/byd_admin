<?php

namespace App\Http\Api;

interface BannerInterface
{
	public function getData();
	public function save($request);
	public function delete($id);
}