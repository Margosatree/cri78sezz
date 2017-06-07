<?php

namespace App\Http\Controllers;
//use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\ScoreMaster;
use App\Balldata;
use App\Batsman;
use App\Bowler;
use App\Fielder;
use App\Partnership;
use App\BatsmanDetail;
use App\BowlerDetail;
use App\PartnershipDetail;
use App\FielderDetail;
use App\UpdateBowler;
use DB;
class PostsController extends Controller{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $Balldata_model;
    protected $BatsmanMaster_model;
    protected $BowlerMaster_model;
    protected $FielderMaster_model;
    protected $PartnershipMaster_model;
    protected $UpdateBowler_model;
    protected $UpdateFielder_model;
    public function __construct() {
        
    }
    
    public function tourSquad(Request $request){
        $output = array();
        $output['data'] = "Hello";
        return response()->json($request);
    }

    public function matchSquad(Request $request){
        $output = array();
        $output['data'] = "Hello World";
        return response()->json($request);
    }
    public function getBowler(Request $request){              
        $this->UpdateBowler_model = new UpdateBowler();
        $data_change = $this->UpdateBowler_model->calBowlerChanger($request);
        return $data_change;
    }

    public function getFielder(Request $request){
        $this->UpdateFielder_model = new UpdateFielder();
        $data_change = $this->UpdateFielder_model->calFieldersChanger($request);
        return $data_change;        
    }

    public function changeFielder(Request $request){
        $this->UpdateFielder_model = new UpdateFielder();
        $data_change = $this->UpdateFielder_model->fielderChangeMaker($request);
    }

    public function changeBowler(Request $request){ 

        $this->UpdateBowler_model = new UpdateBowler();
        $data_change = $this->UpdateBowler_model->bowlerChangeMaker($request);
    }

    public function saveTick(Request $request){
        // DB::beginTransaction();
        
        // try {
            $this->calScore($request);
            $this->calBatsman($request);
            $this->calBowler($request);
            $this->calFilder($request);
            $this->calPartnership($request);
            $this->calScoreMaster($request);
            $this->calBatsmanDetail($request);
            $this->calBowlerDetail($request);
            $this->calPartnershipDetail($request);
            $this->calFielderDetail($request);
           

            // DB::commit();
            $output['status'] = 200;
            $output['msg'] = "Entry Added Successfuly";
            return response()->json($output);
            $output['status'] = 400;
            $output['msg'] = "Transection Fail";
            $output['error'] = $e;
            return response()->json($output);
        // }
    }
    
    public function calFielderDetail($request){
        $this->FielderDetail_model = new FielderDetail();
        $this->FielderDetail_model->saveFielderDetail($request);
    }
    
    public function calPartnershipDetail($request){
        $this->PartnershipDetail_model = new PartnershipDetail();
        $this->PartnershipDetail_model->savePartnershipDetail($request);
    }
    
    public function calBatsmanDetail($request){
        $this->BatsmanDetail_model = new BatsmanDetail();
        $this->BatsmanDetail_model->saveBatsmanDetail($request);
    }

    public function calBowlerDetail($request){
        $this->BowlerDetail_model = new BowlerDetail();
        $this->BowlerDetail_model->saveBowlerDetail($request);
    }

    public function calScore($request){
       $this->Balldata_model = new Balldata();
       $this->Balldata_model->saveBalldata($request);
    }
    public function calBatsman($request){
        $this->BatsmanMaster_model = new Batsman();
        $this->BatsmanMaster_model->saveBatsmanTickData($request);
    }
    public function calBowler($request){
        $this->BowlerMaster_model = new Bowler();
        $this->BowlerMaster_model->saveBowlerTickData($request);
    }
    public function calFilder($request){
        $this->FilderMaster_model = new Fielder();
        $this->FilderMaster_model->saveFielderTickData($request);
    }
    public function calPartnership($request){
        $this->PartnershipMaster_model = new Partnership();
        $this->PartnershipMaster_model->savePartnershipTickData($request);
    }

    public function calScoreMaster($request){
       $this->Balldata_model = new ScoreMaster();
       $this->Balldata_model->saveTeamdata($request);
    }
    
    
}
