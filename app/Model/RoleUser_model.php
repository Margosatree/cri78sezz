<?php

namespace App\Model;

use DB;
use App\Model\BaseModel\role_user;
use App\Model\Permission_model;

class RoleUser_model {

  protected $Permission_model;

	public function __construct(){
		//parent::__construct();
		$this->Permission_model = new Permission_model;
	}

	public function getRoleById($id,$is_admin= 0){
		return DB::table('role_user')
                ->select('*')
                ->leftJoin('roles','roles.id','=','role_user.role_id')
								->where('role_user.user_id', '=', $id)
                ->where('roles.is_admin', '=', $is_admin)
                ->get();
	}

	public function insert($user_id,$role_id){
		$user_role = new role_user;
	    $user_role->user_id = $user_id;
	    $user_role->role_id = $role_id;
	    return $user_role->save();
    }

		public function getPermissionsByUserId($id,$admin = 0){
			$check_roles = $this->getRoleById($id,$admin);
			$role_id_arr = array();
			foreach($check_roles as $check_role){
				$role_id_arr[] = $check_role->role_id;
			}

			$permissions = $this->Permission_model->getPermissionByRoleIds($role_id_arr);
			$perms = array();
			foreach($permissions as $permission){
					$perm = $permission->slug;
					$perms[]=$perm;
			}

			return $perms;
		}

}
