<?php

namespace App\Http\Controllers;
//use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Model\BaseModel\ScoreMaster;
use App\Model\BaseModel\Balldata;
use App\Model\BaseModel\Batsman;
use App\Model\BaseModel\Bowler;
use App\Model\BaseModel\Fielder;
use App\Model\BaseModel\Partnership;
use App\Model\BaseModel\BatsmanDetail;
use App\Model\BaseModel\BowlerDetail;
use App\Model\BaseModel\PartnershipDetail;
use App\Model\BaseModel\FielderDetail;
use App\Model\BaseModel\UpdateBowler;
use App\Model\BaseModel\UpdateFielder;
use App\Model\BaseModel\TourSquad;
use App\Model\BaseModel\MatchSquad;
use App\Model\BaseModel\BatsmanPowerplay;
use App\Model\BaseModel\BowlerPowerplay;
use App\Model\BaseModel\FielderPowerplay;
use App\Model\BaseModel\DirectScore;
use App\Model\BaseModel\DirectBatsman;
use App\Model\BaseModel\DirectBowler;
use App\Model\BaseModel\DirectFielder;
use App\Model\BaseModel\DirectPartnership;
use App\Model\BaseModel\Balldatahistory;
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
    protected $TourSquad_model;
    protected $MatchSquad_model;
    protected $BatsmanPowerplay_model;
    protected $BowlerPowerplay_model;
    protected $FilderPowerplay_model;
    protected $DirectBatsman_model;
    protected $DirectBowler_model;
    protected $DirectFielder_model;
    protected $DirectPartnership_model;
    protected $DirectScore_model;
    protected $Balldatahistory_model;
    public function __construct() {
        
    }
    
    public function tourSquad(Request $request){
        $this->TourSquad_model = new TourSquad();
        $status = $this->TourSquad_model->storeTourSquad($request);
        if($status = true)
        {
            return response()->json(['status'=>200, 'Message'=>'Data sucessfully submitted']);
        }
        else{
            return response()->json(['status'=>400, 'Message'=>'There occured some error in data submission']);  
        }
    }

    public function matchSquad(Request $request){
        /*$output = array();
        $output['data'] = "Hello World";*/
        $this->MatchSquad_model = new MatchSquad();
        $status = $this->MatchSquad_model->storeMatchSquad($request);
        if($status = true)
        {
            return response()->json(['status'=>200, 'Message'=>'Data sucessfully submitted']);
        }
        else{
            return response()->json(['status'=>400, 'Message'=>'There occured some error in data submission']);  
        }
    }

    public function getBowler(Request $request){              
        $this->UpdateBowler_model = new UpdateBowler();
        $data_change = $this->UpdateBowler_model->calBowlerChanger($request);
        return $data_change;
    }

    public function getFielder(Request $request){
        $this->UpdateFielder_model = new UpdateFielder();
        $data_change = $this->UpdateFielder_model->calFielderChanger($request);
        return $data_change;        
    }

    public function changeFielder(Request $request){
        //return response()->json($request);
        $this->UpdateFielder_model = new UpdateFielder();
        $data_change = $this->UpdateFielder_model->fielderChangeMaker($request);
        if($data_change == true)
        {
            $response = ['status'=>200, 'Message'=>'Record updated sucessfuly'];
            return response()->json($response);
        }
        else{
            $response = ['status'=>400, 'Message'=>'There was an error in updating the record'];
            return response()->json($response);
        }
        
    }

    public function changeBowler(Request $request){ 
        //dd($request);
        $this->UpdateBowler_model = new UpdateBowler();
        $chkConstraint = $this->UpdateBowler_model->checkConstraint($request,2,10);
       // dd($chkConstraint['status']);           
        if($chkConstraint['status'] == 200)
        {
            $data_change = $this->UpdateBowler_model->bowlerChangeMaker($request);
            if($data_change == true)
            {
                $response = ['status'=>200, 'Message'=>'Record updated sucessfuly'];
                return response()->json($response);
            }
            else{
                $response = ['status'=>400, 'Message'=>'There was an error in updating the record'];
                return response()->json($response);
            }
        }
        else
        {
            return response()->json($chkConstraint);
        }
    }

    public function saveTick(Request $request){
        // DB::beginTransaction();
        
        // try {
            $data = $this->calScore($request);
            //dd($data);
            $this->calBatsman($request);
            $this->calBowler($request);
            $this->calFilder($request);
            $this->calPartnership($request);
            $this->calScoreMaster($request);
            $this->calBatsmanDetail($request);
            $this->calBowlerDetail($request);
            $this->calPartnershipDetail($request);
            $this->calFielderDetail($request);

            if($request->power_play == 1)
            {
                $this->calBatsmanPowerplay($request);
                $this->calBowlerPowerplay($request);
                $this->calFilderPowerplay($request);
            }
            
            return $data;
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

    public function calBatsmanPowerplay($request){
        $this->BatsmanPowerplay_model = new BatsmanPowerplay();
        $this->BatsmanPowerplay_model->saveBatsmanTickData($request);
    }
    public function calBowlerPowerplay($request){
        $this->BowlerPowerplay_model = new BowlerPowerplay();
        $this->BowlerPowerplay_model->saveBowlerTickData($request);
    }
    public function calFilderPowerplay($request){
        $this->FilderPowerplay_model = new FielderPowerplay();
        $this->FilderPowerplay_model->saveFielderTickData($request);
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
      return $this->Balldata_model->saveBalldata($request);
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

    public function directBatsman(Request $request){
        $this->DirectBatsman_model = new DirectBatsman();
        $status = $this->DirectBatsman_model->storeDirectBatsman($request);
        if($status = true)
        {
            return response()->json(['status'=>200, 'Message'=>'Data sucessfully submitted']);
        }
        else{
            return response()->json(['status'=>400, 'Message'=>'There occured some error in data submission']);  
        } 
    }
    
    public function directBowler(Request $request){
        $this->DirectBowler_model = new DirectBowler();
        $status = $this->DirectBowler_model->storeDirectBowler($request);
        if($status = true)
        {
            return response()->json(['status'=>200, 'Message'=>'Data sucessfully submitted']);
        }
        else{
            return response()->json(['status'=>400, 'Message'=>'There occured some error in data submission']);  
        } 
    }

    public function directFielder(Request $request){
       $this->DirectFielder_model = new DirectFielder();
        $status = $this->DirectFielder_model->storeDirectFielder($request);
        if($status = true)
        {
            return response()->json(['status'=>200, 'Message'=>'Data sucessfully submitted']);
        }
        else{
            return response()->json(['status'=>400, 'Message'=>'There occured some error in data submission']);  
        } 
    }

    public function directPartnership(Request $request){
        $this->DirectPartnership_model = new DirectPartnership();
        $status = $this->DirectPartnership_model->storeDirectPartnership($request);
        if($status = true)
        {
            return response()->json(['status'=>200, 'Message'=>'Data sucessfully submitted']);
        }
        else{
            return response()->json(['status'=>400, 'Message'=>'There occured some error in data submission']);  
        }
    }

    public function directScore(Request $request){
        $this->DirectScore_model = new DirectScore();
        $status = $this->DirectScore_model->storeDirectScore($request);
        if($status = true)
        {
            return response()->json(['status'=>200, 'Message'=>'Data sucessfully submitted']);
        }
        else{
            return response()->json(['status'=>400, 'Message'=>'There occured some error in data submission']);  
        }
    }

    public function ballDataHistory(Request $request){
        //return response()->json($request);
        //dd("Heelo");
        $this->Balldatahistory_model = new Balldatahistory();
        $data = $this->Balldatahistory_model->saveBalldata($request);
        return response()->json($data);
    }
     
                 
}
