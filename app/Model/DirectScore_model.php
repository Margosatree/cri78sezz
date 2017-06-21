<?php

namespace App\Model;
use App\Model\BaseModel\DirectScore;
use DB;
class DirectScore_model {

    public function __construct() {
        
    }

    public function storeDirectScore($request){
        $status = false;
        //$players = explode(",",$request->players);
        $status = DB::table('score_master')->insert(['match_id'=>$request->match_id,'innings'=>$request->innings,'team_id'=>$request->team_id,'team_score'=>$request->team_score,'team_wickets'=>$request->team_wickets,'total_extras'=>$request->total_extras,'total_nb'=>$request->total_nb,'total_wd'=>$request->total_wd,'total_leg_byes'=>$request->total_leg_byes,'total_byes'=>$request->total_byes,'toss_won'=>$request->toss_won, 'status'=>$request->status,'run_rate'=>$request->run_rate,'total_balls'=>$request->total_balls]);        
        
        return $status;
    }
     
}