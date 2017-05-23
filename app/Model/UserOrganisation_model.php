<?php

namespace App\Model;
use App\User_Organisation;

class UserOrganisation_model {

	public function __construct(){
		//parent::__construct();
	}
	public function insert($data){
	return User_Organisation::create([
            'user_master_id' => $data['um_id'],
            'organization_master_id' => 0,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => config('constants.role.User'),
        ]);
	}
}