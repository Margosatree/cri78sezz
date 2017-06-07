<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BallArea extends Model
{
    protected $table = 'ball_area_master';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
