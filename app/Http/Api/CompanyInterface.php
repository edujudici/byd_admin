<?php

namespace App\Http\Api;

interface CompanyInterface {

	public function getData();
	public function save($request);
}