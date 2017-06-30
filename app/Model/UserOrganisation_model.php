<?php

namespace App\Model;
use App\Model\BaseModel\User_Organisation;
use Hash;
class UserOrganisation_model {

    public function __construct(){
        //parent::__construct();
    }
        
        public function getAll() {
            return User_Organisation::all();
        }
        public function getById($id) {
            return User_Organisation::find($id);
        }
        public function getAllByGet(){
            return User_Organisation::get();
        }

        public function findRole($id){
            $data = $this->findById($id);
            return $data->roles()->get();
        }
        
        public function getIdByUserId($id) {
            return User_Organisation::selectRaw('*')->where('user_master_id',$id)->first();
        }
        
        
        
        public function getOrgById($id) {
            return User_Organisation::selectRaw('user_master_id')->where('organization_master_id',$id)->get();
        }
        
        public function findById($user_id){
            return User_Organisation::find($user_id);
        }
    
        public function updateOrgStatus($data){
            $User_Org = User_Organisation::find($data['id']);
            $User_Org->organization_master_id = $data['organization_master_id'];
            $User_Org->role = $data['role'];
            $User_Org->save();
        }

        public function updatePassByEmail($data){
            return User_Organisation::where('email',$data['email'])
                ->update(['password'=>bcrypt($data['password'])]);
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
        
        public function SaveUserOrg($request) {
            if(isset($request->update) && $request->update == 1){
                $User_Org = User_Organisation::find($request->id);
            }else{
                $User_Org = new User_Organisation;
            }
            if(isset($request->user_master_id) && $request->user_master_id){
                $User_Org->user_master_id = $request->user_master_id;
            }
            if(isset($request->organization_master_id) && $request->organization_master_id){
                $User_Org->organization_master_id = $request->organization_master_id;
            }
            if(isset($request->registration_type) && $request->registration_type){
                $User_Org->registration_type = $request->registration_type;
            }
            if(isset($request->registration_date) && $request->registration_date){
                $User_Org->registration_date = $request->registration_date;
            }
            if(isset($request->email) && $request->email){
                $User_Org->email = $request->email;
            }
            if(isset($request->password) && $request->password){
                $User_Org->password = $request->password;
            }
            if(isset($request->role) && $request->role){
                $User_Org->role = $request->role;
            }
            $User_Org->save();
            return $User_Org;
        }

        public function getUserDetail($user_id){
            return User_Organisation::leftJoin('user_masters'
                                                ,'user_organizations.user_master_id'
                                                , '=', 'user_masters.id')
                                    ->leftJoin('organization_masters'
                                            ,'user_organizations.organization_master_id'
                                            , '=', 'organization_masters.id')
                                    ->leftJoin('cricket_profiles'
                                                ,'user_masters.id'
                                                , '=', 'cricket_profiles.user_master_id')
                                    ->where('user_masters.id','=',$user_id)
                                    ->get();
        }
        
}