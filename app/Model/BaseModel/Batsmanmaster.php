<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class Batsmanmaster extends Model
{
    use SoftDeletingTrait;
    protected $primaryKey = 'TransId';
    protected $table = 'batsmanmaster';
    protected $guarded = [];
    public $timestamps = False;
}
