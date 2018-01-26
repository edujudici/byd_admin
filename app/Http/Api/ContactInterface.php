<?php

namespace App\Http\Api;

interface ContactInterface
{
	public function getData();
	public function send($request);
}