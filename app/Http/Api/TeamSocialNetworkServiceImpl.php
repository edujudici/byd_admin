<?php

namespace App\Http\Api;

use App\Http\Api\TeamSocialNetworkInterface;
use App\Models\TeamSocialNetwork;

class TeamSocialNetworkServiceImpl implements TeamSocialNetworkInterface {

	private $teamSocialNetwork;

	public function __construct(TeamSocialNetwork $socialNetwork)
	{
		$this->socialNetwork = $socialNetwork;
	}

	public function getData()
	{
		$teamServ = app(TeamInterface::class);
		$data['team'] = $teamServ->combobox();
		$data['socialNetworks'] = $this->socialNetwork->all();

		return response()->api($data);
	}

	private function findById($id)
	{
		return $this->socialNetwork->find($id);
	}
	
	public function save($request)
	{

		if (!empty($request->id))
		{
			debug('edit socialNetwork');
			$this->socialNetwork =  $this->findById($request->id);
		}

		$this->socialNetwork->TEA_ID = $request->teamId;
		$this->socialNetwork->TSN_ICON = $request->icon;
		$this->socialNetwork->TSN_LINK = $request->link;
		$this->socialNetwork->save();

		return response()->api($this->socialNetwork);
	}

	public function delete($id)
	{

		$socialNetwork = $this->findById($id);
		if (is_null($teamSocialNetwork))
		{
			return response()->api($socialNetwork, false, 'SocialNetwork not found.');
		}

		$socialNetwork->delete();

		return response()->api($socialNetwork);
	}

	public function deleteByTeam($teamId)
	{
		$this->socialNetwork->where('TEA_ID', $teamId)->delete();
	}
}