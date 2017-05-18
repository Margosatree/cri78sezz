<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Master extends Model
{
    protected $table = 'user_masters';
    
    protected $fillable = [
        'first_name','middle_name', 'last_name','date_of_birth','gender',
        'physically_challenged','phone','email', 'username'
    ];
    public function user_master(){
        return $this->belongsTo(User::class);
    }
    public function team_masters(){
        return $this->hasMany(User_Master::class);
    }
}
