<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class MatchSquad extends Model
{
    use SoftDeletes;
    protected $table = 'match_squad';
    protected $guarded = [];

}
