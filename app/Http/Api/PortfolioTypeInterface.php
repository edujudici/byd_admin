<?php

namespace App\Http\Api;

interface PortfolioTypeInterface
{
	public function getData();
	public function save($request);
	public function delete($id);
}