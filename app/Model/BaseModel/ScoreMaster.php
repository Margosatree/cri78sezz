<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class ScoreMaster extends Model
{
    protected $table = 'score_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;

    protected $Balldata_Model;

    public function __construct() {
        $this->Balldata_Model = new Balldata();
    }

    private function isRecordExists($where_array){
        return ScoreMaster::where($where_array)->value('trans_id');
    }
    
    public function saveTeamdata($request){
        $where_array = [
            'match_id' => $request->match_id,
            'innings' => $request->innings,
        ];
        $record_exists = $this->isRecordExists($where_array);
        $Score_Summery = $this->Balldata_Model->getScoreMasterSummery($where_array);
       if($request->wicket_type != NULL)
       {
        $this->saveFallOfWickets($Score_Summery,$request);
       }
        $this->saveBastsmanMaster($record_exists,$Score_Summery,$request);
        
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
    public function saveBastsmanMaster($update,$Score_Summery,$request){
       // dd($Score_Summery);
        if($update){
            $ScoreMaster = ScoreMaster::find($update);//Update
            //dd($ScoreMaster);
        }else{
            $ScoreMaster = new ScoreMaster();//Add
        }
        $ScoreMaster->match_id = $Score_Summery->match_id;
        $ScoreMaster->innings = $Score_Summery->innings;
        $ScoreMaster->team_id = $request->team_id1;
        $ScoreMaster->team_score = $Score_Summery->team_score;
        $ScoreMaster->team_wickets = $Score_Summery->team_wickets;
        $ScoreMaster->total_extras = $Score_Summery->total_extras;
        $ScoreMaster->total_nb = $Score_Summery->total_nb;
        $ScoreMaster->total_wd = $Score_Summery->total_wd;
        $ScoreMaster->total_leg_byes = $Score_Summery->total_leg_byes;
        $ScoreMaster->total_byes = $Score_Summery->total_byes;
      //$ScoreMaster->toss_won = $Score_Summery->run3;
      //$ScoreMaster->status = $Score_Summery->run4;
        $ScoreMaster->run_rate = $Score_Summery->run_rate;
        $ScoreMaster->total_balls = $Score_Summery->total_balls;         
        $ScoreMaster->save();
    }

}
