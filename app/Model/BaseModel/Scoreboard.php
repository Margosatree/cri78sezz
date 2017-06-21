<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
    use SoftDeletes;
    protected $table = 'scoremaster';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
