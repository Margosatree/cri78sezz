<?php

namespace App\Model;

use App\User_Master;

class UserMaster_model {

    public function __construct() {
        //parent::__construct();
    }

    public function getAll() {
        return User_Master::all();
    }

    public function getById($user_id) {
        return User_Master::find($user_id);
    }

    public function checkUserId($Users){
        return User_Master::selectRaw('id,CONCAT(first_name," ",last_name) AS Owner_Name')
                    ->whereIn('id',$Users)->get();
    }
    
    public function checkUserId($Users){
        return User_Master::selectRaw('id,CONCAT(first_name," ",last_name) AS Owner_Name')
                    ->whereIn('id',$Users)->get();
    }
    
    public function userExists($username) {
        return User_Master::selectRaw('count(id) as count')->where('username', $username)->get()->first();
    }
    public function phoneExists($username) {
        return User_Master::selectRaw('count(id) as count')->where('phone',$value['phone'])->get()->first();
    }
    public function emailExists($username) {
        return User_Master::selectRaw('count(id) as count')->where('email',$value['email'])->get()->first();
    }

    public function getValueByEmail($user_email) {
        if (is_numeric($user_email)) {
            return User_Master::where('phone', $user_email)->get();
        } else {
            return User_Master::where('email', $user_email)->get();
        }
    }

    public function insert($data) {
        $User_master = new User_Master;
        $User_master->username = $data['username'];
        $User_master->phone = $data['phone'];
        $User_master->email = $data['email'];
        $User_master->save();
        return $User_master;
    }
    
    public function SaveUserBio($data) {
        if(isset($data['id']) && $data['id'] > 0){
            $User_master = User_Master::find($data['id']);
        }else{
            $User_master = new User_Master;
        }
        $User_master->first_name = $data['first_name'];
        $User_master->middle_name = $data['middle_name'];
        $User_master->last_name = $data['last_name'];
        $User_master->date_of_birth = $data['date_of_birth'];
        $User_master->gender = $data['gender'];
        $User_master->physically_challenged = $data['physically_challenged'];
        $User_master->save();
        return $User_master;
    }
    
    public function SaveUserAddress($data) {
        if(isset($data['id']) && $data['id'] > 0){
            $User_master = User_Master::find($data['id']);
        }else{
            $User_master = new User_Master;
        }
        $User_master->address = $data['address'];
        $User_master->suburb = $data['suburb'];
        $User_master->city = $data['city'];
        $User_master->state = $data['state'];
        $User_master->country = $data['country'];
        $User_master->pin = $data['pin'];
        $User_master->save();
        return $User_master;
    }

}
