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
        
        public function getById($id) {
            return Tournament_Master::find($id);
        }
        
	public function getTourByOrgId($org_id){
            return Tournament_Master::selectRaw('*')->where('organization_master_id',$org_id)->get();
	}
        
	public function TourNameExists($org_id,$name){
            return Tournament_Master::selectRaw('count(id) as count')
                ->where('organization_master_id',$org_id)
                ->where('tournament_name',$name)->value('count');
	}
        
        public function SaveTourMaster($data) {
            if(isset($data['id']) && $data['id'] > 0){
                $Tour_Master = Tournament_Master::find($data['id']);
            }else{
                $Tour_Master = new Tournament_Master;
            }
            $Tour_Master->tournament_name = $data['tournament_name'];
            $Tour_Master->tournament_location = $data['tournament_location'];
            $Tour_Master->tournament_logo = $data['tournament_logo'];
            $Tour_Master->organization_master_id = $data['organization_master_id'];
            $Tour_Master->start_date = $data['start_date'];
            $Tour_Master->end_date = $data['end_date'];
            $Tour_Master->reg_start_date = $data['reg_start_date'];
            $Tour_Master->reg_end_date = $data['reg_end_date'];
            $Tour_Master->save();
            
            return $Tour_Master;
        }
}