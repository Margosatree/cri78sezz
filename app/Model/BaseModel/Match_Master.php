<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Match_Master extends Model
{
    protected $table = 'match_master';

     public $timestamps = false;
     protected $primaryKey = 'match_id';
    
    protected $fillable = [
        'tournament_id','match_name', 'ground_name', 'match_type','overs', 'innings',
        'status','toss', 'team1_id','team2_id','location', 'match_date', 'ttl_overs',
        'ttl_player_each_cnt', 'win_toss_id', 'selected_to_by_toss_winner', 'inning_1', 
        'inning_2', 'created_by', 'created_date', 'modified_by', 'modified_date','team1', 'team2',
        
    ];
    protected $guarded = ['match_id'];
    
    public function Team1Name(){
        return $this->belongsTo(Team_Master::class,'team1_id','id');
    }
    public function Team2Name(){
        return $this->belongsTo(Team_Master::class,'team2_id','id');
    }
}
