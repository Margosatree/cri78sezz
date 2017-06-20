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
        public function TeamNameExistsByOwner($organization_master_id,$team_name){
            return Team_Master::selectRaw('*')
                    ->where('team_name',$team_name)
                    ->where('owner_id',$organization_master_id)->first();
	}
	public function getTeamDetail($organization_master_id){
            return Team_Master::selectRaw('*')->where('owner_id',$organization_master_id)->get();
	}
	public function getTeamByOrg($organization_master_id){
            return Team_Master::selectRaw('id')->where('owner_id',$organization_master_id)->get();
	}

	public function SaveTeam($request){
//            dd($request->all());
            if(isset($request->update) && $request->update == 1){
                $Team = Team_Master::find($request->id);
            }else{
                $Team = new Team_Master;
            }
            if(isset($request->team_name) && $request->team_name){
                $Team->team_name = $request->team_name;
            }
            if(isset($request->team_owner_id) && $request->team_owner_id){
                $Team->team_owner_id = $request->team_owner_id;
            }
            if(isset($request->team_type) && $request->team_type){
                $Team->team_type = $request->team_type;
            }
            if(isset($request->order_id) && $request->order_id){
                $Team->order_id = $request->order_id;
            }
            if(isset($request->owner_id) && $request->owner_id){
                $Team->owner_id = $request->owner_id;
            }
            if(isset($request->team_logo) && $request->team_logo){
                $Team->team_logo = $request->team_logo;
            }
            $Team->save();
            return $Team;
	}

	public function deleteById($id){
            return Team_Master::find($id);
	}
}