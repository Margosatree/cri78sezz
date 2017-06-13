<?php

namespace App\Http\Controllers\Web\Users\Player;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\BaseModel\User_Master;
use App\Model\BaseModel\verify_user;
use App\Services\V1\SendMailAndOtpServices;

class UserVerifyController extends Controller
{

    protected $SendMailAndOtpServices;   
    public function __construct(){
         //$this->middleware('guest',['only'=>['storeGuest','showVerify']]);
         $this->middleware('auth',['except'=>['storeGuest','showVerify']]);
        $this->SendMailAndOtpServices =new SendMailAndOtpServices();
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

        $check_if_exists = $this->_checkVerifyUser($request);
        if(count($check_if_exists)){
            Session::flash('status','Successfuly Verified'); 
            return redirect()->route('userBio.createInfo'); 
        }

        Session::flash('status','Email Or Mobile Otp is Invalid');
        return redirect()->back()->withInput();
       
    }

    function showVerify($token,$email_otp){

        return view('auth.verifyguest',['token'=>$token,'email_otp'=>$email_otp]);
    }

    function storeGuest(Request $request){
        $this->validate($request,[
            'token' => 'required',
            'verify_email' => 'required|numeric',
            'verify_phone' => 'required|numeric',
        ]);

        $check_if_exists = $this->_checkVerifyUser($request);
        if(count($check_if_exists)){
            Session::flash('status','Successfuly Verified');
            return $this->showVerify($token =null); 
        }

        Session::flash('status','Email Or Mobile Otp is Invalid');
        return redirect()->back()->withInput();

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

    private function _checkVerifyUser($request){
        $data = array(
                        'token' => $request->token,
                        'email_otp' => $request->verify_email,
                        'mobile_otp' => $request->verify_phone
                    );

        return $this->SendMailAndOtpServices->verifyEmailMobileUser($data);
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
