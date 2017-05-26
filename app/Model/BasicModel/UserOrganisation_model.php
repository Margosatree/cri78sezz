<?php

namespace App\Model;
use App\Model\BaseModel\User_Organisation;
use Hash;
class UserOrganisation_model {

	public function __construct(){
		//parent::__construct();
	}

    public function findById($user_id){
        return User_Organisation::find($user_id);;
    }
        
    public function getOrgByOrgMasterId($id) {
        return Organisation_Master::selectRaw('*')->where('id', $id)->get()->first();
    }

    public function getOrgById($id) {
        return User_Organisation::selectRaw('user_master_id')
                    ->where('organization_master_id',$id)->get();
    }  

    public function getAll() {
        return User_Organisation::all();
    }

    public function getAllByGet(){
       return User_Organisation::get();
    }

    public function findRole($id){
        $data = $this->findById($id);
        return $data->roles()->get();

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

        public function SaveUserOrg($data) {
            if(isset($data['id']) && $data['id'] > 0){
                $User_master = User_Master::find($data['id']);
            }else{
                $User_master = new User_Master;
            }
            if(isset($data['user_master_id']) && $data['user_master_id']){
                $User_master->user_master_id = $data['user_master_id'];
            }
            if(isset($data['organization_master_id']) && $data['organization_master_id']){
                $User_master->organization_master_id = $data['organization_master_id'];
            }
            if(isset($data['registration_type']) && $data['registration_type']){
                $User_master->registration_type = $data['registration_type'];
            }
            if(isset($data['registration_date']) && $data['registration_date']){
                $User_master->registration_date = $data['registration_date'];
            }
            if(isset($data['registration_date']) && $data['registration_date']){
                $User_master->registration_date = $data['registration_date'];
            }
            if(isset($data['email']) && $data['email']){
                $User_master->email = $data['email'];
            }
            if(isset($data['password']) && $data['password']){
                $User_master->password = $data['password'];
            }
            if(isset($data['role']) && $data['role']){
                $User_master->role = $data['role'];
            }
            $User_master->save();
            return $User_master;
        }
        
}