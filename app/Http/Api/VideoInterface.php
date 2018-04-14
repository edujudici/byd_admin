<?php

namespace App\Http\Api;

interface VideoInterface
{
	public function getData();
	public function save($request);
	public function delete($id);
}