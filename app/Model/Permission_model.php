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

	public function findById($id){
		return Permission::find($id);
	}

	public function getPermissionByRole($role_id){
		return DB::table('permission_role')
                        ->select('*')
                        ->leftJoin('permissions','permissions.id','=','permission_role.permission_id')
                        ->where('permission_role.role_id', '=', $role_id)
                        ->get();
	}

	public function getPermissionByRoleIds($role_id_arr){
		return DB::table('permission_role')
                        ->select('*')
                        ->leftJoin('permissions','permissions.id','=','permission_role.permission_id')
                        ->whereIn('permission_role.role_id',$role_id_arr)
                        ->get();
	}

	public function insert($request){
		$createUser = new Permission;
        $createUser->name = $request->perm_name;
        $createUser->slug = $request->slug;
        if(isset($request->desc) && $request->desc){
        	$createUser->description = $request->desc;
        }
        $createUser->save();
        return $createUser;
	}

	public function updatePerm($where_data,$update_data){
		return Permission::where($where_data)->update($update_data);
	}


	public function deletePerm($id){
		$get_id = $this->findById($id);
		return $get_id->delete();
	}


	public function checkPerm($where_datas){
		return DB::table('permission_role')->where($where_datas)->get();
	} 


	public function getUserId(){
		return DB::table('permission_role')->select('role_id')->distinct()->get();
	}

	public function deletePermAssignRole($id){
		return DB::table('permission_role')->where('id', $id)->delete();
	}


}
