<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tournament_Rules extends Model
{
    use SoftDeletes;
    protected $table = 'tournament_rule_master';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name','specification', 'value','range_from','range_to'
    ];
}
