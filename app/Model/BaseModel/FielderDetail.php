<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;
class FielderDetail extends Model
{
    use SoftDeletingTrait;
    protected $table = 'fielder_details';
    protected $primaryKey = 'match_id';
    protected $guarded = [];
    
}
