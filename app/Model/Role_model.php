<?php

namespace App\Model;
use App\Role;

class Role_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getPlayerId(){
		return Role::where('slug','player')->first();
	}
}