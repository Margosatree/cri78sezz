<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Model\BaseModel\Balldata;
class Balldatahistory extends Model
{
    use SoftDeletes;    
    protected $table = 'ball_data_history';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
    protected $dates = ['deleted_at'];  
    
}
