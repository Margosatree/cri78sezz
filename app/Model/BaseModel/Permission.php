<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'description'];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
