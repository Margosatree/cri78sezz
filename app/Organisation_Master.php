<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation_Master extends Model
{
    protected $table = 'organization_masters';
    
    protected $fillable = [
        'name','address', 'landmark', 'city','state', 'country',
        'pincode','business_type', 'business_operation', 'spoc','is_verified'
    ];
}
