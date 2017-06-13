<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;
// use Illuminate\Support\Facades\Log;

use App\Services\V1\SendMailAndOtpServices;

class PassswordController extends Controller
{

    protected $UserMaster_model;
    protected $UserOrganisation_model;
    protected $SendMailAndOtpServices;

    public function __construct(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
        $this->SendMailAndOtpServices =new SendMailAndOtpServices();
    }
    
    function showResetForm(){

    	return view('password.email');
    }

    function sendResetLinkEmail(Request $request){

    	if(is_numeric($request->email)){
    		$this->validate($request,[
    			'email'=>'required|numeric|min:10',
    		]);
            $status = $this->SendMailAndOtpServices
                            ->sendOtpForForgetPass($request->email);

    		if(count($status)){
	   			Session::flash('status','Successful send OTP');
	   			return view('password.resetSms',['mobile'=>$request->email]);
    		}else{
    			Session::flash('status','Provide Correct Email or Phone No.');
    			return back();
    		}

    	}else{
    		$this->validate($request,[
    			'email'=>'required|email',
    		]);

            $status = $this->SendMailAndOtpServices
                            ->sendEmailForForgetPass($request->email);

    		if(count($status)){
	   			Session::flash('status','Successful send Email');
	   			return back();
    		}else{
    			Session::flash('status','Provide Correct Email or Phone No.');
    			return back();
    		}
    	}
    }

    
    function showResetEmailForm($token){
    	return view('password.reset',['token'=>$token]);
    }

    function reset(Request $request){

    	$this->validate($request,[
            'token' => 'required',
    		'email'=>'required|email',
    		'password'=>'required|min:6',
    		'password_confirmation'=>'required|same:password',
    		]);

    	$data = array('token'=>$request->token,
                      'email'=>$request->email,
                      'password'=>$request->password);

        $check_email = $this->SendMailAndOtpServices->resetPassByEmails($data);
    	if(count($check_email)){
    		Session::flash('status','Successfuly Reset Password');
    		return back();
    	}else{
    		Session::flash('status','Inavlid Email or Session Expire');
    		return back();
    	}
    }

    function resetSms(Request $request){

        $this->validate($request,[
            'mobile' => 'required|digits:10',
            'otp'=>'required|digits:6',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|same:password',
            ]);

        $data = array('mobile'=>$request->mobile,
                      'mobile_otp'=>$request->otp,
                      'password'=>$request->password
                      );

        $status = $this->SendMailAndOtpServices->resetPassByMobiles($data);
        if(count($status)){
            Session::flash('status','Successfuly Reset Password');
            return redirect()->route('password.show');
        }else{
            Session::flash('status','Inavlid OTP!! Please Try again');
            return redirect()->route('password.show');
        }
    }
}
