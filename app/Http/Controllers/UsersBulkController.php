<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User_Master;
use App\User_Organisation;
use Auth;
use Excel;
use Validator;
use Hash;
use Session;
class UsersBulkController extends Controller
{
    
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth');
//        $this->middleware('auth',['except'=>['index']]);
    }
    
    public function bulkUploadView(){
        $Errors = 0;
        return view('user.org.bulk', compact('Errors'));
    }
    public function bulkUpload(Request $request){
//        dd('dasdas');
        if(Input::hasFile('import_file')){
//            dd('dasdas1');
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
                    
            if(!empty($data) && $data->count()){
                $Errors = array();
                $count = 0;
                foreach ($data as $key => $value) {
                    if(isset($value['username']) || !isEmpty($value['username'])){
                        if(strlen(''.$value['username']) > 50){
                            $username['lengh'] = 'Username Filed Is Too Long';
                        }
                        if(!ctype_alnum(''.$value['username'])){
                            $username['alpha_num'] = 'Must Be Alphanumeric';
                        }    
                        $Username_Exists = User_Master::selectRaw('count(id) as count')->where('username',$value['username'])->get()->first();  
                        if($Username_Exists->count){
                            $username['unique'] = 'Username Already Exists';
                        }
                    }else{
                        $username['data'] = 'Data Not Found';
                    }
                    if(isset($value['phone']) || !isEmpty($value['phone'])){
                        if(!is_numeric($value['phone'])){
                            $phone['numeric'] = 'Should Be A Number';
                        }
                        if(strlen(''.$value['phone']) != 10){
                            $phone['lengh'] = 'Invalid Phone Number';
                        }
                        if(!preg_match('/(7|8|9)\d{9}/', $value['phone'])){
                            $phone['phonenumber'] = 'Phone Number Should Start With 9|8|7';
                        }
                        $Phone_Exists = User_Master::selectRaw('count(id) as count')->where('phone',$value['phone'])->get()->first();  
                        if($Phone_Exists->count){
                            $phone['unique'] = 'Phone Already Exists';
                        }
                    }else{
                        $phone['data'] = 'Data Not Found';
                    }
                    if(isset($value['email']) || !isEmpty($value['email'])){
                        if(strlen(''.$value['email']) > 50){
                            $email['lengh'] = 'email Filed Is Too Long';
                        }
                        if(!preg_match('/(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@[*[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+]*/', $value['email'])){
                            $email['email'] = 'Invalid Email';
                        }
                        $email_Exists = User_Master::selectRaw('count(id) as count')->where('email',$value['email'])->get()->first();  
                        if($email_Exists->count){
                            $email['unique'] = 'Email Already Exists';
                        }
                    }else{
                        $email['data'] = 'Data Not Found';
                    }
                    if(isset($username) && count($username) > 0){
                        $User_Data['username'] = $username;
                    }
                    if(isset($phone) && count($phone) > 0){
                        $User_Data['phone'] = $phone;
                    }
                    if(isset($email) && count($email) > 0){
                        $User_Data['email'] = $email;
                    }
                    if(isset($User_Data) && count($User_Data) > 0){
                        $User_Data['u_id'] = $value['id'];
                        $User_Data['u_username'] = $value['username'];
                        $User_Data['u_phone'] = $value['phone'];
                        $User_Data['u_email'] = $value['email'];
                        $Errors[$value['id']] = $User_Data;
                    }
                    if(!isset($username) && !isset($phone) && !isset($email)){
                        $User_master = new User_Master;
                        $User_master->username = $value['username'];
                        $User_master->phone = $value['phone'];
                        $User_master->email = $value['email'];
                        $User_master->save();

                        $User_Org = new User_Organisation();
                        $User_Org->user_master_id = $User_master->id;
                        $User_Org->organization_master_id = Auth::user()->organization_master_id;
                        $User_Org->email = $value['email'];
                        $User_Org->password = Hash::make($value['username'].'@123');
                        $User_Org->role = 'user';
                        $User_Org->save();
                    }else{
                        $count++;
                    }
                }
//                dd($Errors);
                Session::put('msg','Your '.$count.' Entry Is Not Saved');
                return view('user.org.bulk', compact('Errors'));
            }
        }
        Session::put('msg','Please Select File');
        return redirect()->back();
    }
    
    
    
    public function storeInfo(Request $request){
        $this->validate(request(), [
            'first_name' => 'required|max:50|alpha',
            'middle_name' => 'required|max:50|alpha',
            'last_name' => 'required|max:50|alpha',
            'date_of_birth' => 'required|date|before:'.date('Y-m-d', strtotime('-5 year')),
            'gender' => 'in:female,male',
            'physically_challenged' => 'in:no,yes',
        ]);
//        dd($request->all());
        $id = Auth::user()->user_master_id;
        $User_master = User_Master::find($id);
        $User_master->first_name = $request->first_name;
        $User_master->middle_name = $request->middle_name;
        $User_master->last_name = $request->last_name;
        $User_master->date_of_birth = $request->date_of_birth;
        $User_master->gender = $request->gender;
        $User_master->physically_challenged = $request->physically_challenged;
        $User_master->save();
        return redirect()->route('userBio.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'address' => 'required|max:255',
            'suburb' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'country' => 'required|max:255',
            'pin' => 'required|digits:6|numeric',
        ]);
//        dd($request->all());
        $id = Auth::user()->user_master_id;
        $bio = User_Master::find($id);
        $bio->address = request('address');
        $bio->suburb = request('suburb');
        $bio->city = request('city');
        $bio->state = request('state');
        $bio->country = request('country');
        $bio->pin = request('pin');
        $bio->save();
        return redirect()->route('orgcriProfile.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Bio = User_Master::find($id);
        return view('user.bio.show',compact('Bio'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editInfo($id){
        $Bio = User_Master::find($id);
        return view('user.bio.editInfo', compact('Bio'));
    }
    
    public function edit($id){
        $Bio = User_Master::find($id);
        return view('user.bio.edit', compact('Bio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $id){
//        dd(request()->all());
        $callfrom = "";
        if(request('first_name') || request('middle_name') || request('last_name') ||
           request('date_of_birth') || request('gender') || request('physically_challenged')
                ){
            $this->validate(request(), [
                'first_name' => 'required|max:255',
                'middle_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:female,male,others',
                'physically_challenged' => 'required|in:no,yes',
            ]);
            $callfrom = 'info';
        }else{
            $this->validate(request(), [
                'address' => 'required|max:255',
                'suburb' => 'required|max:255',
                'city' => 'required|max:255',
                'state' => 'required|max:255',
                'country' => 'required|max:255',
                'pin' => 'required|digits:6|numeric',
            ]);
        }
//        dd('dasdas');
        $Bio = User_Master::find($id);
        if($callfrom == 'info'){
            $Bio->first_name = request('first_name');
            $Bio->middle_name = request('middle_name');
            $Bio->last_name = request('last_name');
            $Bio->date_of_birth = request('date_of_birth');
            $Bio->gender = request('gender');
            $Bio->physically_challenged = request('physically_challenged');
        }else{
            $Bio->address = request('address');
            $Bio->suburb = request('suburb');
            $Bio->city = request('city');
            $Bio->state = request('state');
            $Bio->country = request('country');
            $Bio->pin = request('pin');
        }
        $Bio->save();
        if(Auth::user()->role == "admin"){
            return redirect()->route('userBio.index');
        }else{
            return view('user.bio.show',compact('Bio'));
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("i am at destroy");
    }
}
