<?php

namespace App\Model;
use App\Model\BaseModel\Tournament_Master;

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
        
    public function TourNameExists($org_id,$name,$notinuserid = null){
            if(isset($notinuserid) && $notinuserid){
                return Tournament_Master::selectRaw('count(id) as count')
                ->where('id','!=',$notinuserid)
                ->where('organization_master_id',$org_id)
                ->where('tournament_name',$name)->value('count');
            }else{
                return Tournament_Master::selectRaw('count(id) as count')
                ->where('organization_master_id',$org_id)
                ->where('tournament_name',$name)->value('count');
            }
    }
        
        public function SaveTourMaster($request) {
            if(isset($request->update) && $request->update == 1){
                $Tour_Master = Tournament_Master::find($request->id);
            }else{
                $Tour_Master = new Tournament_Master;
            }
            $Tour_Master->tournament_name = $request->tournament_name;
            $Tour_Master->tournament_location = $request->tournament_location;
            if(isset($request->tournament_logo) && $request->tournament_logo){
                $Tour_Master->tournament_logo = $request->tournament_logo;
            }
            $Tour_Master->organization_master_id = $request->organization_master_id;
            $Tour_Master->start_date = $request->start_date;
            $Tour_Master->end_date = $request->end_date;
            $Tour_Master->reg_start_date = $request->reg_start_date;
            $Tour_Master->reg_end_date = $request->reg_end_date;
            $Tour_Master->save();
            
            return $Tour_Master;
        }
}