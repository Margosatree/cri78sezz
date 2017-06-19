<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class Tournament_Rules extends Model
{
    use SoftDeletingTrait;
    protected $table = 'tournament_rule_master';
    
    protected $fillable = [
        'name','specification', 'value','range_from','range_to'
    ];
}
