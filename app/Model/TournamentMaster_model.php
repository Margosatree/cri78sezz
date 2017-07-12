<?php

namespace App\Model;
use App\Model\BaseModel\Tournament_Master;

class TournamentMaster_model {

    public function __construct(){
        //parent::__construct();
    }

    public function getId($org_id,$Tournament){
            return Tournament_Master::select('id')
                ->where('organization_master_id',$org_id)
                ->where('id',$Tournament)->get();
    }
        
    public function getById($id) {
        return Tournament_Master::find($id);
    }
    
    public function deleteById($id) {
        return Tournament_Master::find($id)->delete();
    }
        
    public function getTourByOrgId($org_id){
            return Tournament_Master::where('organization_master_id',$org_id)->get();
    }
    
    public function getOrgIDByTourId($id){
            return Tournament_Master::where('id',$id)->value('organization_master_id');
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
//            dd($request->all());
            if(isset($request->update) && $request->update == 1){
                $Tour_Master = Tournament_Master::find($request->id);
            }else{
                $Tour_Master = new Tournament_Master;
            }
            if(isset($request->tournament_name) && $request->tournament_name){
                $Tour_Master->tournament_name = $request->tournament_name;
            }
            if(isset($request->tournament_location) && $request->tournament_location){
                $Tour_Master->tournament_location = $request->tournament_location;
            }
            if(isset($request->tournament_logo) && $request->tournament_logo){
                $Tour_Master->tournament_logo = $request->tournament_logo;
            }
            if(isset($request->organization_master_id) && $request->organization_master_id){
                $Tour_Master->organization_master_id = $request->organization_master_id;
            }
            if(isset($request->start_date) && $request->start_date){
                $Tour_Master->start_date = $request->start_date;
            }
            if(isset($request->end_date) && $request->end_date){
                $Tour_Master->end_date = $request->end_date;
            }
            if(isset($request->reg_start_date) && $request->reg_start_date){
                $Tour_Master->reg_start_date = $request->reg_start_date;
            }
            if(isset($request->reg_end_date) && $request->reg_end_date){
                $Tour_Master->reg_end_date = $request->reg_end_date;
            }
            $Tour_Master->save();
            
            return $Tour_Master;
        }

        public function getMyTourDetails($user_master_id){
            return Tournament_Master::leftJoin('team_members AS tm'
                                        ,'tm.tournament_id','=','tournament_master.id')
                                    ->where('tm.user_master_id','=',$user_master_id)
                                    ->get();
        }
}