<?php

namespace App\Http\Controllers\Web\Users\Player;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\BaseModel\User_Master;
use App\Model\BaseModel\verify_user;

class UserVerifyController extends Controller
{
    
    public function __construct(){
         //$this->middleware('guest',['only'=>['storeGuest','showVerify']]);
         $this->middleware('auth',['except'=>['storeGuest','showVerify']]);
         
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // logic

        $this->validate($request,[
            'token' => 'required',
            'verify_email' => 'required|numeric',
            'verify_phone' => 'required|numeric',
        ]);

        $get_datas = verify_user::where('token',$request->token)
                                ->get();

        foreach($get_datas as $get_data){
            $mobile_otp = $get_data->mobile_otp;
            $email_otp = $get_data->email_otp;
            $email = $get_data->email;
            $mobile = $get_data->mobile;
        }
        
        if($email_otp!=$request->verify_email){
            Session::flash('status','Email Otp is Invalid');
            return redirect()->back()->withInput();
        }

        if($mobile_otp!=$request->verify_phone){
           Session::flash('status','Mobile Otp is Invalid');
           return redirect()->back()->withInput();
        }

        User_Master::where(['phone'=>$mobile,'email'=>$email])
                    ->update(['is_verify_phone'=>1,'is_verify_email'=>1]);

        Session::flash('status','Successfuly Verified'); 
        // if(Auth::user()->role =="organizer"){
        //     return redirect()->route('org.create');
        // }else{
            return redirect()->route('userBio.createInfo');
        // }

        if(Auth::guest()){
            return back()->withInput();
        }
       
    }
    function showVerify($token,$email_otp){

        return view('auth.verifyguest',['token'=>$token,'email_otp'=>$email_otp]);
    }

    function storeGuest(Request $request){
        // if(Session::has('key')){
        //     Session::forget('key');
        // }
        $this->validate($request,[
            'token' => 'required',
            'verify_email' => 'required|numeric',
            'verify_phone' => 'required|numeric',
        ]);

        $get_datas =verify_user::where('token',$request->token)
                                ->get();
        foreach($get_datas as $get_data){
            $mobile_otp = $get_data->mobile_otp;
            $email_otp = $get_data->email_otp;
            $email = $get_data->email;
            $mobile = $get_data->mobile;
        }
        
        if($email_otp!=$request->verify_email){
            Session::flash('status','Email Otp is Invalid');
            return redirect()->back()->withInput();
        }

        if($mobile_otp!=$request->verify_phone){
           Session::flash('status','Mobile Otp is Invalid');
           return redirect()->back()->withInput();
        }

        User_Master::where(['phone'=>$mobile,'email'=>$email])
                    ->update(['is_verify_phone'=>1,'is_verify_email'=>1]);

        Session::flash('status','Successfuly Verified');
        return $this->showVerify($token =null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        return view('auth.verify',['token'=>$token]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
