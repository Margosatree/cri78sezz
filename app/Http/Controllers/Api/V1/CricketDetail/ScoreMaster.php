<?php

namespace App\Http\Controllers\Api\V1\CricketDetail;
//use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Validator;
use App\Model\ScoreMaster_model;
use App\Model\Balldata_model;
use App\Model\Batsman_model;
use App\Model\Bowler_model;
use App\Model\Fielder_model;
use App\Model\Partnership_model;
use App\Model\BatsmanDetail_model;
use App\Model\BowlerDetail_model;
use App\Model\PartnershipDetail_model;
use App\Model\FielderDetail_model;
use App\Model\UpdateBowler_model;
use App\Model\UpdateFielder_model;
use App\Model\TourSquad_model;
use App\Model\MatchSquad_model;
use App\Model\BatsmanPowerplay_model;
use App\Model\BowlerPowerplay_model;
use App\Model\FielderPowerplay_model;
use App\Model\DirectScore_model;
use App\Model\DirectBatsman_model;
use App\Model\DirectBowler_model;
use App\Model\DirectFielder_model;
use App\Model\DirectPartnership_model;
use App\Model\Balldatahistory_model;
use DB;
class ScoreMaster extends Controller{
    
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
       $this->_initModel(); 
    }

    protected function _initModel(){
        $this->Balldata_model = new Balldata_model();
        $this->ScoreMaster_model = new ScoreMaster_model();
        $this->BatsmanDetail_model = new BatsmanDetail_model();
        $this->BowlerDetail_model = new BowlerDetail_model();
        $this->PartnershipDetail_model = new PartnershipDetail_model();
        $this->UpdateBowler_model = new UpdateBowler_model();
        $this->UpdateFielder_model = new UpdateFielder_model();
        $this->TourSquad_model = new TourSquad_model();
        $this->MatchSquad_model = new MatchSquad_model();
        $this->BatsmanPowerplay_model = new BatsmanPowerplay_model();
        $this->BowlerPowerplay_model = new BowlerPowerplay_model();
        $this->FilderPowerplay_model = new FielderPowerplay_model();
        $this->DirectBatsman_model = new DirectBatsman_model();
        $this->DirectBowler_model = new DirectBowler_model();
        $this->DirectFielder_model = new DirectFielder_model();
        $this->DirectPartnership_model = new DirectPartnership_model();
        $this->DirectScore_model = new DirectScore_model();
        $this->Balldatahistory_model = new Balldatahistory_model();
        $this->BatsmanMaster_model = new Batsman_model();
        $this->FielderDetail_model = new FielderDetail_model();
        $this->BowlerMaster_model = new Bowler_model();
        $this->FilderMaster_model = new Fielder_model();
        $this->PartnershipMaster_model = new Partnership_model();
    }
    
    public function tourSquad(Request $request){
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
        $data_change = $this->UpdateBowler_model->calBowlerChanger($request);
        return $data_change;
    }

    public function getFielder(Request $request){
        $data_change = $this->UpdateFielder_model->calFielderChanger($request);
        return $data_change;        
    }

    public function changeFielder(Request $request){
        //return response()->json($request);
    $data_change = $this->UpdateFielder_model->fielderChangeMaker($request);
    //dd($data_change);
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
        $chkConstraint = $this->UpdateBowler_model->checkConstraint($request,2,10);
       // dd($chkConstraint['status']);  

        if($chkConstraint['status'] == 200)
        {
            $data_change = $this->UpdateBowler_model->bowlerChangeMaker($request);
            //dd($data_change);
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

    public function ballDataUndo(Request $request)
    {   
        
        $data = $this->Balldata_model->undoRecord($request);
        return $this->undoTick($data->first());
    }
    public function saveTick(Request $request){
        // DB::beginTransaction();
           // dd($request);
        // try {
            $validator = Validator::make($request->all(), [
                'match_id' => 'required|numeric',
                'team_id1' => 'required|numeric',
                'team_id2' => 'required|numeric',
                'innings' => 'required|numeric',
                'batsman_id' => 'required|numeric',
                'batsman_id2' => 'required|numeric',
                'bowler_id' => 'required|numeric',
                'fielder_id' => 'required|numeric',
                'batsman_score' => 'required|numeric',
                'bowler_given' => 'required|numeric',
                'extra_runs' => 'required|numeric',
                'total_runs' => 'required|numeric',
                'team_runs' => 'required|numeric',
                'for_wicket' => 'required|numeric',
                'ball_no' => 'required|numeric',
                'ball_type_id' => 'required|numeric',
                'ball_type' => 'required|string',
                'ball_area_id' => 'required|numeric',
                'wicket_id' => 'required|numeric',
                'wicket_type' => 'nullable|in:CAUGHT,LBW,BOWLED,RUN OUT,HIT WICKET,STUMPING',
                'field_type_id' => 'required',
                'power_play' => 'required|in:1,0',
                'remark' => 'nullable',
                'commentry' => 'nullable'            
        ]);

        if($validator->fails()){
            return Response::json(
                            ['error'=>[
                                        'error_message'=>$validator->errors()->all(),
                                        'status_code'=>403
                                ]],403);
        }
               // dd($request);
            $this->validate($request, [
                'match_id' => 'required|numeric',
                'team_id1' => 'required|numeric',
                'team_id2' => 'required|numeric',
                'innings' => 'required|numeric',
                'batsman_id' => 'required|numeric',
                'batsman_id2' => 'required|numeric',
                'bowler_id' => 'required|numeric',
                'fielder_id' => 'required|numeric',
                'batsman_score' => 'required|numeric',
                'bowler_given' => 'required|numeric',
                'extra_runs' => 'required|numeric',
                'total_runs' => 'required|numeric',
                'team_runs' => 'required|numeric',
                'for_wicket' => 'required|numeric',
                'ball_no' => 'required|numeric',
                'ball_type_id' => 'required|numeric',
                'ball_type' => 'required|string',
                'ball_area_id' => 'required|numeric',
                'wicket_id' => 'required|',
                'wicket_type' => 'nullable',
                'field_type_id' => 'required',
                'power_play' => 'required',
                'remark' => 'nullable',
                'commentry' => 'nullable'
            ]);


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
           // dd($request->trans_id);
            /*if(isset($request->trans_id))
            {
                return response()->json(['status'=>200, 'message'=>'Undo Done Sucessfully']);
            }*/

            return $data;
            // DB::commit();
            // $data['status'] = 200;
            // $data['msg'] = "Entry Added Successfuly";
           // return response()->json($data);
            $output['status'] = 400;
            $output['msg'] = "Transection Fail";
            $output['error'] = $e;
            return response()->json($output);
        // }
    }

    public function undoTick($request){
        // DB::beginTransaction();
        // try {
            //dd($data);
            $this->calBatsman($request);
            $this->calBowler($request);
            $this->calFilder($request);
            $this->calPartnership($request);
            $this->calScoreMasterUndo($request);
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
           // dd($request->trans_id);
            return response()->json(['status'=>200, 'message'=>'Undo Done Sucessfully']);
            
            
        // }
    }

    public function calBatsmanPowerplay($request){
        $this->BatsmanPowerplay_model->saveBatsmanTickData($request);
    }
    public function calBowlerPowerplay($request){
        $this->BowlerPowerplay_model->saveBowlerTickData($request);
    }
    public function calFilderPowerplay($request){
        $this->FilderPowerplay_model->saveFielderTickData($request);
    }
    
    public function calFielderDetail($request){
        
        $this->FielderDetail_model->saveFielderDetail($request);
    }
    
    public function calPartnershipDetail($request){
        $this->PartnershipDetail_model->savePartnershipDetail($request);
    }
    
    public function calBatsmanDetail($request){
        
        $this->BatsmanDetail_model->saveBatsmanDetail($request);
    }

    public function calBowlerDetail($request){
        $this->BowlerDetail_model->saveBowlerDetail($request);
    }

    public function calScore($request){
       return $this->Balldata_model->saveBalldata($request);
    }
    public function calBatsman($request){
        
        $this->BatsmanMaster_model->saveBatsmanTickData($request);
    }
    public function calBowler($request){        
        $this->BowlerMaster_model->saveBowlerTickData($request);
    }
    public function calFilder($request){
        $this->FilderMaster_model->saveFielderTickData($request);
    }
    public function calPartnership($request){        
        $this->PartnershipMaster_model->savePartnershipTickData($request);
    }

    public function calScoreMaster($request){
       $this->ScoreMaster_model->saveTeamdata($request);
    }
   

    public function calScoreMasterUndo($request){
       $this->ScoreMaster_model->saveTeamdataUndo($request);
    }

    public function directBatsman(Request $request){
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
        $data = $this->Balldatahistory_model->saveBalldata($request);
        return response()->json($data);
    }
     
                 
}
