<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use DB;

use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;
use App\Model\TournamentDetails_model;
use App\Model\TournamentMaster_model;
use App\Model\TournamentRules_model;
use App\Model\OrganisationMaster_model;
use App\Model\TournamentUser_model;
class TournamentMasterControllerApi extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $UserMaster_model;
    protected $OrganisationMaster_model;
    protected $TournamentDetails_model;
    protected $TournamentMaster_model;
    protected $TournamentRules_model;
    protected $UserOrganisation_model;
    protected $TournamentUser_model;
    
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
//        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->TournamentDetails_model = new TournamentDetails_model();
        $this->TournamentMaster_model = new TournamentMaster_model();
        $this->TournamentRules_model = new TournamentRules_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
        $this->TournamentUser_model = new TournamentUser_model();
    }
    
    public function listTournament(){
        $user = JWTAuth::parseToken()->authenticate();
        $organization_master_id = $user->organization_master_id;//have to find Org id from login
        $Tournaments = $this->TournamentMaster_model->getTourByOrgId($organization_master_id);
        if($Tournaments){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Tournaments);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
    
    public function addTournament(Request $request){
        $validator = Validator::make($request->all(), [
            'tournament_name' => 'required|max:190',
            'tournament_location' => 'required|max:190',
            // 'organization_master_id' => 'required|numeric|min:1',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'reg_start_date' => 'required|date|before:end_date',
            'reg_end_date' => 'required|date|after:start_date',
            'image'=>'required',
            'mime'=>'required|in:png,jpg,gif,jpeg'
        ]);
        
        if(!$validator->fails()){
            $user = JWTAuth::parseToken()->authenticate();
            $Tournament_Exist = $this->TournamentMaster_model->TourNameExists(
                    $user->organization_master_id,$request->tournament_name);
            if(!$Tournament_Exist){
                $data = $request->image;
                $mime_data = $request->mime;
                $rand_str = str_random(40);
                $filename = "$rand_str.$mime_data";
                $data = base64_decode($data);
                file_put_contents(public_path('images/'. $filename), $data);
                $params['tournament_logo'] = $filename;
                $request->request->add(['tournament_logo' => $filename]);
                
                $request->request->add(['organization_master_id' => $user->organization_master_id]);
                $Tournament = $this->TournamentMaster_model->SaveTourMaster($request);
                if($Tournament){
                    $output = array('status_code' => 200 ,'message' => 'Sucess');
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Tournament Name Already Exist');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function updateTournament(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|numeric|min:1',
            'tournament_name' => 'required|max:190',
            'tournament_location' => 'required|max:190',
            // 'organization_master_id' => 'required|numeric|min:1',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'reg_start_date' => 'required|date|before:end_date',
            'reg_end_date' => 'required|date|after:start_date',
            'image'=>'string',
            'mime'=>'in:png,jpg,gif,jpeg'
        ]);
        if(!$validator->fails()){
            $user = JWTAuth::parseToken()->authenticate();
            $Tournament_Exist = $this->TournamentMaster_model->TourNameExists(
                    $user->organization_master_id,
                    $request->tournament_name,
                    $request->id);
            if(!$Tournament_Exist){
                if(isset($request->image) && isset($request->mime) && $request->image && $request->mime){
                        $data = $request->image;
                        $mime_data = $request->mime;
                        $rand_str = str_random(40);
                        $filename = "$rand_str.$mime_data";
                        $data = base64_decode($data);
                        file_put_contents(public_path('images/'. $filename), $data);
                        $request->request->add(['tournament_logo' => $filename]);
                }

                $request->request->add(['update' => 1,'updated_by' => $user->user_master_id,'organization_master_id' => $user->organization_master_id]);
                $Tournament = $this->TournamentMaster_model->SaveTourMaster($request);
                if($Tournament){
                    $output = array('status_code' => 200 ,'message' => 'Sucess');
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Tournament Name Already Exist');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function deleteTournament(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|numeric|min:1|exists:tournament_master,id'
        ]);
        if(!$validator->fails()){
            $Tour_Mast = $this->TournamentMaster_model->getById($request->id);
            $user = JWTAuth::parseToken()->authenticate();

            $request->request->add(['update' => 1,'deleted_by' => $user->user_master_id,'organization_master_id' => $user->organization_master_id]);
            $Tournament = $this->TournamentMaster_model->SaveTourMaster($request);
            if($Tour_Mast->delete()){
                $Tour_Det = $this->TournamentDetails_model->deleteById($request->id);
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                DB::rollBack();
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function listMyTour(){
        $user = JWTAuth::parseToken()->authenticate();
        $datas = $this->TournamentMaster_model->getMyTourDetails($user->user_master_id);
        if($datas){
            $output = array('status_code' => 200 ,'message' => 'success','data' => $datas);
        }else{
            $output = array('status_code' => 404 ,'message' => 'transation_failed');
        }
        return response()->json($output,$output['status_code']);
    }

    public function addUserInTour(Request $request){
        $validates = Validator::make($request->all(),[
                'user_id'=>'required|exists:user_masters,id|numeric|digits_between: 1,7',
                'tour_id'=>'required|exists:tournament_master,id|numeric|digits_between: 1,7',
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $user_org = array('user_master_id'=>$request->user_id
                          ,'organization_master_id'=>$user->organization_master_id);
        $check_user_with_orgId = $this->UserOrganisation_model->allCondtion($user_org);
        if(!count($check_user_with_orgId)){
             $response = [
                        'message'=>'UserId is From Different Organiztion',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $tour_org = array('id'=>$request->tour_id
                          ,'organization_master_id'=>$user->organization_master_id);
        $check_tour_with_orgId = $this->TournamentMaster_model->allCondtion($tour_org);
        if(!count($check_tour_with_orgId)){
             $response = [
                        'message'=>'TourId is From Different Organiztion',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $user_tour = array('user_id'=>$request->user_id
                          ,'tour_id'=>$request->tour_id);
        $check_tour_with_user = $this->TournamentUser_model->allCondtion($user_tour);
        if(count($check_tour_with_user)){
             $response = [
                        'message'=>'User is Already in Tournament',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $insert_data = $this->TournamentUser_model->insertUserTour($user_tour);
        if($insert_data){
            $response = [
                        'message'=>'inserted_successfully',
                        'status_code'=>200
                        ];
        }else{
            $response = [
                        'message'=>'failed_to_insert_data',
                        'status_code'=>403
                        ];
        }
        return Response::json($response,$response['status_code']);

    }

    public function addUserInTourBULK(){

        $validates = Validator::make($request->all(),[
            'user_id.*'=>'required|exists:user_masters,id|numeric|digits_between: 1,7',
            'tour_id'=>'required|exists:tournament_master,id|numeric|digits_between: 1,7',
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $user = JWTAuth::parseToken()->authenticate();
        foreach($request->user_id as $us_id){
            $user_org = array('user_master_id'=>$us_id
                              ,'organization_master_id'=>$user->organization_master_id);
            $check_user_with_orgId = $this->UserOrganisation_model->allCondtion($user_org);
            if(!count($check_user_with_orgId)){
                 $response = [
                            'message'=>'UserId is From Different Organiztion',
                            'status_code'=>403
                            ];
                return Response::json($response,$response['status_code']);
            }
        }

        $tour_org = array('id'=>$request->tour_id
                          ,'organization_master_id'=>$user->organization_master_id);
        $check_tour_with_orgId = $this->TournamentMaster_model->allCondtion($tour_org);
        if(!count($check_tour_with_orgId)){
             $response = [
                        'message'=>'TourId is From Different Organiztion',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }
        
        $bulk_insert =array();
        foreach($request->user_id as $us_id){
            
            $user_tour = array('user_id'=>$us_id
                              ,'tour_id'=>$request->tour_id);
            $check_tour_with_user = $this->TournamentUser_model->allCondtion($user_tour);
            if(!count($check_tour_with_user)){
                 $bulk_insert[]=$user_tour;
            }
        }

        $insert_data = $this->TournamentUser_model->insertUserTour($bulk_insert);
        if($insert_data){
            $response = [
                        'message'=>'inserted_successfully',
                        'status_code'=>200
                        ];
        }else{
            $response = [
                        'message'=>'failed_to_insert_data',
                        'status_code'=>403
                        ];
        }
        return Response::json($response,$response['status_code']);
    }

    public function removeUserFromTour(Request $request){
        $validates = Validator::make($request->all(),[
            'id'=>'required|exists:tournament_users,id|numeric|digits_between: 1,7'
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $user_tour_id = array('id'=>$request->id);
        $user_tour_details = $this->TournamentUser_model->allCondtion($user_tour_id);

        $user = JWTAuth::parseToken()->authenticate();
        $user_org = array('user_master_id'=>$user_tour_details->first()->user_id
                          ,'organization_master_id'=>$user->organization_master_id);
        $check_user_with_orgId = $this->UserOrganisation_model->allCondtion($user_org);
        if(!count($check_user_with_orgId)){
             $response = [
                        'message'=>'UserId is From Different Organiztion',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $tour_org = array('id'=>$user_tour_details->first()->tour_id
                          ,'organization_master_id'=>$user->organization_master_id);
        $check_tour_with_orgId = $this->TournamentMaster_model->allCondtion($tour_org);
        if(!count($check_tour_with_orgId)){
             $response = [
                        'message'=>'TourId is From Different Organiztion',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $delete_data = $this->TournamentUser_model->removeUserFromTour($request->id);
        if($delete_data){
            $response = [
                        'message'=>'deleted_successfully',
                        'status_code'=>200
                        ];
        }else{
            $response = [
                        'message'=>'failed_to_delete_data',
                        'status_code'=>403
                        ];
        }
        return Response::json($response,$response['status_code']);


    }

    public function listUserWithTour(Request $request){

        $validates = Validator::make($request->all(),[
            'tour_id'=>'required|exists:tournament_master,id|numeric|digits_between: 1,7',
            ]);

        if($validates->fails()){
            $response = [
                        'message'=>$validates->errors()->all(),
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $user = JWTAuth::parseToken()->authenticate();

        $tour_org = array('id'=>$request->tour_id
                          ,'organization_master_id'=>$user->organization_master_id);
        $check_tour_with_orgId = $this->TournamentMaster_model->allCondtion($tour_org);
        if(!count($check_tour_with_orgId)){
             $response = [
                        'message'=>'TourId is From Different Organiztion',
                        'status_code'=>403
                        ];
            return Response::json($response,$response['status_code']);
        }

        $display_data = $this->TournamentUser_model->getUserByTourDetails($request->tour_id);
        $response = [
                        'message'=>'success',
                        'status_code'=>200,
                        'data'=>$display_data
                    ];
         return Response::json($response,$response['status_code']);             
    }
    
}
