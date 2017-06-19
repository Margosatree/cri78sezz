<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class ScoreMaster extends Model
{
    use SoftDeletingTrait;
    protected $table = 'score_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];

}
