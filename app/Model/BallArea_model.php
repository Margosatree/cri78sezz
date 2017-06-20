<?php

namespace App\Model;
use App\Model\BaseModel\BallArea;
use App\Model\BaseModel\CoreValidation;
use DB;
class BallArea_model {

    public function __construct() {
        
    }
    public function getBallArea($ball_area_id){
        return BallArea::where('id',$ball_area_id)->value('name');
    }
     
}