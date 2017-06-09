<?php

namespace App\Model;
use App\Model\BaseModel\User_Achievement;

class UserAchievement_model {

    public function __construct(){
        //parent::__construct();
    }
        
        public function getAll() {
            return User_Achievement::all();
        }
        public function getAllFilter($where_array = false) {
            if($where_array){
                return User_Achievement::selectRaw('*')->where($where_array)->get();
            }else{
                return User_Achievement::all();
            }
            
        }
        
        public function getById($id) {
            return User_Achievement::find($id);
        }
        
        public function getAchievementByUserMasterId($id) {
            return User_Achievement::selectRaw('*')->where('user_master_id', $id)->get();
        }
        public function getAchievementCountByUserMasterId($id) {
            return User_Achievement::selectRaw('count(id) as count')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
        }
        public function SaveAchievement($request) {
            if(isset($request->update) && $request->update == 1){
                $User_Achievement = User_Achievement::find($request->id);
            }else{
                $User_Achievement = new User_Achievement;
            }
            if(isset($request->user_master_id) && $request->user_master_id){
                $User_Cri_Profile->user_master_id = $request->user_master_id;
            }
            if(isset($request->title) && $request->title){
                $User_Cri_Profile->title = $request->title;
            }
            if(isset($request->organization_master_id) && $request->organization_master_id){
                $User_Cri_Profile->organization_master_id = $request->organization_master_id;
            }
            if(isset($request->location) && $request->location){
                $User_Cri_Profile->location = $request->location;
            }
            if(isset($request->start_date) && $request->start_date){
                $User_Cri_Profile->start_date = $request->start_date;
            }
            if(isset($request->end_date) && $request->end_date){
                $User_Cri_Profile->end_date = $request->end_date;
            }
            $User_Achievement->save();
            return $User_Achievement;
        }
}