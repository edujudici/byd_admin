<?php

namespace App\Http\Api;

interface TeamSocialNetworkInterface {

	public function getData();
	public function save($request);
	public function delete($id);
	public function deleteByTeam($teamId);
}