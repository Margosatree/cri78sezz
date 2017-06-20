<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class UpdateFielder extends Model
{
    use SoftDeletingTrait;
    protected $table = 'fielder_master';
    protected $primaryKey = 'trans_id';
    protected $guarded = [];
}
