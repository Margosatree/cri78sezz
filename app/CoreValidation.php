<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Balldata;
class CoreValidation extends Model
{
	
	public function checkMaiden($maiden_parameters){


		if($maiden_parameters['ball_no']%6 == 0)
		{
			$start_ball = $maiden_parameters['ball_no'] - 6;       

			$run = Balldata::select(DB::raw('SUM(bowler_given) as runs, count(*) as ball_count'))
			->where('bowler_id',$maiden_parameters['bowler_id'])
			->where('innings', $maiden_parameters['innings'])
			->where('match_id', $maiden_parameters['match_id'])
			->where('ball_no','>', $start_ball)
			->where('ball_no','<=',$maiden_parameters['ball_no'])
			->get()->first();

			$run->runs = $run->runs + $maiden_parameters['bowler_given'];
			$run->ball_count = $run->ball_count + 1;
			if($run->runs == 0 && $run->ball_count == 6)
			{   
				return 1;            
			}
		}           
		return 0;      

	}
}
