<?php

namespace App\Model;
use App\Model\BaseModel\Role;

class Role_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getAll(){
		return Role::get();
	}

	public function findById($id){
		return Role::find($id);
	}

	public function findByIdForPermission($roleId,$role_permission){
		$adminRole = $this->findById($roleId);
		$adminRole->permissions()->attach($role_permission);
		return $adminRole;
	}

	public function findPermissionById($id){
		return Role::find($id)->permissions()->get();
	}

	public function getPlayerId(){
		return Role::where('slug','player')->first();
	}

	public function detachPermission($id,$roleId){
		$role = $this->findById($roleId);
		$role->permissions()->detach($id);
	}

	public function insert($request){
            $adminRole = new Role;
            $adminRole->name = $request->name;
            $adminRole->slug = strtolower($request->name);
            $adminRole->description = $request->description;
            $adminRole->save();
            return $adminRole;
	}

	public function updateRole($where_data,$update_data){
		return Role::where($where_data)->update($update_data);
	}

	public function deleteRole($id){
		$get_id = $this->findById($id);
		return $get_id->delete();
	}
}