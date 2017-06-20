<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Organisation_Master extends Model
{
    use SoftDeletingTrait;
    protected $table = 'organization_masters';
    
    protected $fillable = [
        'name','address', 'landmark', 'city','state', 'country',
        'pincode','business_type', 'business_operation', 'spoc','is_verified'
    ];
    
}
