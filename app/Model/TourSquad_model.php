<?php

namespace App\Model;
use App\Model\BaseModel\TourSquad;
class TourSquad_model {

    public function __construct() {
        
    }
    
    public function storeTourSquad($request){
        $status = false;
        $players = explode(",",$request->players);
        foreach($players as $player){
            $status = TourSquad::create([
                'tournament_id'=>$request->tournament_id,
                'team_id'=>$request->team_id,
                'player_id'=>$player
            ]);        
        }
        return $status;
    }
}