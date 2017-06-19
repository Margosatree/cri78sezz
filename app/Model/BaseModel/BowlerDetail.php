<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;
class BowlerDetail extends Model
{
    use SoftDeletingTrait;
    protected $table = 'bowler_details';
    protected $primaryKey = 'match_id';
    protected $guarded = [];

}
