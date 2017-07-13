<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use App\Model\TournamentDetails_model;
use App\Model\TournamentRules_model;
use App\Model\OrganisationMaster_model;


class TournamentDetailControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $OrganisationMaster_model;
    protected $TournamentDetails_model;
    protected $TournamentRules_model;
    
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
//        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->TournamentDetails_model = new TournamentDetails_model();
        $this->TournamentRules_model = new TournamentRules_model();
    }
    
    public function listTourDet(Request $request){
        $validator = Validator::make($request->all(),[
            'tournament_id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            $Tour_Dets = $this->TournamentDetails_model->getTourDetailById($request->tournament_id);
            if($Tour_Dets){
                $output = array('status_code' => 200 ,'message' => 'Sucess','data' => $Tour_Dets);
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }
    
    public function addTourDet(Request $request){
        $validator = Validator::make($request->all(),[
            'tournament_id' => 'required|numeric|min:1',
            'rule_id' => 'required|numeric|min:1',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'max:190',
            'range_to' => 'max:190',
        ]);
        if(!$validator->fails()){
            $Tour_Det = $this->TournamentDetails_model->SaveTourDetail($request);
            if($Tour_Det){
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function updateTourDet(Request $request){
        $validator = Validator::make($request->all(),[
            'tournament_id' => 'required|numeric|min:1',
            'rule_id' => 'required|numeric|min:1',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'max:190',
            'range_to' => 'max:190',
        ]);
        if(!$validator->fails()){
            $Rule_Exists = $this->TournamentDetails_model->getTourDetByIdRuleId($request->tournament_id, $request->rule_id);
            if($Rule_Exists){
                $user = JWTAuth::parseToken()->authenticate();
                $request->request->add(['update' => 1,'updated_by' => $user->user_master_id]);
                $Tour_Det = $this->TournamentDetails_model->SaveTourDetail($request);
                if($Tour_Det){
                    $output = array('status_code' => 200 ,'message' => 'Sucess');
                }else{
                    $output = array('status_code' => 400 ,'message' => 'Transection Fail');
                }
            }else{
                $output = array('status_code' => 400 ,'message' => 'Rule Not Exists');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function deleteTourDet(Request $request){
        $validator = Validator::make($request->all(),[
            'tournament_id' => 'required|numeric|min:1',
            'rule_id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            $Tour_Dets = $this->TournamentDetails_model->getTourDetByIdRuleId($request->tournament_id, $request->rule_id);
            if($Tour_Dets){
                $user = JWTAuth::parseToken()->authenticate();
                $request->request->add(['update' => 1,'deleted_by' => $user->user_master_id]);
                $this->TournamentDetails_model->SaveTourDetail($request);
                $this->TournamentDetails_model->deleteRuleByRuleId($request->tournament_id, $request->rule_id);
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                $output = array('status_code' => 400 ,'message' => 'Rule Not Exists');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function getTourPendRules(Request $request){

         $validator = Validator::make($request->all(),[
            'tournament_id' => 'required|numeric|min:1',
        ]);

        if($validator->fails()){
            return response()->json([
                                    'message'=>$validator->errors()->all(),
                                    'status_code'=>403
                                ],403);
        }

        $Rule_id = $this->TournamentDetails_model->getRulesByTourId($request->tournament_id);
        $Rules = $this->TournamentRules_model->getAllNotIn($Rule_id);
        
        $display_data = ['status_code'=>200
                        ,'message'=>'success'
                        ,'data'=>$Rules];
        return response()->json($display_data,200);
    }
}