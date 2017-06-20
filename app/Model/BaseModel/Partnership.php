<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Partnership extends Model
{
    use SoftDeletingTrait;
    protected $table = 'partnership_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];

}