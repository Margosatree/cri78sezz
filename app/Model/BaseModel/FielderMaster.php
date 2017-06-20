<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class FielderMaster extends Model
{
    use SoftDeletingTrait;
    protected $primaryKey = 'TransId';
    protected $table = 'fieldermaster';
    protected $guarded = [];
    public $timestamps = False;
}
