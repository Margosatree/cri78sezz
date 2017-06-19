<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
    use SoftDeletingTrait;
    protected $table = 'role_user';
}
