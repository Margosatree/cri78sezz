<?php

namespace App\Http\Controllers\Api\V1\Users\Org;
use App\Http\Controllers\Controller;
use App\Model\OrganisationMaster_model;
use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use JWTAuth;
use DB;
use Validator;
use \App\User_Organisation;
class OrganizationMasterControllerApi extends Controller
{
    protected $UserMaster_model;
    protected $OrganisationMaster_model;
    protected $UserOrganisation_model;
    
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
//        $this->middleware('auth',['except'=>['index']]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:190',// Organisation Id
//            'orgname' => 'required',//Organisation name
            'address' => 'required|max:190',
            'landmark' => 'required|max:190',
            'city' => 'required|max:190',
            'state' => 'required|max:190',
            'country' => 'required|max:190',
            'pincode' => 'required|numeric|digits:6',
            'business_type' => 'required|max:190',
            'business_operation' => 'required|max:190',
            'spoc' => 'required|max:190',
        ]);
        if(!$validator->fails()){
            $Org_Exists = $this->OrganisationMaster_model->OrgNameExists($request->name);
            if(!$Org_Exists){
                $request->request->add(['is_verified' => 0]);
                $Org = $this->OrganisationMaster_model->SaveOrg($request);
                if($Org){
                    $output = array('status' => 200 ,'msg' => 'Sucess');
                }else{
                    $output = array('status' => 400 ,'msg' => 'Transection Fail');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Organisation Name Already Exists');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function updateOrg(Request $request){
        $validator = Validator::make($request->all(), [
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
        if(!$validator->fails()){
            $Org_Exists = $this->OrganisationMaster_model->OrgNameExists($request->name);
            if(!$Org_Exists){
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
            }else{
                $output = array('status' => 400 ,'msg' => 'Organisation Name Already Exists');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }
    
    public function deleteOrg(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|min:1'
        ]);
        if(!$validator->fails()){
            $organization_master_id = 1;
            $Org = $this->OrganisationMaster_model->getById($request->id);
            if($Org){
                $Org->delete();
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function listOrgById(){
        $user = JWTAuth::parseToken()->authenticate();
        $orgs = $this->OrganisationMaster_model->getById($user->organization_master_id);
        $datas = [$orgs];                                      
        if(!is_null($datas)){
            $response = array('status' => 200 ,'msg' => 'success','data' => $datas);
        }else{
            $response = array('status' => 404 ,'msg' => 'transation_failed');
        }
        return response()->json($response,$response['status']);
    }

    public function listUserByOrgId(){
        $user = JWTAuth::parseToken()->authenticate();
        $user_org_data = $this->UserOrganisation_model->getlistOrgUser($user->organization_master_id);

        $response = array('status_code' => 200, 
                            'message' => 'success', 
                            'data' => $user_org_data
                        );
        return response()->json($response,$response['status_code']);
    }

    public function updateSpoc(Request $request){
        $validator = Validator::make($request->all(), [
             'id'=>'required|exists:organization_masters,id|numeric|digits_between: 1,7',
            'spoc' => 'required|exists:user_masters,id|numeric|digits_between: 1,7',
        ]);
        if($validator->fails()){
            $response = [
                        'message'=>$validator->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $send_data = ['organization_master_id'=>$request->id,
                      'user_master_id'=>$request->spoc];
        $check_user_with_org = $this->OrganisationMaster_model->allCondtion($send_data);
        if(!count($check_user_with_org)){
            $response = [
                        'message'=>'Please Provide Correct User wih organiztion',
                        'status_code'=>404
                        ];
            return Response::json($response,$response['status_code']);
        }
        $request->request->add(['update' => 1]);

        $Org = $this->OrganisationMaster_model->SaveOrg($request);
        if($Org){
            $output = array('status_code' => 200 ,'msg' => 'Sucess');
        }else{
            $output = array('status_code' => 400 ,'msg' => 'Transection Fail');
        }
        
         return Response::json($response,$response['status_code']);
    }
}
