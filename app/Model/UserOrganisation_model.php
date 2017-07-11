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
            return User_Organisation::where('user_master_id',$id)->first();
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
//            dd($request->all());
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
            if(isset($request->is_activate) && $request->is_activate){
                $User_Org->is_activate = $request->is_activate;
            }
            if(isset($request->role) && $request->role){
                $User_Org->role = $request->role;
            }
            $User_Org->save();
            return $User_Org;
        }

        public function getUserDetail($user_id){
            return User_Organisation::select(['um.id AS um_id','um.first_name','um.middle_name','um.last_name','um.date_of_birth','um.gender','um.physically_challenged','um.phone','um.email','um.is_verify_phone','um.is_verify_email','um.username','um.address AS um_address','um.suburb','um.city AS um_city','um.state AS um_state','um.country AS um_country','um.pin','om.id AS om_id','om.name','om.address AS om_address','om.landmark','om.city AS om_city','om.state AS om_state','om.country AS om_country','om.pincode','om.business_type','om.business_operation','om.spoc','om.is_verified','cp.id AS cp_id','cp.user_master_id','cp.your_role','cp.batsman_style','cp.batsman_order','cp.bowler_style','cp.player_type','cp.description','cp.display_img','cp.is_completed',])
                                    ->leftJoin('user_masters AS um'
                                                ,'user_organizations.user_master_id'
                                                , '=', 'um.id')
                                    ->leftJoin('organization_masters AS om'
                                        ,'user_organizations.organization_master_id'
                                            , '=', 'om.id')
                                    ->leftJoin('cricket_profiles AS cp'
                                                ,'um.id', '=', 'cp.user_master_id')
                                    ->where('um.id','=',$user_id)
                                    ->first();
        }

        public function getlistOrgUser($org_id){
            return User_Organisation::select(['um.id AS um_id','um.first_name','um.last_name','um.email','um.phone','om.id AS om_id','om.name'])
                                    ->leftJoin('user_masters um','User_Organisation.user_master_id','=','um.id')
                                    ->leftJoin('organization_masters om','User_Organisation.organization_master_id','=','organization_masters.id')
                                    ->where('User_Organisation.organization_master_id','=',$org_id)
                                    ->get()
        }
        
}