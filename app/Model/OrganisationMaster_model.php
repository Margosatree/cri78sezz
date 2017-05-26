<?php

namespace App\Model;
use App\Organisation_Master;

class OrganisationMaster_model {

	public function __construct(){
		//parent::__construct();
	}
        
        public function getAll() {
            return Organisation_Master::all();
        }

        public function getRaw($sSql) {
            return Organisation_Master::selectRaw($sSql)->get();
        }
        
        public function getOrgByOrgMasterId($id) {
            return Organisation_Master::selectRaw('*')->where('id', $id)->get()->first();
        }
        
        public function getOrgById($id) {
            return User_Organisation::selectRaw('user_master_id')->where('organization_master_id',$id)->get();
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
        
        public function SaveOrg($data) {
            if(isset($data['id']) && $data['id'] > 0){
                $Org = User_Master::find($data['id']);
            }else{
                $Org = new User_Master;
            }
            $Org->name = $data['name'];
            $Org->address = $data['address'];
            $Org->city = $data['city'];
            $Org->state = $data['state'];
            $Org->country = $data['country'];
            $Org->pincode = $data['pincode'];
            $Org->business_type = $data['business_type'];
            $Org->business_operation = $data['business_operation'];
            $Org->spoc = $data['spoc'];
            $Org->is_verified = 0;
            $Org->save();
            return $Org;
        }
}