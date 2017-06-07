<?php

namespace App\Model\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function users()
    {
     return $this->belongsToMany(config('auth.providers.users.model'));
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission')->withTimestamps();
    }
}
