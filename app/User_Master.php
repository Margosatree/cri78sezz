<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPZen\LaravelRbac\Traits\Rbac;

class User_Master extends Model
{
	use Rbac;
    protected $table = 'user_masters';
    
    /*protected $fillable = [
        'first_name','middle_name', 'last_name','date_of_birth','gender',
        'physically_challenged','phone','email', 'username'
    ];*/
    protected $guarded = [];
    public function user_master(){
        return $this->belongsTo(User::class);
    }
}
