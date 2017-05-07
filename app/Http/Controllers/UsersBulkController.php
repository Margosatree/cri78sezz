<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User_Master;
use App\User_Organisation;
use Auth;
use Excel;
class UsersBulkController extends Controller
{
    
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth');
//        $this->middleware('auth',['except'=>['index']]);
    }
    
    public function bulkUploadView(){
        return view('user.org.bulk');
    }
    public function bulkUpload(){
//        dd('dasdas');
        if(Input::hasFile('import_file')){
//            dd('dasdas1');
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
                    
            if(!empty($data) && $data->count()){
                $Arr = array();
//                dd($data);
                foreach ($data as $key => $value) {
                    
                    if(isset($value['username']) || isset($value['phone']) || isset($value['email'])
                    || $value['username'] != "" || $value['phone'] != "" || $value['email'] != ""){
                        $User_master = new User_Master;
                        $User_master->username = $value['username'];
                        $User_master->phone = $value['phone'];
                        $User_master->email = $value['email'];
                        $User_master->save();

                        $User_Org = new User_Organisation();
                        $User_Org->user_master_id = $User_master->id;
                        $User_Org->organization_master_id = 0;
                        $User_Org->email = $value['email'];
                        $User_Org->password = $value['username'].'@123';
                        $User_Org->role = 'user';
                        $User_Org->save();
                    }else{
                        array_push($Arr,$value);
                    }
                }
                if($Arr){
                    dd($Arr);
                }
//                if(!empty($insert)){
//                    DB::table('users')->insert($insert);
//                            dd('Insert Record successfully.');
////                    return view('importExport');
//                }
            }
        }
        return back();
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
