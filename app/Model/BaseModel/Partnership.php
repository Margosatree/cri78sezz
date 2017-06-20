<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class Partnership extends Model
{
    use SoftDeletes;
    protected $table = 'partnership_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];

}