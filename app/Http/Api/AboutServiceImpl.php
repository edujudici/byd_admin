<?php

namespace App\Http\Api;

use App\Http\Api\AboutInterface;
use App\Models\About;
use App\Models\Team;
use App\Models\TeamSocialNetwork;

class AboutServiceImpl implements AboutInterface {

    protected $about;
    protected $team;
	protected $teamSocialNetwork;
    
    public function __construct(About $about, Team $team, TeamSocialNetwork $teamSocialNetwork)
    {
        $this->about = $about;
        $this->team = $team;
        $this->teamSocialNetwork = $teamSocialNetwork;
    }

	public function getData()
    {
        $data = [
            'about' => $this->about->all(),
            'team' => $this->team->with('teamSocialNetwork')->get()
        ];
        return response()->api($data);
    }
}