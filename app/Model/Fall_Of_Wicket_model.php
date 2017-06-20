<?php

namespace App\Model;
use App\Model\BaseModel\Fall_Of_Wicket;
class Fall_Of_Wicket_model {

    public function __construct() {
        
    }
    
    public function saveFallOfWickets($Score_Summery,$request){
        $Fall_Of_Wicket = new Fall_Of_Wicket();
        $Fall_Of_Wicket->match_id = $Score_Summery->match_id;
        $Fall_Of_Wicket->innings = $Score_Summery->innings;
        $Fall_Of_Wicket->team_id = $request->team_id1;
        $Fall_Of_Wicket->wicket = $Score_Summery->team_wickets; 
        $Fall_Of_Wicket->score = $Score_Summery->team_score; 
        $Fall_Of_Wicket->over = $Score_Summery->over; 
        $Fall_Of_Wicket->batsman_id = $request->batsman_id;
        $Fall_Of_Wicket->save();
    }
}