<?php

namespace App\Http\Api;

interface ServicesInterface
{
	public function getData();
	public function save($request);
	public function delete($id);
}