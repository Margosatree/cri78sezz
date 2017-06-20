<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bowler extends Model {

    use SoftDeletes;
    protected $table = 'bowler_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    
}