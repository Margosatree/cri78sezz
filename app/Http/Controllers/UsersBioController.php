<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User_Master;
use Auth;

class UsersBioController extends Controller
{
    
    public function __construct(){
//        $this->middleware(['auth'=>'admin','auth']);
//        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User_Bios = User_Master::all();
        return view('user.bio.index',compact('User_Bios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.bio.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        return redirect()->route('criProfile.create');
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
        $this->validate(request(), [
//            'username' => 'required|max:255',
//            'first_name' => 'required|max:255',
//            'middle_name' => 'required|max:255',
//            'last_name' => 'required|max:255',
//            'date_of_birth' => 'date',
//            'gender' => 'in:female,male,others',
//            'physically_challenged' => 'in:no,yes',
//            'phone' => 'required|min:10|numeric',
//            'email' => 'required|email|unique:user_masters',
            'address' => 'required|max:255',
            'suburb' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'country' => 'required|max:255',
            'pin' => 'required|digits:6|numeric',
        ]);
        $Bio = User_Master::find($id);
//        $Bio->username = request('username');
//        $Bio->first_name = request('first_name');
//        $Bio->middle_name = request('middle_name');
//        $Bio->last_name = request('last_name');
//        $Bio->date_of_birth = request('date_of_birth');
//        $Bio->gender = request('gender');
//        $Bio->physically_challenged = request('physically_challenged');
//        $Bio->phone = request('phone');
//        $Bio->email = request('email');
        $Bio->address = request('address');
        $Bio->suburb = request('suburb');
        $Bio->city = request('city');
        $Bio->state = request('state');
        $Bio->country = request('country');
        $Bio->pin = request('pin');
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
