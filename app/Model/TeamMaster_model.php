<?php

namespace App\Model;
use App\Team_Master;

class TeamMaster_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getTeamDetail($usermaster_id){
		return Team_Master::selectRaw('*')->where('team_owner_id',$usermaster_id)->get();
	}
}