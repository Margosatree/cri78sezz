<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class BowlerMaster extends Model
{
    protected $primaryKey = 'TransId';
    protected $table = 'bowllermaster';
    protected $guarded = [];
    public $timestamps = False;
}
