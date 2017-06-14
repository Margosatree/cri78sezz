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
            $User_Achievement->user_master_id = $request->user_master_id;
            $User_Achievement->title = $request->title;
            $User_Achievement->organization_master_id = $request->organization_master_id;
            $User_Achievement->location = $request->location;
            $User_Achievement->start_date = $request->start_date;
            $User_Achievement->end_date = $request->end_date;
            $User_Achievement->save();
            return $User_Achievement;
        }
}