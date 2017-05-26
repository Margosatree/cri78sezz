<?php

namespace App\Model;
use App\User_Achievement;

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
        public function SaveAchievement($data) {
            if(isset($data['id']) && $data['id'] > 0){
                $User_master = User_Master::find($data['id']);
            }else{
                $User_master = new User_Master;
            }
            $User_master->user_master_id = $data['user_master_id'];
            $User_master->title = $data['title'];
            $User_master->organization_master_id = $data['organization_master_id'];
            $User_master->location = $data['location'];
            $User_master->start_date = $data['start_date'];
            $User_master->end_date = $data['end_date'];
            $User_master->save();
            return $User_master;
        }
}