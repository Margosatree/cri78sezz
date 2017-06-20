<?php

namespace App\Model;
use App\Model\BaseModel\BowlerDetail;
use App\Model\Balldata_model;
use App\Model\BallArea_model;
class BowlerDetail_model {
	
    protected $Balldata_Model;
    protected $BallArea_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
        $this->BallArea_Model = new BallArea_model();
    }

     private function isBallAreaExists($where_data){
        return BowlerDetail::where($where_data)->get();
    }

    public function saveBowlerDetail($request){

    $where_data = [
            'match_id' => $request->match_id,
            'bowler_id' => $request->bowler_id,
            'innings' => $request->innings,
            'ball_area_id' => $request->ball_area_id
        ];

    $ball_area_exists = $this->isBallAreaExists($where_data);
    $Ball_Details = $this->Balldata_Model->getBowlerDetails($where_data);       
    $this->saveBowlerDetailMaster($ball_area_exists, $request, $Ball_Details);

    }

    public function saveBowlerDetailMaster($update, $request, $BatsmanTick){
       // dd($BatsmanTick);
        if(count($update) > 0){
            $BowlerDetail = $update->first();//Update
            //dd($Batsman);
        }else{
            $BowlerDetail = new BowlerDetail();//Add
        }
        $ball_area = BallArea::where('id',$request->ball_area_id)->value('name');        
        $BowlerDetail->match_id = $request->match_id;
        $BowlerDetail->innings = $request->innings;
        $BowlerDetail->bowler_id = $request->bowler_id;
        $BowlerDetail->run_given = $BatsmanTick->run_given;
        $BowlerDetail->ball_count = $BatsmanTick->ball_count;
        $BowlerDetail->ball_area_id = $request->ball_area_id;
        $BowlerDetail->ball_area = $ball_area;
       /* $BowlerDetail->type = $BatsmanTick->type;
        $BowlerDetail->other = $BatsmanTick->other;
        $BowlerDetail->remark = $BatsmanTick->remark; */       
       // dd($Batsman);//NA
        $BowlerDetail->save();
    }
}