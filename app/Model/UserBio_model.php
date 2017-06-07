<?php

namespace App\Model;
use App\Model\BaseModel\UserBio;

class UserBio_model {

	public function __construct(){
		//parent::__construct();
	}
        
        public function getBioByUserMasterId($id) {
            return User_Cricket_Profile::selectRaw('*')->where('user_master_id', $id)->get()->first();
        }
}