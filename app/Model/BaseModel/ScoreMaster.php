<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ScoreMaster extends Model
{
    use SoftDeletes;
    protected $table = 'score_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];

}
