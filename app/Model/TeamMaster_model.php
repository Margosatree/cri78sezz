<?php

namespace App\Model;
use App\Model\BaseModel\Team_Master;

class TeamMaster_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getAll(){
            return Team_Master::all();
	}
        
	public function getById($id){
            return Team_Master::find($id);
	}

	public function getTeamDetail($organization_master_id){
            return Team_Master::selectRaw('*')->where('owner_id',$organization_master_id)->get();
	}
	public function getTeamByOrg($organization_master_id){
            return Team_Master::selectRaw('*')->where('owner_id',$organization_master_id)->get();
	}

	public function SaveTeam($request){
            if(isset($request->update) && $request->update == 1){
                $Team = Team_Master::find($request->id);
            }else{
                $Team = new Team_Master;
            }
            $Team->team_name = $request->team_name;
            $Team->team_owner_id = $request->team_owner_id;
            $Team->team_type = $request->team_type;
            $Team->order_id = $request->order_id;
            $Team->owner_id = $request->owner_id;
            $Team->team_logo = $request->team_logo;
            $Team->save();
            return $Team;
	}

	public function deleteById($id){
            $Team = Team_Master::find($id);
            $Team->delete();
	}
}