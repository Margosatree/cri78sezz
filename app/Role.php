<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function users()
    {
     return $this->belongsToMany(config('auth.providers.users.model'),'role_user','role_id','user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission')->withTimestamps();
    }
}
