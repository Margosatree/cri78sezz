<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TournamentUser extends Model
{
    use SoftDeletes;
    protected $table = 'tournament_users';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'tour_id','user_id','deleted_by'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_by','deleted_at'
    ];
}

