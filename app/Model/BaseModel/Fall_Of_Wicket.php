<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class Fall_Of_Wicket extends Model
{
    use SoftDeletingTrait;
    protected $table = 'fall_of_wickets';
    protected $guarded = [];
}
