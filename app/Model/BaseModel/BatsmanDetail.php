<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class BatsmanDetail extends Model
{
    use SoftDeletingTrait;
    protected $table = 'batsman_details';
  //protected $primaryKey = 'trans_id';
     protected $primaryKey ='match_id';

    protected $guarded = [];
    public $timestamps = false;
}
