<?php

namespace App\Http\Api;

use App\Http\Api\TeamInterface;
use App\Models\Team;

class TeamServiceImpl implements TeamInterface {

	private $team;

	public function __construct(Team $team)
	{
		$this->team = $team;
	}

	public function combobox()
	{
		return $this->team
			->select('TEA_ID as id', 'TEA_NAME as description')
			->get();
	}

	public function getData()
	{
		$team = $this->team->all();
		return response()->api($team);
	}

	private function findById($id)
	{
		return $this->team->find($id);
	}
	
	public function save($request)
	{

		if (!empty($request->id))
		{
			debug('edit team');
			$this->team =  $this->findById($request->id);
		}

		if (!empty($request->file))
		{
			$this->team->TEA_IMAGE_ID = getImageId($request->file);
		}
		
		$this->team->TEA_NAME = $request->name;
		$this->team->TEA_DESCRIPTION = $request->description;
		$this->team->save();

		return response()->api($this->team);
	}

	public function delete($id)
	{

		$socialNetworkI = app(TeamSocialNetworkInterface::class);
		$socialNetworkI->deleteByTeam($id);

		$person = $this->findById($id);
		if (is_null($person))
		{
			return response()->api($person, false, 'Team not found.');
		}

		$person->delete();

		return response()->api($person);
	}
}