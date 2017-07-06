<?php

namespace App\Model;
use App\Model\BaseModel\Team_Members;

class TeamMembers_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getAll(){
            return Team_Members::all();
	}
	public function getById($id){
            return Team_Members::find($id);
	}
        public function getWhereQuery($where_array){
            return Team_Members::where($where_array)->first();
	}
        public function getIdByWhereQuery($where_array){
            return Team_Members::where($where_array)->value('id');
	}
        public function getCountByWhereQuery($where_array){
            return Team_Members::where($where_array)->count();
	}

	public function SaveTeamMembers($request){
//            dd($request->all());
            if(isset($request->update) && $request->update == 1){
                $Team_Member = $this->getById($request->id);
            }else{
                $Team_Member = new Team_Members;
            }
            if(isset($request->team_id) && $request->team_id){
                $Team_Member->team_id = $request->team_id;
            }
            if(isset($request->user_master_id) && $request->user_master_id){
                $Team_Member->user_master_id = $request->user_master_id;
            }
            if(isset($request->tournament_id) && $request->tournament_id){
                $Team_Member->tournament_id = $request->tournament_id;
            }
            if(isset($request->selected_as) && $request->selected_as){
                $Team_Member->selected_as = $request->selected_as;
            }
            $Team_Member->save();
            return $Team_Member;
	}

	public function deleteById($id){
            $team_member_id = $this->getById($id);
            return $team_member_id->delete();
	}
}