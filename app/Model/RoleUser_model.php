<?php

namespace App\Model;
use App\role_user;

class RoleUser_model {

	public function __construct(){
		//parent::__construct();
	}

	public function insert($user_id,$role_id){
		$user_role = new role_user;
	    $user_role->user_id = $user_id;
	    $user_role->role_id = $role_id;
	    return $user_role->save();
    }
}