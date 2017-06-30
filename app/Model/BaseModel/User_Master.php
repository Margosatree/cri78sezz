<?php

namespace App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User_Master extends Model
{
    use SoftDeletes;
    protected $table = 'user_masters';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'first_name','middle_name', 'last_name','date_of_birth','gender',
        'physically_challenged','phone','email', 'username'
    ];
    protected $hidden = [
        'created_at','updated_at','deleted_by','updated_by','deleted_at'
    ];
    public function user_master(){
        return $this->belongsTo(User::class);
    }
    public function balldata()
    {
        return $this->hasMany('App\Model\BaseModel\Balldata','batsman_id','id');
    }
    
}
