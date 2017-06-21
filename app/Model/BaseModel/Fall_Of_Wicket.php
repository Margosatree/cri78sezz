<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Fall_Of_Wicket extends Model
{
    use SoftDeletes;
    protected $table = 'fall_of_wickets';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
