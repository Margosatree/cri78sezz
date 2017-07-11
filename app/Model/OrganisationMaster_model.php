<?php

namespace App\Model;
use App\Model\BaseModel\Organisation_Master;

class OrganisationMaster_model {

    public function __construct(){
        //parent::__construct();
    }
        
        public function getAll() {
            return Organisation_Master::all();
        }
        
        public function getById($id) {
            return Organisation_Master::find($id);
        }

        public function getRaw($sSql) {
            return Organisation_Master::selectRaw($sSql)->get();
        }
        
        public function getOrgByOrgMasterId($id) {
            return Organisation_Master::selectRaw('*')->where('id', $id)->get()->first();
        }
        
        public function OrgNameExists($name) {
            return Organisation_Master::selectRaw('*')
                    ->where('name',$name)->value('name');
        }

        
        
        public function SaveOrg($request) {
            if(isset($request->update) && $request->update == 1){
                $Org = Organisation_Master::find($request->id);
            }else{
                $Org = new Organisation_Master;
            }
            if(isset($request->name) && $request->name){
                $Org->name = $request->name;
            }
            if(isset($request->address) && $request->address){
                $Org->address = $request->address;
            }
            if(isset($request->city) && $request->city){
                $Org->city = $request->city;
            }
            if(isset($request->state) && $request->state){
                $Org->state = $request->state;
            }
            if(isset($request->country) && $request->country){
                $Org->country = $request->country;
            }
            if(isset($request->pincode) && $request->pincode){
                $Org->pincode = $request->pincode;
            }
            if(isset($request->business_type) && $request->business_type){
                $Org->business_type = $request->business_type;
            }
            if(isset($request->business_type) && $request->business_type){
                $Org->business_type = $request->business_type;
            }
            if(isset($request->business_operation) && $request->business_operation){
                $Org->business_operation = $request->business_operation;
            }
            if(isset($request->spoc) && $request->spoc){
                $Org->spoc = $request->spoc;
            }
            if(isset($request->is_verified) && $request->is_verified){
                $Org->is_verified = $request->is_verified;
            }
            $Org->save();
            return $Org;
        }
}