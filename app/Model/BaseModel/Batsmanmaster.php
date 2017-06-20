<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Batsmanmaster extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'TransId';
    protected $table = 'batsmanmaster';
    protected $guarded = [];
    public $timestamps = False;
}
