<?php

namespace App\Model;
use App\User_Achievement;

class UserAchievement_model {

	public function __construct(){
		//parent::__construct();
	}
        
        public function getAchievementByUserMasterId($id) {
            return User_Achievement::selectRaw('*')->where('user_master_id', $id)->get();
        }
        
}