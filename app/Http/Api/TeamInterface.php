<?php

namespace App\Http\Api;

interface TeamInterface {

	public function getData();
	public function save($request);
	public function delete($id);
}