<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;
class MatchSquad extends Model
{
    use SoftDeletingTrait;
    protected $table = 'match_squad';
    protected $guarded = [];

}
