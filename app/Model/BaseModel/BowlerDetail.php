<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class BowlerDetail extends Model
{
    use SoftDeletes;
    protected $table = 'bowler_details';
    protected $primaryKey = 'match_id';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
