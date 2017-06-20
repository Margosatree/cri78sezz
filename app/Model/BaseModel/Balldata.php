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

    public function userCrickinfo(){
        return $this->belongsTo(User_Cricket_Profile::class,'batsman_id','user_master_id');
    }

}
