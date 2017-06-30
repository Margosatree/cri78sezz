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

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
}
