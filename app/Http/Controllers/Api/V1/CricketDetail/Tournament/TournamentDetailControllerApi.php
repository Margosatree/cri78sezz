<?php

namespace App\Http\Controllers\Api\V1\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

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
            $Tour_Dets = $this->TournamentDetails_model->getTourDetById($request->tournament_id);
            if($Tour_Dets){
                $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Tour_Dets);
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
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
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Transection Fail');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
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
                $request->request->add(['update' => 1]);
                $Tour_Det = $this->TournamentDetails_model->SaveTourDetail($request);
                if($Tour_Det){
                    $output = array('status' => 200 ,'msg' => 'Sucess');
                }else{
                    $output = array('status' => 400 ,'msg' => 'Transection Fail');
                }
            }else{
                $output = array('status' => 400 ,'msg' => 'Rule Not Exists');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
    }

    public function deleteTourDet(Request $request){
        $validator = Validator::make($request->all(),[
            'tournament_id' => 'required|numeric|min:1',
            'rule_id' => 'required|numeric|min:1',
        ]);
        if(!$validator->fails()){
            $Tour_Dets = $this->TournamentDetails_model->getTourDetByIdRuleId($request->tournament_id, $request->rule_id);
            if($Tour_Dets){
                $this->TournamentDetails_model->deleteRuleByRuleId($request->tournament_id, $request->rule_id);
                $output = array('status' => 200 ,'msg' => 'Sucess');
            }else{
                $output = array('status' => 400 ,'msg' => 'Rule Not Exists');
            }
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail','errors' => $validator->errors()->all());
        }
        return response()->json($output);
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
                        ,'message'=>'user_created_successfully'
                        ,'data'=>$Rules];
        return response()->json($display_data,200);
    }
}