<?php

namespace App\Model;
use App\Model\BaseModel\FielderDetail;
use App\Model\Balldata_model;
use App\Model\BallArea_model;
class FielderDetail_model {
	
    protected $Balldata_Model;
    protected $BallArea_Model;
    
    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
        $this->BallArea_Model = new BallArea_model();
    }

    private function isFielderAreaExists($where_data){
        return FielderDetail::where($where_data)->get();
    }

    public function saveFielderDetail($request){

    $where_data = [
            'match_id' => $request->match_id,
            'fielder_id' => $request->fielder_id,
            'innings' => $request->innings,
            'ball_area_id' => $request->ball_area_id
        ];

    $fielder_area_exists = $this->isFielderAreaExists($where_data);
    $Fielder_Details = $this->Balldata_Model->getFielderDetails($where_data);       
    $this->saveFielderDetailMaster($fielder_area_exists, $request, $Fielder_Details);

    }

    public function saveFielderDetailMaster($update, $request, $BatsmanTick){
       // dd($BatsmanTick);
        if(count($update) > 0){
            $FielderDetail = $update->first();//Update
            //dd($Batsman);
        }else{
            $FielderDetail = new FielderDetail();//Add
        }
        $ball_area = $this->BallArea_Model->getBallArea($request->ball_area_id);        
        $FielderDetail->match_id = $request->match_id;
        $FielderDetail->innings = $request->innings;
        $FielderDetail->fielder_id = $request->fielder_id;
        $FielderDetail->run_count = $BatsmanTick->run_count;
        $FielderDetail->catch = $BatsmanTick->catch;
        $FielderDetail->run_out = $BatsmanTick->run_out;
        $FielderDetail->drop_catch = $BatsmanTick->drop_catch;
        $FielderDetail->field_count = $BatsmanTick->field_count;
        $FielderDetail->misfield_count = $BatsmanTick->misfield_count;
        $FielderDetail->ball_area_id = $request->ball_area_id;
        $FielderDetail->ball_area = $ball_area;
       /* $FielderDetail->type = $BatsmanTick->type;
        $FielderDetail->other = $BatsmanTick->other;
        $FielderDetail->remark = $BatsmanTick->remark; */       
       // dd($Batsman);//NA
        $FielderDetail->save();
    } 
}