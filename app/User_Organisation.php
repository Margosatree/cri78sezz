<?php

namespace App;
use PHPZen\LaravelRbac\Traits\Rbac;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User_Organisation extends Authenticatable
{
    use Rbac;
    use Notifiable;
    protected $table = 'user_organizations';
    
    public function roles(){
        return $this->belongsToMany('PHPZen\LaravelRbac\Model\Role','role_user','user_id','role_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_master_id','organization_master_id', 'registration_type',
        'registration_date','email', 'password','role', 'remember_token','current_password'
    ];

    public function user(){
        return $this->belongsTo(User_Master::class,'user_master_id','id');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
