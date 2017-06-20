<?php

namespace App\Model;
use App\Model\BaseModel\BatsmanDetail;
use App\Model\Balldata_model;
use App\Model\BallArea_model;
class BatsmanDetail_model {
	
    protected $Balldata_Model;
    protected $BallArea_model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
        $this->BallArea_model = new BallArea_model();
    }

     private function isBatAreaExists($where_data){
        return BatsmanDetail::where($where_data)->first();
    }

    public function saveBatsmanDetail($request){

    $where_data = [
            'match_id' => $request->match_id,
            'batsman_id' => $request->batsman_id,
            'innings' => $request->innings,
            'ball_area_id' => $request->ball_area_id
        ];

    $bat_area_exists = $this->isBatAreaExists($where_data);
    // dd($bat_area_exists);
    $Bat_Details = $this->Balldata_Model->getBatsmanDetails($where_data);       
    $this->saveBatsmanDetailMaster($bat_area_exists, $request, $Bat_Details);

    }

    public function saveBatsmanDetailMaster($update, $request, $BatsmanTick){
       // dd($BatsmanTick);
        if(count($update)){
        	//dd($update);
            $BatsmanDetail = $update;//Update
            //dd($Batsman);
        }else{
            $BatsmanDetail = new BatsmanDetail();//Add
        }
        $ball_area = $this->BallArea_model->getBallArea($request->ball_area_id);
        // dd($ball_area);        
        $BatsmanDetail->match_id = $request->match_id;
        //$BatsmanDetail->order_id = $BatsmanTick->order_id; //find
        $BatsmanDetail->innings = $request->innings;
        $BatsmanDetail->batsman_id = $request->batsman_id;
        $BatsmanDetail->run_score = $BatsmanTick->run_score;
        $BatsmanDetail->shot_count = $BatsmanTick->shot_count;
        $BatsmanDetail->ball_area_id = $request->ball_area_id;
        $BatsmanDetail->ball_area = $ball_area;
       /* $BatsmanDetail->type = $BatsmanTick->type;
        $BatsmanDetail->other = $BatsmanTick->other;
        $BatsmanDetail->remark = $BatsmanTick->remark; */       
       // dd($BatsmanDetail);//NA
        $BatsmanDetail->save();
    }
}