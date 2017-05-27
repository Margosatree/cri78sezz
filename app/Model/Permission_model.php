<?php

namespace App\Model;

use DB;
use App\Model\BaseModel\Permission;

class Permission_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getAll(){
		return Permission::get();
	}

	public function getPermissionByRole($role_id){
		return DB::table('permission_role')
                        ->select('*')
                        ->leftJoin('permissions','permissions.id','=','permission_role.permission_id')
                        ->where('permission_role.role_id', '=', $role_id)
                        ->get();
	}

	public function insert($request){
		$createUser = new Permission;
        $createUser->name = $request->name;
        $createUser->slug = $request->slug;
        $createUser->description = $request->description;
        $createUser->save();
        return $createUser;
	}
	
}