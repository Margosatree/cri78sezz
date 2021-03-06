<?php

namespace App\Model\BaseModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User_Organisation extends Authenticatable
{
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

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function user(){
        return $this->belongsTo(User_Master::class,'user_master_id','id');
    }
    
    public function criprofile(){
        return $this->belongsTo(User_Cricket_Profile::class,'user_master_id','user_master_id');
    }
    
    public function achieves(){
        return $this->hasMany(User_Achievement::class,'user_master_id','user_master_id');
    }
    
    public function org(){
        return $this->belongsTo(Organisation_Master::class,'organization_master_id','id');
    }
}
