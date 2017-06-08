<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class FielderMaster extends Model
{
    protected $primaryKey = 'TransId';
    protected $table = 'fieldermaster';
    protected $guarded = [];
    public $timestamps = False;
}
