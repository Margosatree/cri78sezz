<?php

namespace App\Model;
use App\Team_Master;

class TeamMaster_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getAll($id){
		return Team_Master::find($id);
	}

	public function getTeamDetail($usermaster_id){
		return Team_Master::selectRaw('*')->where('team_owner_id',$usermaster_id)->get();
	}

	public function insertOrUpdate($request,$filename,$id=null){
		if(isset($id) && $id >0){
			$Team = $this->getAll($id);
		}else{
			$Team = new Team_Master;
		}
            $Team->team_name = $request->team_name;
            $Team->team_owner_id = $request->team_owner_id;
            $Team->team_type = $request->team_type;
            $Team->order_id = $request->order_id;
            $Team->owner_id = $request->owner_id;
            $Team->team_logo = $filename;
            $Team->save();
            return $Team;
	}

	public function deleteById($id){
		$Team = $this->getAll($id);
		$Team->delete();
	}
}