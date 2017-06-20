<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class Bowler extends Model {

    use SoftDeletingTrait;
    protected $table = 'bowler_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    
}