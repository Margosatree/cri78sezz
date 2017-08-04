<?php

namespace App\Model;
use Illuminate\Http\Request;
use App\Model\BaseModel\User_Master;
use App\Model\BaseModel\VirtualUser;

class UserMaster_model {

    public function __construct() {
        //parent::__construct();
    }

    public function getAll() {
        return User_Master::all();
    }
    
    public function getAllFilter($where_array = false) {
        if($where_array){
            return User_Master::where($where_array)->get();
        }else{
            return User_Master::all();
        }
    }

    public function getById($user_id) {
        return User_Master::find($user_id);
    }
    
    public function checkUserId($Users){
        return User_Master::selectRaw('id,CONCAT(first_name," ",last_name) AS Owner_Name')
                    ->whereIn('id',$Users)->get();
    }
    
    public function userExists($username) {
        return User_Master::selectRaw('count(id) as count')->where('username', $username)->get()->first();
    }
    
    public function phoneExists($phone) {
        return User_Master::selectRaw('count(id) as count')->where('phone',$phone)->get()->first();
    }
    
    public function emailExists($email) {
        return User_Master::selectRaw('count(id) as count')->where('email',$email)->get()->first();
    }

    public function getAllValueByMobile($mobile_no){
        return User_Master::where('phone',$mobile_no)->get();
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
    
    public function SaveUserBio($request) {
        if(isset($request->update) && $request->update == 1){
            $User_master = User_Master::find($request->id);
        }else{
            $User_master = new User_master;
        }
        if(isset($request->first_name) && $request->first_name){
            $User_master->first_name = $request->first_name;
        }
        if(isset($request->middle_name) && $request->middle_name){
            $User_master->middle_name = $request->middle_name;
        }
        if(isset($request->last_name) && $request->last_name){
            $User_master->last_name = $request->last_name;
        }
        if(isset($request->date_of_birth) && $request->date_of_birth){
            $User_master->date_of_birth = $request->date_of_birth;
        }
        if(isset($request->gender) && $request->gender){
            $User_master->gender = $request->gender;
        }
        if(isset($request->physically_challenged) && $request->physically_challenged){
            $User_master->physically_challenged = $request->physically_challenged;
        }
        $User_master->save();
        return $User_master;
    }
    
    public function SaveUserAddress($request) {
        if(isset($request->update) && $request->update == 1){
            $User_master = User_Master::find($request->id);
        }else{
            $User_master = new User_master;
        }
        if(isset($request->address) && $request->address){
            $User_master->address = $request->address;
        }
        if(isset($request->suburb) && $request->suburb){
            $User_master->suburb = $request->suburb;
        }
        if(isset($request->city) && $request->city){
            $User_master->city = $request->city;
        }
        if(isset($request->state) && $request->state){
            $User_master->state = $request->state;
        }
        if(isset($request->country) && $request->country){
            $User_master->country = $request->country;
        }
        if(isset($request->pin) && $request->pin){
            $User_master->pin = $request->pin;
        }
        $User_master->save();
        return $User_master;
    }

    public function updateUserMaster($check_data=array(),$update_data=array()){
        return User_Master::where($check_data)->update($update_data);
    }

    public function getVirtualUserDetail($where_array) {
        return VirtualUser::orWhere($where_array)->first();
    }

    public function insertViratualUser($request){
        if(isset($request->update) && $request->update == 1){
            $User_master = VirtualUser::find($request->id);
        }else{
            $User_master = new VirtualUser;
        }
        if(isset($request->username) && $request->username){
            $User_master->username = $request->username;
        }
        if(isset($request->phone) && $request->phone){
            $User_master->phone = $request->phone;
        }
        if(isset($request->email) && $request->email){
            $User_master->email = $request->email;
        }
        if(isset($request->password) && $request->password){
            $User_master->password = $request->password;
        }
        if(isset($request->expected_role_id) && $request->expected_role_id){
            $User_master->expected_role_id = $request->expected_role_id;
        }
        if(isset($request->created_by) && $request->created_by){
            $User_master->created_by = $request->created_by;
        }
        if(isset($request->add_prifix) && $request->add_prifix){
            $User_master->add_prifix = $request->add_prifix;
        }
        if(isset($request->prifix_id) && $request->prifix_id){
            $User_master->prifix_id = $request->prifix_id;
        }
        if(isset($request->org_id) && $request->org_id){
            $User_master->org_id = $request->org_id;
        }
        $User_master->save();
        return $User_master;
    }

    public function deleteVUser($user_id){
        $id = VirtualUser::find($user_id);
        return $id->delete();
    }

    public function listUserDetails(){
        return User_Master::leftJoin('user_organizations as uo', 'uo.user_master_id', '=', 'user_masters.id')
            ->leftJoin('cricket_profiles as cp', 'cp.user_master_id', '=', 'user_masters.id')
            ->select('user_masters.*','uo.status','cp.display_img')
            ->get()->toArray();
    }
}
