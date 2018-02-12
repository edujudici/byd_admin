<?php

namespace App\Http\Api;

interface PortfolioInterface
{
	public function getData();
	public function save($request);
	public function delete($id);
}