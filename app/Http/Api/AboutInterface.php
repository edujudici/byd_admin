<?php

namespace App\Http\Api;

interface AboutInterface
{
	public function getData();
	public function save($request);
	public function delete($id);
}