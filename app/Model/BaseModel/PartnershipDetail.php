<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class PartnershipDetail extends Model
{
    use SoftDeletingTrait;
    protected $table = 'partnership_details';
    protected $primaryKey ='match_id';
    protected $guarded = [];

}
