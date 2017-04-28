<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Cricket_Profile extends Model
{
    protected $table = 'cricket_profiles';
    
    protected $fillable = [
        'your_role','batsman_style', 'batsman_order', 'bowler_style',
        'player_type','description','display_img'
    ];
}
