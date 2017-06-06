<?php

namespace App\Http\Controllers\Web\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Model\TournamentDetails_model;
use App\Model\TournamentRules_model;
use App\Model\OrganisationMaster_model;


class TournamentDetailController extends Controller
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
        $this->validate($request,[
            'tournament_id' => 'required|numeric|min:1',
        ]);
        
        $Tour_Dets = $this->TournamentDetails_model->getTourDetById($request->tournament_id);
        if($Tour_Dets){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Tour_Dets);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
    
    public function addTourDet(Request $request){
        $this->validate($request,[
            'tournament_id' => 'required|numeric|min:1',
            'rule_id' => 'required|numeric|min:1',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'date|before:end_date',
            'range_to' => 'date|after:start_date',
        ]);
        
        $Tour_Det = $this->TournamentDetails_model->SaveTourDetail($request);
        if($Tour_Det){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Tour_Det);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function updateTourDet(Request $request){
        $this->validate($request,[
            'tournament_id' => 'required|numeric|min:1',
            'rule_id' => 'required|numeric|min:1',
            'specification' => 'max:190',
            'value' => 'required|max:190',
            'range_from' => 'date|before:end_date',
            'range_to' => 'date|after:start_date',
        ]);
        $request->request->add(['update' => 1]);
        $Tour_Det = $this->TournamentDetails_model->SaveTourDetail($request);
        if($Tour_Det){
            $output = array('status' => 200 ,'msg' => 'Sucess','data' => $Tour_Det);
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }

    public function destroy(Request $request){
        $this->validate($request,[
            'tournament_id' => 'required|numeric|min:1',
            'rule_id' => 'required|numeric|min:1',
        ]);
        $Tour_Dets = $this->TournamentDetails_model->getTourDetByIdRuleId($request->tournament_id, $request->rule_id);
        if($Tour_Dets){
            $this->TournamentDetails_model->deleteRuleByRuleId($request->tournament_id, $request->rule_id);
            $output = array('status' => 200 ,'msg' => 'Sucess');
        }else{
            $output = array('status' => 400 ,'msg' => 'Transection Fail');
        }
        return response()->json($output);
    }
}