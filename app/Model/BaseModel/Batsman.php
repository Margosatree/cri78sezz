<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;
use App\Model\BaseModel\Balldata;

class Batsman extends Model
{
    use SoftDeletingTrait;
    protected $table = 'batsman_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    public $timestamps = false;
    
    
    
}