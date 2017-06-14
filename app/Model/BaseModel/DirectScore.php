<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class DirectScore extends Model
{
    //use Notifiable;
    protected $table = 'score_master';
    //protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
   // protected $Balldata_Model;

    public function __construct() {
       // $this->Balldata_Model = new Balldata();
    }

    public function storeDirectScore(Request $request){
        $status = false;
        //$players = explode(",",$request->players);
        $status = DB::table('score_master')->insert(['match_id'=>$request->match_id,'innings'=>$request->innings,'team_id'=>$request->team_id,'team_score'=>$request->team_score,'team_wickets'=>$request->team_wickets,'total_extras'=>$request->total_extras,'total_nb'=>$request->total_nb,'total_wd'=>$request->total_wd,'total_leg_byes'=>$request->total_leg_byes,'total_byes'=>$request->total_byes,'toss_won'=>$request->toss_won, 'status'=>$request->status,'run_rate'=>$request->run_rate,'total_balls'=>$request->total_balls]);        
        
        return $status;
    }
}
