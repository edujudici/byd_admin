<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{

	const WHAT_WE_ARE = 1;
	const OUR_HISTORY = 2;
	const WHY_CHOOSE_US = 3;
	const OUR_SERVICES = 4;

    protected $table = 'ABOUT';
    protected $primaryKey = 'ABO_ID';

    public function getTypes()
    {
    	return [
    		['id' => self::WHAT_WE_ARE,   'description' => 'O que nós oferecemos'],
			['id' => self::OUR_HISTORY,   'description' => 'Nossa história'],
			['id' => self::WHY_CHOOSE_US, 'description' => 'Porque escolher nós'],
			['id' => self::OUR_SERVICES,  'description' => 'Nossos Serviços'],
    	];
    }
}
