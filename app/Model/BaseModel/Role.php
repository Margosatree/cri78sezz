<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'slug', 'description'];

     protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];

    public function users()
    {
     return $this->belongsToMany(config('auth.providers.users.model'));
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission')->withTimestamps();
    }
}
