<?php

namespace App\Model;
use App\Model\BaseModel\Partnership;
use App\Model\Balldata_model;
class Partnership_model {

    protected $Balldata_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
    }
    
    private function isBastsmanExists($where_array){
        return Partnership::where($where_array)->value('trans_id');
    }
    
    public function savePartnershipTickData($request){
        $where_array = [
            'match_id' => $request->match_id,
            'batsman_id' => $request->batsman_id,
            'innings' => $request->innings,
            'for_wicket' => $request->for_wicket,
        ];
        $batsman1_exists = $this->isBastsmanExists($where_array);
        
        $where_array['batsman_id'] = $request->batsman_id2;
        $batsman2_exists = $this->isBastsmanExists($where_array);
        
        if($batsman1_exists && $batsman2_exists){
            
            $both_exists = true;
            $where_array['batsman_id'] = $request->batsman_id;
    $Bat_Summery = $this->Balldata_Model->getPartnershipSummery($where_array);
            
            $Bat_Summery->bowler_id = $request->bowler_id;
            $Bat_Summery->fielder_id = $request->fielder_id;
            $Bat_Summery->for_wicket = $request->wicket_count;
            $Bat_Summery->batsman_name = $Bat_Summery->userinfo->first_name.' '.$Bat_Summery->userinfo->last_name;
            // $Bat_Summery->batsman_type = $Bat_Summery->userCrickinfo->player_type;
            $this->savePartnershipMaster($batsman1_exists,$Bat_Summery);
        }else{
            $both_exists = false;
            $where_array['batsman_id'] = $request->batsman_id;
            $Bat_Summery = $this->Balldata_Model->getPartnershipSummery($where_array);

            // dd($Bat_Summery);
            // dd($this->Balldata_Model->getPartnershipSummery($where_array));
            $Bat_Summery->bowler_id = $request->bowler_id;
            $Bat_Summery->fielder_id = $request->fielder_id;
            $Bat_Summery->for_wicket = $request->wicket_count;
            $Bat_Summery->batsman_name = $Bat_Summery->userinfo->first_name.' '.$Bat_Summery->userinfo->last_name;
            
            $this->savePartnershipMaster($both_exists,$Bat_Summery);
            $this->dummyPartnership($request);
        }
        echo json_encode($Bat_Summery->userinfo->first_name);
        // echo json_encode($Bat_Summery->userCrickinfo->player_type);
        
    }
    
    public function savePartnershipMaster($update,$BatsmaTick){
        if($update){
            $Batsman = Partnership::find($update);//Update
        }else{
            $Batsman = new Partnership();//Add
        }
        $Batsman->match_id = $BatsmaTick->match_id;
        $Batsman->order_id = $BatsmaTick->order_id; //find
        $Batsman->innings = $BatsmaTick->innings;
        $Batsman->for_wicket = $BatsmaTick->for_wicket; //find
        $Batsman->batsman_id = $BatsmaTick->batsman_id;
        $Batsman->batsman_name = $BatsmaTick->batsman_name;
        $Batsman->batsman_type = $BatsmaTick->batsman_type;
        $Batsman->balls = $BatsmaTick->balls;
        $Batsman->runs = $BatsmaTick->runs;
        $Batsman->run0 = $BatsmaTick->run0;
        $Batsman->run1 = $BatsmaTick->run1;
        $Batsman->run2 = $BatsmaTick->run2;
        $Batsman->run3 = $BatsmaTick->run3;
        $Batsman->run4 = $BatsmaTick->run4;
        $Batsman->run6 = $BatsmaTick->run6;
        $Batsman->run_ext = $BatsmaTick->run_ext; //NA
        $Batsman->strike_rate = $BatsmaTick->strike_rate;
        $Batsman->bowler_id = $BatsmaTick->bowler_id; 
        $Batsman->fielder_id = $BatsmaTick->fielder_id;
        $Batsman->wicket_type = $BatsmaTick->wicket_type; //NA
        $Batsman->ball_length_id = $BatsmaTick->ball_length_id; //NA
        $Batsman->area_id = $BatsmaTick->area_id; //NA
        $Batsman->out = $BatsmaTick->out; //NA
        $Batsman->index = $BatsmaTick->index; //NA
        $Batsman->save();
    }
    
    public function dummyPartnership($request){
        $dummyData = new \stdClass();
        $dummyData->match_id = $request->match_id;
        $dummyData->order_id = $request->order_id; //find
        $dummyData->innings = $request->innings;
        $dummyData->for_wicket = $request->wicket_count; //find
        $dummyData->batsman_id = $request->batsman_id2;
        $dummyData->batsman_name = $request->batsman_name;
        $dummyData->batsman_type = $request->batsman_type;
        $dummyData->balls = 0;
        $dummyData->runs = 0;
        $dummyData->run0 = 0;
        $dummyData->run1 = 0;
        $dummyData->run2 = 0;
        $dummyData->run3 = 0;
        $dummyData->run4 = 0;
        $dummyData->run6 = 0;
        $dummyData->run_ext = 0; //NA
        $dummyData->strike_rate = 0;
        $dummyData->bowler_id = 0; 
        $dummyData->fielder_id = 0;
        $dummyData->wicket_type = null; //NA
        $dummyData->ball_length_id = 0; //NA
        $dummyData->area_id = 0; //NA
        $dummyData->out = null; //NA
        $dummyData->index = 0; //NA
        $this->savePartnershipMaster(false, $dummyData);
    }
}