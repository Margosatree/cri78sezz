<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Team_Master extends Model
{
    protected $table = 'team_master';
    
    protected $fillable = [
        'team_name','team_owner_id', 'team_type', 'team_logo', 'order_id', 'owner_id','image','imagedata'
    ];
    
    public function owner(){
        return $this->belongsTo(User_Master::class,'team_owner_id','id');
    }
}
