<?php

namespace App\Model;
use App\Model\BaseModel\Balldata;
use App\Model\BaseModel\CoreValidation;
use DB;
class Balldata_model {

    public function __construct(){
        //parent::__construct();
    }
	
   public function isBowlerRecordExists($where_array){
        return Balldata::where($where_array)->value('trans_id');
    }

    public function isFielderRecordExists($where_array){
        return Balldata::where($where_array)->value('trans_id');
    }
    public function checkBowlerOversCount($request){

        $over_count = Balldata::where('bowler_id',$request->new_id)
                     ->where('match_id',$request->match_id)
                     ->where('innings',$request->innings)
                     ->select(DB::raw('COUNT(DISTINCT CEIL(over_no)) as over_count'))
                     ->get()
                     ->first()
                     ->over_count;

        return $over_count;
    }
    public function checkUp($request)
    {   $lower = $request->over_no - 2;
        $upper = $request->over_no - 1;
        $bowler_id = Balldata::select('bowler_id')
                 ->where('over_no','>',$lower )
                 ->where('over_no','<=',$upper)
                 ->where('match_id',$request->match_id)
                 ->where('innings',$request->innings)
                 ->distinct()
                 ->get();

        if(count($bowler_id) > 0 && ($bowler_id->first()->bowler_id == $request->new_id))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function checkDown($request)
    {   $lower = $request->over_no;
        $upper = $request->over_no + 1;
        $bowler_id = Balldata::select('bowler_id')
                 ->where('over_no','>',$lower )
                 ->where('over_no','<=',$upper)
                 ->where('match_id',$request->match_id)
                 ->where('innings',$request->innings)
                 ->distinct()
                 ->get();

        if(count($bowler_id) > 0 && ($bowler_id->first()->bowler_id == $request->new_id))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /*public function checkInPlayers($request)
    {
        $playing = MatchSquad::select('playing')
                   ->where('match_id',$request->match_id)
                   ->where('player_id',$request->new_id)
                   ->get();

        return $playing;  
    }*/
    public function getBatsmanSummery($where_data){
        return Balldata::selectRaw(" 
            SUM(IF(batsman_score = 1,1,0)) AS run1,
            SUM(IF(batsman_score = 2,1,0)) AS run2,
            SUM(IF(batsman_score = 3,1,0)) AS run3,
            SUM(IF(batsman_score = 4,1,0)) AS run4,
            SUM(IF(batsman_score = 6,1,0)) AS run6,
            SUM(IF(batsman_score = 0,1,0)) AS run0,
            SUM(batsman_score) AS runs,
            SUM(IF(batsman_score = 0,1,0)) AS run0,
            SUM(IF(batsman_score = 0,1,0)) AS run0,
            SUM(IF(ball_type='NORM',1,0)) AS balls,
            ROUND((SUM(batsman_score)/SUM(IF(ball_type='NORM',1,0)))*100,2) AS strike_rate,
            IF(power_play = 1,1,0) AS power_play,
            batsman_id,match_id,innings")
        ->where($where_data)
        ->groupby(['batsman_id','match_id','innings'])
        ->get()->first();
    }

    public function overwiseBallerInfo($where_array){
       return Balldata::select('match_id','innings','bowler_id',DB::raw('CEIL(over_no) as over_no'),DB::raw('GROUP_CONCAT(ball_no) as ball_no_list'))
           ->where('match_id',$where_array['match_id'])
           ->where('innings',$where_array['innings'])
           ->groupBy(DB::raw('CEIL(over_no)'),'match_id','innings','bowler_id')
           ->get();
    }

    public function overwiseFielderInfo($where_array){
       return Balldata::select('match_id','innings','fielder_id',DB::raw('GROUP_CONCAT(ball_no) as ball_no_list'))
           ->where('match_id',$where_array['match_id'])
           ->where('innings',$where_array['innings'])
           ->groupBy('fielder_id','match_id','innings')
           ->orderBy('fielder_id')
           ->get();
    }

    public function updateBallerInfo($where_array){
        return Balldata::where('match_id',$where_array['match_id'])->where('innings',$where_array['innings'])->where('bowler_id',$where_array['old_id'])->where(DB::raw('CEIL(over_no)'),$where_array['over_no'])->update(['bowler_id'=>$where_array['new_id']]);
    }

    public function updateFielderInfo($where_array){
        return Balldata::where('match_id',$where_array['match_id'])->where('innings',$where_array['innings'])->where('ball_no',$where_array['ball_no'])->where('fielder_id',$where_array['old_fielder_id'])->update(['fielder_id'=>$where_array['new_fielder_id']]);
    }

    public function matchInfo($request)
    {
        return Balldata::where('match_id',$request->match_id)->get()->toArray();
    }

    public function deleteMatchInfo($request)
    {
        Balldata::where('match_id',$request->match_id)->delete();
    }

    public function undoRecord($request)
    {   
        $data = Balldata::where('match_id',$request->match_id)
                ->where('innings',$request->innings)
                ->orderBy('trans_id','DESC')
                ->take(1)
                ->get();
       // dd($data);
        $delete_count = Balldata::where('match_id',$request->match_id)
                        ->where('innings',$request->innings)
                        ->orderBy('trans_id','DESC')
                        ->take(1)
                        ->delete(); 

        return $data;       
    }
    public function getBatsmanDetails($where_data){

        return Balldata::selectRaw("
            SUM(batsman_score) AS run_score,
            count(*) AS shot_count,
            batsman_id, match_id, innings, ball_area_id
            ")
        ->where($where_data)
        ->groupby(['batsman_id','match_id','innings','ball_area_id'])
        ->get()->first();        
    }

    public function getFielderDetails($where_data){

        return Balldata::selectRaw("
            sum(batsman_score) AS run_count,
            sum(if(wicket_id in (1),1,0)) AS catch,
            sum(if(wicket_id in (4),1,0)) AS run_out,
            sum(if(field_type_id in (8),1,0)) AS drop_catch,
            count(*) AS field_count,
            sum(if(field_type_id in (9),1,0)) AS misfield_count,
            fielder_id, match_id, innings, ball_area_id
            ")
        ->where($where_data)
        ->groupby(['fielder_id','match_id','innings','ball_area_id'])
        ->get()->first();        
    }

    public function getPartnerDetails($where_data){

        return Balldata::selectRaw("
            SUM(batsman_score) AS run_score,
            count(*) AS shot_count,
            batsman_id, match_id, innings, ball_area_id, for_wicket
            ")
        ->where($where_data)
        ->groupby(['batsman_id','match_id','innings','ball_area_id','for_wicket'])
        ->get()->first();        
    }

    public function getBowlerSummery($where_data){
        return Balldata::selectRaw(" 
            SUM(IF(bowler_given = 0,1,0)) AS run0,
            SUM(IF(bowler_given = 1,1,0)) AS run1,
            SUM(IF(bowler_given = 2,1,0)) AS run2,
            SUM(IF(bowler_given = 3,1,0)) AS run3,
            SUM(IF(bowler_given = 4,1,0)) AS run4,
            SUM(IF(bowler_given = 6,1,0)) AS run6,
            SUM(IF(wicket_id = 1,1,0)) AS caught,
            SUM(IF(wicket_id = 3,1,0)) AS bowled,
            SUM(IF(wicket_id = 5,1,0)) AS hitwicket,
            SUM(IF(wicket_id = 6,1,0)) AS stumping,
            SUM(IF(wicket_id = 2,1,0)) AS lbw,
            SUM(bowler_given) AS runs, 
            SUM(IF(extra_runs > 0 ,extra_runs,0)) AS run_ext,
            SUM(IF(ball_type IN ( 'WD' ),1,0)) AS run_ext_wd,
            SUM(IF(ball_type IN ( 'NB+WD', 'NB'),1,0)) AS run_ext_nb, 
            SUM(IF(for_wicket > 0,for_wicket,0)) AS wicket,
            SUM(maiden) AS maiden,
            SUM(IF(ball_type NOT IN ('WD','NB+WD'),1,0)) AS balls,
            ROUND(SUM(IF(ball_type NOT IN ('WD','NB+WD','NB'),1,0)) / 6,1) AS overs,
            ROUND(SUM(bowler_given)*6/COUNT(ball_no)) AS econ,
            IF(power_play = 1,1,0) AS power_play,
            bowler_id,match_id,innings")
        ->where($where_data)
        ->groupby(['bowler_id','match_id','innings'])
        ->get()->first();
    }
    

    public function getBowlerDetails($where_data){

        return Balldata::selectRaw("
            SUM(bowler_given) AS run_given,
            count(*) AS ball_count,
            bowler_id, match_id, innings, ball_area_id
            ")
        ->where($where_data)
        ->groupby(['bowler_id','match_id','innings','ball_area_id'])
        ->get()->first();         
    }

    public function getFilderSummery($where_data){
        return Balldata::selectRaw("
            sum(batsman_score) AS run_count,
            sum(if(wicket_id in (1),1,0)) AS caught,
            sum(if(wicket_id in (4),1,0)) AS run_out,
            sum(if(field_type_id in (8),1,0)) AS drop_catch,
            sum(if(field_type_id in (9),1,0)) AS misfield,
            sum(if(wicket_id in (6),1,0)) AS stumping,
            sum(if(field_type_id in (12),1,0)) AS over_throw,
            IF(power_play = 1,1,0) AS power_play,
            fielder_id, match_id, innings
            ")
        ->where($where_data)
        ->groupby(['fielder_id','match_id','innings'])
        ->get()->first();        
    }
    
    public function getPartnershipSummery($where_data){
        return Balldata::selectRaw(" 
            SUM(IF(batsman_score = 1,1,0)) AS run1,
            SUM(IF(batsman_score = 2,1,0)) AS run2,
            SUM(IF(batsman_score = 3,1,0)) AS run3,
            SUM(IF(batsman_score = 4,1,0)) AS run4,
            SUM(IF(batsman_score = 6,1,0)) AS run6,
            SUM(IF(batsman_score = 0,1,0)) AS run0,
            SUM(batsman_score) AS runs,
            SUM(IF(batsman_score = 0,1,0)) AS run0,
            SUM(IF(batsman_score = 0,1,0)) AS run0,
            SUM(IF(ball_type='NORM',1,0)) AS balls,
            ROUND((SUM(batsman_score)/SUM(IF(ball_type='NORM',1,0)))*100,2) AS strike_rate,
            batsman_id,match_id,innings,for_wicket")
        ->where($where_data)
        ->groupby(['batsman_id','match_id','innings','for_wicket'])
        // ->toSql();
        ->get()->first();
    }

    public function getScoreMasterSummery($where_array){
            return Balldata::selectRaw("
            SUM(total_runs) AS team_score,
            MAX(for_wicket) AS team_wickets,
            SUM(extra_runs) AS total_extras,
            SUM(IF(ball_type IN('NB','NB+WD'),1,0)) AS total_nb,
            SUM(IF(ball_type IN('WD'),extra_runs,0)) AS total_wd,
            SUM(IF(ball_type IN('LB'),extra_runs,0)) AS total_leg_byes,
            SUM(IF(ball_type IN('B'),extra_runs,0)) AS total_byes,
            SUM(total_runs)/(ROUND((MAX(ball_no)-MOD(MAX(ball_no),6))/6,0)+ROUND(MOD(MAX(ball_no),6)/10,1)) AS run_rate,
            ROUND((MAX(ball_no)-MOD(MAX(ball_no),6))/6,0)+ROUND(MOD(MAX(ball_no),6)/10,1) AS over, 
            MAX(ball_no) AS total_balls,
            match_id,innings")
        ->where($where_array)
        ->groupby(['match_id','innings'])
        ->get()->first();
    }
    
        /*public function checkMaiden($maiden_parameters){
            if($maiden_parameters['ball_type'] == 'NORM' && $maiden_parameters['ball_no']%6 == 0 && $maiden_parameters['ball_no'] != 0)
            {
                $start_ball = $maiden_parameters['ball_no'] - 6;       

                $run = Balldata::select(DB::raw('SUM(total_runs) as runs'))
                ->where('bowler_id',$maiden_parameters['bowler_id'])
                ->where('innings', $maiden_parameters['innings'])
                ->where('match_id', $maiden_parameters['match_id'])
                ->where('ball_no','>', $start_ball)
                ->where('ball_no','<=',$maiden_parameters['ball_no'])
                ->get()->first();
                
                //dd($run->runs); 
            if($run->runs == 0)
            {   
                return 1;            
            }
            else{
             //dd("Hi");
             return 0;  
             
            }        
                
            } 
              // dd("Hii");
               return 0;           
               
            }*/
    public function strikeChange($request)
    {
        $temp = $request->batsman_id;
        $request->batsman_id = $request->batsman_id2;
        $request->batsman_id2 = $temp;
        return $request;
    }

    public function saveBalldata($request){ 
        $validate = new CoreValidation(); 
        $m_trans_id = 0;
        $maiden_parameters = array();
        $maiden_parameters['ball_type'] = $request->ball_type;
        $maiden_parameters['ball_no'] = $request->ball_no;
        $maiden_parameters['innings'] = $request->innings;
        $maiden_parameters['match_id'] = $request->match_id;
        $maiden_parameters['bowler_id'] = $request->bowler_id;
        $maiden_parameters['bowler_given'] = $request->bowler_given;
        $maiden = $validate->checkMaiden($maiden_parameters);
        //dd($maiden);
        $max_m_trans_id = Balldata::select(DB::raw('MAX(m_trans_id) as m_trans_id'))
        ->where('match_id',$request->match_id)
        ->get();
        if(count($max_m_trans_id) != 0)
        {
            $m_trans_id = $max_m_trans_id->first()->m_trans_id + 1;
        }
        else{
            $m_trans_id = 1; 
        }

        if(isset($request->trans_id) && $request->trans_id > 0){
            //Update
            dd('Update Balldata');
        }else{
            //Add 
    $over = (int)($request->ball_no / 6) + .1 * ( $request->ball_no % 6);
            $Balldata = new Balldata();
            $Balldata->m_trans_id = $m_trans_id;
            $Balldata->match_id = $request->match_id;
            $Balldata->team_id1 = $request->team_id1;
            $Balldata->team_id2 = $request->team_id2;
            $Balldata->innings = $request->innings;
            $Balldata->batsman_id = $request->batsman_id;
            $Balldata->batsman_id2 = $request->batsman_id2;
            $Balldata->bowler_id = $request->bowler_id;
            $Balldata->fielder_id = $request->fielder_id;
            $Balldata->batsman_score = $request->batsman_score;
            $Balldata->bowler_given = $request->bowler_given;
            $Balldata->extra_runs = $request->extra_runs;
            $Balldata->total_runs = $request->total_runs;
            $Balldata->for_wicket = $request->for_wicket;
            $Balldata->ball_no = $request->ball_no;
            $Balldata->ball_type_id = $request->ball_type_id;
            $Balldata->ball_type = $request->ball_type;
            $Balldata->over_no = $over;
            $Balldata->maiden = $maiden;
            $Balldata->wicket_id = $request->wicket_id;
            $Balldata->wicket_type = $request->wicket_type;
           // $Balldata->wicket_desc = $request->wicket_desc;
            $Balldata->ball_length_id = $request->ball_length_id;
            $Balldata->ball_area_id = $request->ball_area_id;
            //$Balldata->insidecircle = $request->insidecircle;
            $Balldata->field_type_id = $request->field_type_id;
            $Balldata->power_play = $request->power_play;
            $Balldata->remark = $request->remark;
            $Balldata->commentry = $request->commentry;            
            $Balldata->save();
            $strike_cng = $request;
            //dd($strike_cng);
            if($request->ball_type == "NORM" || $request->ball_type == "LB" || $request->ball_type == "B")
            {   
                if($request->total_runs % 2 != 0)
                {
                    $strike_cng = $this->strikeChange($request);
                }
            }
            elseif($request->ball_type == "NB" || $request->ball_type == "WD" || $request->ball_type == "NB+WD")
            {   
                $runs = $request->total_runs - 1;
                if($runs % 2 != 0)
                {
                    $strike_cng = $this->strikeChange($request);
                }
            }
           // dd($over);
            if($request->ball_no % 6 == 0 && $over <= 8)
            {
                $strike_cng = $this->strikeChange($request);
            }

            if($request->for_wicket == 10)
            {
                return response()->json(['status'=>400, 'message'=>'Inning Break', 'batsman_id'=>$strike_cng->batsman_id, 'batsman_id2'=>$strike_cng->batsman_id2]);
            }
            elseif($request->ball_no % 6 == 0)
            {
                if($over >= 8)
                {
                return response()->json(['status'=>400, 'message'=>'Inning Break', 'batsman_id'=>$strike_cng->batsman_id, 'batsman_id2'=>$strike_cng->batsman_id2]);
                }
                return response()->json(['status'=>200, 'message'=>'Change Bowler', 'batsman_id'=>$strike_cng->batsman_id, 'batsman_id2'=>$strike_cng->batsman_id2]);
            }
            else{
                return response()->json(['status'=>200, 'message'=>'Inning is going on', 'batsman_id'=>$strike_cng->batsman_id, 'batsman_id2'=>$strike_cng->batsman_id2]);
            }

        }
    }
}