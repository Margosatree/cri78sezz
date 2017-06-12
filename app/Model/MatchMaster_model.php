<?php

namespace App\Model;
use App\Model\BaseModel\Match_Master;

class MatchMaster_model {

	public function __construct(){
		//parent::__construct();
	}
	
	public function checkTourId($Tour_id){
            return Match_Master::selectRaw('*')->whereIn('tournament_id',$Tour_id)->get();
	}

	public function getDetailByTourMatch($Tournament,$id){
            return Match_Master::selectRaw('*')->where('tournament_id',$Tournament)->where('match_id',$id)->get()->first();
        }

	public function getDetailById($id){
		return Match_Master::find($id);
	}

	public function SaveMatch($request){
            if(isset($request->update) && $request->update == 1){
                $Match = Match_Master::where('tournament_id', $request->tournament_id)->where('match_id', $request->id);
                $arr = array();
                if(isset($request->team1_id) && $request->team1_id){
                    $arr['team1_id'] = $request->team1_id;
                }
                if(isset($request->team2_id) && $request->team2_id){
                    $arr['team2_id'] = $request->team2_id;
                }
                if(isset($request->match_name) && $request->match_name){
                    $arr['match_name'] = $request->match_name;
                }
                if(isset($request->ground_name) && $request->ground_name){
                    $arr['ground_name'] = $request->ground_name;
                }
                if(isset($request->match_type) && $request->match_type){
                    $arr['match_type'] = $request->match_type;
                }
                if(isset($request->match_date) && $request->match_date){
                    $arr['match_date'] = $request->match_date;
                }
                if(isset($request->overs) && $request->overs){
                    $arr['overs'] = $request->overs;
                }
                if(isset($request->innings) && $request->innings){
                    $arr['innings'] = $request->innings;
                }
                $Match->update($arr);
            }else{
                $Match = new Match_Master;
                if(isset($request->tournament_id) && $request->tournament_id){
                    $Match->tournament_id = $request->tournament_id;
                }
                if(isset($request->team1_id) && $request->team1_id){
                    $Match->team1_id = $request->team1_id;
                }
                if(isset($request->team2_id) && $request->team2_id){
                    $Match->team2_id = $request->team2_id;
                }
                if(isset($request->match_name) && $request->match_name){
                    $Match->match_name = $request->match_name;
                }
                if(isset($request->ground_name) && $request->ground_name){
                    $Match->ground_name = $request->ground_name;
                }
                if(isset($request->match_type) && $request->match_type){
                    $Match->match_type = $request->match_type;
                }
                if(isset($request->match_date) && $request->match_date){
                    $Match->match_date = $request->match_date;
                }
                if(isset($request->overs) && $request->overs){
                    $Match->overs = $request->overs;
                }
                if(isset($request->innings) && $request->innings){
                    $Match->innings = $request->innings;
                }
                $Match->save();
            }
            return $Match;
        }
	
	public function updateByTourId($Tournament,$id,$request){
            $Match = Match_Master::where('tournament_id', $Tournament)->where('match_id', $id);
            $Match->update([
                'team1_id' => $request->team1,
                'team2_id' => $request->team2,
                'match_name' => $request->match_name,
                'ground_name' => $request->ground_name,
                'match_type' => $request->match_type,
                'match_date' => $request->match_date,
                'overs' => $request->overs,
                'innings' => $request->innings,
            ]);
            return $Match;
	}

	public function deleteByTourMatch($Tournament,$id){
            return Match_Master::where(['tournament_id'=>$Tournament,'match_id'=>$id])->delete();
	}

}