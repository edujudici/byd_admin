<?php

namespace App\Http\Api;

use App\Http\Api\TeamSocialNetworkInterface;
use App\Models\TeamSocialNetwork;

class TeamSocialNetworkServiceImpl implements TeamSocialNetworkInterface {

	private $teamSocialNetwork;

	public function __construct(TeamSocialNetwork $teamSocialNetwork)
	{
		$this->teamSocialNetwork = $teamSocialNetwork;
	}

	public function getData()
	{
		$teamSocialNetworkList = $this->teamSocialNetwork->all();
		return response()->api($teamSocialNetworkList);
	}

	private function findById($id)
	{
		return $this->teamSocialNetwork->find($id);
	}
	
	public function save($request)
	{

		if (!empty($request->id))
		{
			debug('edit teamSocialNetwork');
			$this->teamSocialNetwork =  $this->findById($request->id);
		}

		$this->teamSocialNetwork->TEA_ID = $request->teamId;
		$this->teamSocialNetwork->TSN_ICON = $request->icon;
		$this->teamSocialNetwork->TSN_LINK = $request->link;
		$this->teamSocialNetwork->save();

		return response()->api($this->teamSocialNetwork);
	}

	public function delete($id)
	{

		$teamSocialNetwork = $this->findById($id);
		if (is_null($teamSocialNetwork))
		{
			return response()->api($teamSocialNetwork, false, 'TeamSocialNetwork not found.');
		}

		$teamSocialNetwork->delete();

		return response()->api($teamSocialNetwork);
	}
}