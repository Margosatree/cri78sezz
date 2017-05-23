<?php

namespace App\Model;
use App\User_Master;

class UserMaster_model {

	public function __construct(){
		//parent::__construct();
	}

	public static function getAll(){
		return User_Master::all();
	}

	public function getValueByEmail($user_email){
		if(is_numeric($user_email)){
			return User_Master::where('phone',$user_email)->get();
		}else{
			return User_Master::where('email',$user_email)->get();
		}
		
	}

	public function insert($data){
		$User_master = new User_Master;
        $User_master->username = $data['username'];
        $User_master->phone = $data['phone'];
        $User_master->email = $data['email'];
        return $User_master->save();
     }


}