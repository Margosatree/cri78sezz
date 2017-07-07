<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VirtualUser extends Model
{
    use SoftDeletes;
    protected $table = 'virtual_users';
    protected $dates = ['deleted_at'];
}
