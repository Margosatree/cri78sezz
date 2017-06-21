<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User_Achievement extends Model
{
    use SoftDeletes;
    protected $table = 'user_achievements';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title','orgname','name','location', 'start_date', 'end_date'
    ];
}
