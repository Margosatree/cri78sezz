<?php

namespace App\Http\Controllers;
use App\Model\OrganisationMaster_model;
use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;
use Illuminate\Http\Request;
use Auth;
use \App\User_Organisation;
class OrganizationMasterController extends Controller
{
    protected $UserMaster_model;
    protected $OrganisationMaster_model;
    protected $UserOrganisation_model;
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOrg(){
        $Orgs = $this->OrganisationMaster_model->getAll();
        if($Orgs){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Orgs);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function addOrg(Request $request){
        $this->validate($request,[
            'name' => 'required',// Organisation Id
//            'orgname' => 'required',//Organisation name
            'address' => 'required',
            'landmark' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'business_type' => 'required',
            'business_operation' => 'required',
            'spoc' => 'required',
//            'is_verified' => 'required',
        ]);
        
        DB::beginTransaction();
        try {
            $request->request->add(['is_verified' => 0]);
            $Org = $this->OrganisationMaster_model->SaveOrg($request);
            if($Org){
                $params = array();
                $params['id'] = Auth::user()->id;
                $params['organization_master_id'] = $request->organization_master_id;
                $params['role'] = 'organizer';
                $User_Org = $this->UserOrganisation_model->updateOrgStatus($params);
                if($User_Org){
                    $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Org);
                }else{
                    $output = array('status' => 400 ,'msg' => 'Transection Fail');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
            DB::commit();
        } catch (\Exception $e) {
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
            DB::rollback();
        }
        return response()->json($output);
    }

    public function edit($id){
        $Org = $this->OrganisationMaster_model->getById($id);
        return view('user.org.edit', compact('Org'));
    }

    public function updateOrg(Request $request){
        $this->validate($request,[
            'name' => 'required|max:191',
            'address' => 'required|max:191',
            'landmark' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'country' => 'required|max:191',
            'pincode' => 'required|numeric|digits:6',
            'business_type' => 'required|max:191',
            'business_operation' => 'required|max:191',
            'spoc' => 'required|max:191',
        ]);
        if(isset($request->is_verified) && $request->is_verified){
            $request->request->add(['is_verified' => $request->is_verified]);
        }
        $organization_master_id = 1;
        $request->request->add(['update' => 1,'id' => $organization_master_id]);
        $Org = $this->OrganisationMaster_model->SaveOrg($request);
        if($Org){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Org);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
    
    public function deleteOrg(Request $request){
        $organization_master_id = 1;
        $Org = $this->OrganisationMaster_model->getById($organization_master_id);
        if($Org){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Org);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
}
