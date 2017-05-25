<?php

namespace App\Model;
use App\Tournament_Master;

class TournamentMaster_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getId($org_id,$Tournament){
		return Tournament_Master::selectRaw('id')
                    ->where('organization_master_id',$org_id)
                    ->where('id',$Tournament)->get();
	}
}