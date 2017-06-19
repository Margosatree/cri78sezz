<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
    use SoftDeletingTrait;
    protected $table = 'scoremaster';
    protected $guarded = [];
}
