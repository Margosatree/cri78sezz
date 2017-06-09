<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Tournament_Master extends Model
{
    protected $table = 'tournament_master';
    
    protected $fillable = [
        'tournament_name','tournament_location', 'tournament_logo',
        'start_date','end_date', 'reg_start_date', 'reg_end_date','image','imagedata'
        
    ];
    
    protected $hidden = [
        'created_at','updated_at'
    ];
}
