<?php

namespace App\Model;
use App\Model\BaseModel\MatchSquad;
class MatchSquad_model {

    public function __construct() {
        
    }
    
    public function storeMatchSquad($request){
        $status = false;
        //$players = explode(",",$request->players);
      //  dd($request->players[0]['player']);
        foreach($request->players as $data){

            $status = MatchSquad::create([
                'tournament_id'=>$request->tournament_id,
                'team_id'=>$request->team_id,
                'match_id'=>$request->match_id,
                'player_id'=>$data['player_id'],
                'playing'=>$data['playing']
            ]);        
        }
        return $status;
    }

    public function checkInPlayers($request)
    {
        $playing = MatchSquad::select('playing')
                   ->where('match_id',$request->match_id)
                   ->where('player_id',$request->new_id)
                   ->get();

        return $playing;  
    }
}