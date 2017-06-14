<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Tournament_Rules extends Model
{
    protected $table = 'tournament_rule_master';
    
    protected $fillable = [
        'name','specification', 'value','range_from','range_to'
    ];
}
