<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Model\BaseModel\Balldata;

class Batsman extends Model
{
    use SoftDeletes;
    protected $table = 'batsman_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    
    
    
}