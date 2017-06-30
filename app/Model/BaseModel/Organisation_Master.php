<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Organisation_Master extends Model
{
    use SoftDeletes;
    protected $table = 'organization_masters';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name','address', 'landmark', 'city','state', 'country',
        'pincode','business_type', 'business_operation', 'spoc','is_verified'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
    
}
