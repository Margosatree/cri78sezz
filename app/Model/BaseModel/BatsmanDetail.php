<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BatsmanDetail extends Model
{
    use SoftDeletes;
    protected $table = 'batsman_details';
  //protected $primaryKey = 'trans_id';
    protected $primaryKey ='match_id';

    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
