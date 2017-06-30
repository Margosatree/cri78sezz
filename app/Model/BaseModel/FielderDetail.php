<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class FielderDetail extends Model
{
    use SoftDeletes;
    protected $table = 'fielder_details';
    protected $primaryKey = 'match_id';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
}
