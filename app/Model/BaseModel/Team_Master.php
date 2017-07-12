<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Team_Master extends Model
{
    use SoftDeletes;
    protected $table = 'team_master';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'team_name','team_owner_id', 'team_type', 'team_logo', 'order_id', 'owner_id','image','imagedata'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
    
    public function owner(){
        return $this->belongsTo(User_Master::class,'team_owner_id','id');
    }
}
