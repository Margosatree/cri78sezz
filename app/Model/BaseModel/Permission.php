<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'description'];
    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
