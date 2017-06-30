<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User_Cricket_Profile extends Model
{
    use SoftDeletes;
    protected $table = 'cricket_profiles';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'your_role','batsman_style', 'batsman_order', 'bowler_style',
        'player_type','description','display_img'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
}
