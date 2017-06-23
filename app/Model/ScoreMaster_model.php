<?php

namespace App\Model;
use App\Model\BaseModel\ScoreMaster;
use App\Model\Balldata_model;
use App\Model\Fall_Of_Wicket_model;
class ScoreMaster_model {

    protected $Balldata_Model;
    protected $Fall_Of_Wicket_model;

    public function __construct() {
        $this->Balldata_Model = new Balldata_model();
        $this->Fall_Of_Wicket_model = new Fall_Of_Wicket_model();
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
        //dd($request);
        if($request->wicket_type != NULL){
            $this->Fall_Of_Wicket_model->saveFallOfWickets($Score_Summery,$request);
        }
        $this->saveScoreMaster($record_exists,$Score_Summery,$request);
    }
    public function saveTeamdataUndo($request){
        $where_array = [
            'match_id' => $request->match_id,
            'innings' => $request->innings,
        ];
        $record_exists = $this->isRecordExists($where_array);
        $Score_Summery = $this->Balldata_Model->getScoreMasterSummery($where_array);
        //dd($request);
        if($request->wicket_type != NULL){
            $this->Fall_Of_Wicket_model->saveFallOfWicketsUndo($Score_Summery,$request);
        }
        $this->saveScoreMaster($record_exists,$Score_Summery,$request);
    }
    
    public function saveScoreMaster($update,$Score_Summery,$request){
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