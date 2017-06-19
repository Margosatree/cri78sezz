<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Balldata extends Model
{
    use Notifiable,SoftDeletingTrait;
    protected $table = 'ball_data';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    

    public function userinfo(){
        return $this->belongsTo(User_Master::class,'batsman_id','id');
    }

    public function userCrickinfo(){
        return $this->belongsTo(User_Cricket_Profile::class,'batsman_id','user_master_id');
    }

}
