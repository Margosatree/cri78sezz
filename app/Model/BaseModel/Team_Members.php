<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Team_Members extends Model
{
    use SoftDeletes;
    protected $table = 'team_members';
    protected $fillable = [
        'team_id','user_master_id','tournament_id', 'selected_as'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
    
    public function owner(){
        return $this->belongsTo(User_Master::class,'team_owner_id','id');
    }
}
