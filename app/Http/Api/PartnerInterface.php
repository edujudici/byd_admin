<?php

namespace App\Http\Api;

interface PartnerInterface {

	public function getData();
	public function save($request);
	public function delete($id);
}