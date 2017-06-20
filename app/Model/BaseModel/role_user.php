<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
    use SoftDeletes;
    protected $table = 'role_user';
}
