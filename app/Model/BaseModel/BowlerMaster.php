<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class BowlerMaster extends Model
{
    use SoftDeletingTrait;
    protected $primaryKey = 'TransId';
    protected $table = 'bowllermaster';
    protected $guarded = [];
    public $timestamps = False;
}
