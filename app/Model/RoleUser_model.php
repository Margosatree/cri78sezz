<?php

namespace App\Model;

use DB;
use App\Model\BaseModel\role_user;

class RoleUser_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getRoleById($id){
		return DB::table('role_user')
                ->select('*')
                ->leftJoin('roles','roles.id','=','role_user.role_id')
                ->where('role_user.user_id', '=', $id)
                ->get();
	}

	public function insert($user_id,$role_id){
		$user_role = new role_user;
	    $user_role->user_id = $user_id;
	    $user_role->role_id = $role_id;
	    return $user_role->save();
    }
}