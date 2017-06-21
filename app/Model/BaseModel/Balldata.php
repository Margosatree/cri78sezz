<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Balldata extends Model
{
    use SoftDeletes;
    protected $table = 'ball_data';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    //public $timestamps = false;
    
    protected $dates = ['deleted_at'];
    
    public function userinfo(){
        return $this->belongsTo(User_Master::class,'batsman_id','id');
    }

     /*public function userinfo()
    {
        return $this->belongsTo('App\Model\BaseModel\User_Master','batsman_id','id');
    }*/

    public function userCrickinfo(){
        return $this->belongsTo(User_Cricket_Profile::class,'batsman_id','user_master_id');
    }

    // public function getPartnershipSummery($where_data){
    //     return Balldata::selectRaw(" 
    //         SUM(IF(batsman_score = 1,1,0)) AS run1,
    //         SUM(IF(batsman_score = 2,1,0)) AS run2,
    //         SUM(IF(batsman_score = 3,1,0)) AS run3,
    //         SUM(IF(batsman_score = 4,1,0)) AS run4,
    //         SUM(IF(batsman_score = 6,1,0)) AS run6,
    //         SUM(IF(batsman_score = 0,1,0)) AS run0,
    //         SUM(batsman_score) AS runs,
    //         SUM(IF(batsman_score = 0,1,0)) AS run0,
    //         SUM(IF(batsman_score = 0,1,0)) AS run0,
    //         SUM(IF(ball_type='NORM',1,0)) AS balls,
    //         ROUND((SUM(batsman_score)/SUM(IF(ball_type='NORM',1,0)))*100,2) AS strike_rate,
    //         batsman_id,match_id,innings,for_wicket")
    //     ->where($where_data)
    //     ->groupby(['batsman_id','match_id','innings','for_wicket'])
    //     // ->toSql();
    //     ->get()->first();
    // }

}
