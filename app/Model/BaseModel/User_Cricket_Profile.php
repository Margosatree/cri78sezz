<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User_Cricket_Profile extends Model
{
    use SoftDeletes;
    protected $table = 'cricket_profiles';
    
    protected $fillable = [
        'your_role','batsman_style', 'batsman_order', 'bowler_style',
        'player_type','description','display_img'
    ];
}
