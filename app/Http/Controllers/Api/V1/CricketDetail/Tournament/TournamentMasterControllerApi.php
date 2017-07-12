<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;

use App\Model\UserMaster_model;
use App\Model\TournamentDetails_model;
use App\Model\TournamentMaster_model;
use App\Model\TournamentRules_model;
use App\Model\OrganisationMaster_model;
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
    }
    
    public function listTournament(){
        $organization_master_id = 1;//have to find Org id from login
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
                    $user->organization_master_id,
                    $request->tournament_name,
                    $request->id);
            if(!$Tournament_Exist){
                $data = $request->image;
                $mime_data = $request->mime;
                $rand_str = str_random(40);
                $filename = "$rand_str.$mime_data";
                $data = base64_decode($data);
                file_put_contents(public_path('images/'. $filename), $data);
                $request->request->add(['tournament_logo' => $filename]);

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
            'id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            DB::beginTransaction();
            $Tour_Mast = $this->TournamentMaster_model->getById($request->id);
            if($Tour_Mast->delete()){
                $user = JWTAuth::parseToken()->authenticate();
                $request->request->add(['update' => 1,'deleted_by' => $user->user_master_id,'organization_master_id' => $user->organization_master_id]);
                $Tournament = $this->TournamentMaster_model->SaveTourMaster($request);
                $Tour_Det = $this->TournamentDetails_model->getById($request->id);
                if($Tour_Det->delete()){
                    DB::commit();
                    $output = array('status_code' => 200 ,'message' => 'Sucess');
                }else{
                    DB::rollBack();
                    $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                }
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
    
}
