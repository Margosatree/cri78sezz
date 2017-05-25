<?php

namespace App\Model;
use App\User_Organisation;
use Hash;
class UserOrganisation_model {

	public function __construct(){
		//parent::__construct();
	}
	public function insert($data){
            return User_Organisation::create([
                'user_master_id' => $data['um_id'],
                'organization_master_id' => $data['organization_master_id'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => config('constants.role.User'),
            ]);
	}
        
        public function getOrgByOrgMasterId($id) {
            return Organisation_Master::selectRaw('*')->where('id', $id)->get()->first();
        }
}