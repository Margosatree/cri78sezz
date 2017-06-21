<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BowlerMaster extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'TransId';
    protected $table = 'bowllermaster';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
