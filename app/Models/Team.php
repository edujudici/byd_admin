<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'TEAM';
    protected $primaryKey = 'TEA_ID';

    public function teamSocialNetwork()
    {
    	return $this->hasMany('App\Models\TeamSocialNetwork', 'TEA_ID');
    }
}