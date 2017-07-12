<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Tournament;
use JWTAuth;
use JWTAuthException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\TournamentMaster_model;
use App\Model\TournamentRules_model;

class TournamentRulesControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
//        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected $TournamentMaster_model;
    protected $TournamentRules_model;
    
    protected function _initModel(){
        $this->TournamentMaster_model = new TournamentMaster_model();
        $this->TournamentRules_model = new TournamentRules_model();
    }
    
    public function listRules(Request $request){
        $Rules = $this->TournamentRules_model->getAll();
        if($Rules){
            $output = array('status_code' => 200 ,'message' => 'Sucess', 'data' => $Rules);
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail');
        }
        return response()->json($output,$output['status_code']);
    }
    
    public function addRules(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:190|unique:tournament_rule_master,deleted_at,NULL',
            'specification' => 'required|max:190',
            'value' => 'max:190',
            'range_from' => 'required|max:190',
            'range_to' => 'required|max:190',
        ]);
        
        if(!$validator->fails()){
            $user = JWTAuth::parseToken()->authenticate();
            $Tournament = $this->TournamentRules_model->SaveRule($request);
            if($Tournament){
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function updateRules(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|max:190|unique:tournament_rule_master,id,'.$request->id,
            'specification' => 'required|max:190',
            'value' => 'max:190',
            'range_from' => 'required|max:190',
            'range_to' => 'required|max:190',
        ]);
        
        if(!$validator->fails()){
            $user = JWTAuth::parseToken()->authenticate();
            $request->request->add(['update' => 1,'updated_by' => $user->user_master_id]);
            $Rule = $this->TournamentRules_model->SaveRule($request);
            if($Rule){
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }

    public function deleteRules(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            $user = JWTAuth::parseToken()->authenticate();
            $request->request->add(['update' => 1,'deleted_by' => $user->user_master_id]);
            $this->TournamentRules_model->SaveRule($request);
            $Rule = $this->TournamentRules_model->deleteById($request->id);
            if($Rule){
                $output = array('status_code' => 200 ,'message' => 'Sucess');
            }else{
                $output = array('status_code' => 400 ,'message' => 'Transection Fail');
            }
        }else{
            $output = array('status_code' => 400 ,'message' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output,$output['status_code']);
    }
}
