<?php

namespace App\Http\Api;

interface ServicesOfferInterface {

	public function getData();
	public function save($request);
	public function delete($id);
}