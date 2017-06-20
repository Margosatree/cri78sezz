<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PartnershipDetail extends Model
{
    use SoftDeletes;
    protected $table = 'partnership_details';
    protected $primaryKey ='match_id';
    protected $guarded = [];

}
