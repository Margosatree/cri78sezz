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
        
        public function SaveOrg($request) {
            if(isset($request->update) && $request->update == 1){
                $Org = Organisation_Master::find($request->id);
            }else{
                $Org = new Organisation_Master;
            }
            $Org->name = $request->name;
            $Org->address = $request->address;
            $Org->city = $request->city;
            $Org->state = $request->state;
            $Org->country = $request->country;
            $Org->pincode = $request->pincode;
            $Org->business_type = $request->business_type;
            $Org->business_operation = $request->business_operation;
            $Org->spoc = $request->spoc;
            $Org->is_verified = $request->is_verified;
            $Org->save();
            return $Org;
        }
}