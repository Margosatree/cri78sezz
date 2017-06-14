<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Mail;

use Session;
use App\Model\UserMaster_model;
use App\Model\PasswordReset_model;
use App\Model\UserOrganisation_model;
use Illuminate\Support\Facades\Log;

class PassswordController extends Controller
{

    protected $UserMaster_model;
    protected $PasswordReset_model;
    protected $UserOrganisation_model;

    public function __construct(){
        $this->UserMaster_model = new UserMaster_model();
        $this->PasswordReset_model = new PasswordReset_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
    }
    
    function showResetForm(){

    	return view('password.email');
    }

    function sendResetLinkEmail(Request $request){

    	// dd($request->email);
    	if(is_numeric($request->email)){
    		$this->validate($request,[
    			'email'=>'required|numeric|min:10',
    		]);
    		// dd('number');
    		$status = $this->sendSms($request->email);

    		if($status == 1){
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
    		// dd('email');
    		$status = $this->sendEmail($request->email);

    		if($status == 1){
	   			Session::flash('status','Successful send Email');
	   			return back();
    		}else{
    			Session::flash('status','Provide Correct Email or Phone No.');
    			return back();
    		}
    		// return redirect('password.email');
    	}
    }

    // Email Proceess Start

    function sendEmail($user_email){

    	// dd($user_email);
    	$token_data = str_random('alnum',32);
    	// dd($token_data);
    	if(!empty($user_email)){
    		// dd($user_email);

            $check_email = $this->UserMaster_model->emailExists($user_email);
    		if($check_email){
	   			Mail::to($user_email)
	   				->send(new ForgetPassword($user_email,$token_data));

	   			$store_data = ['email'=>$user_email,'token'=>$token_data];
	   			$this->storeEmail($store_data);
                Log::info('Showing user Email for user: '.$user_email);
	   			return 1;
    		}else{
    			return 0;
    		}
    	}
        
    }
    function storeEmail($data){

    $check_dup_email = $this->PasswordReset_model->checkByEmailOrPhone($data['email']);
    	if(count($check_dup_email)){
            $this->PasswordReset_model->updateTokenByEmail($data);
    	}else{
    		$this->PasswordReset_model->insert($data);
    	}
    }


    function showResetEmailForm($token){
    	return view('password.reset',['token'=>$token]);
    }

    function reset(Request $request){

    	$this->validate($request,[
    		'email'=>'required|email',
    		'password'=>'required|min:6',
    		'password_confirmation'=>'required|same:password',
    		]);

    	$data = array('token'=>$request->token,
                      'email'=>$request->email,
                      'password'=>$request->password);

        $check_email = $this->PasswordReset_model->checkByEmailAndToken($data);
    	if(count($check_email)){
            $this->UserOrganisation_model->updatePassByEmail($data);
            $this->PasswordReset_model->deleteByEmailOrMobile($request->email);
    		Session::flash('status','Successfuly Reset Password');
    		return back();
    	}else{
    		Session::flash('status','Inavlid Email or Session Expire');
    		return back();
    	}
    }

    // Reset Password Email Proceess End

    function sendSms($mobile_no){

    	$check_mobile = $this->PasswordReset_model->checkByEmailOrPhone($mobile_no);
    	if(count($check_mobile)){
            $this->PasswordReset_model->deleteByEmailOrMobile($mobile_no);
    	}
    	$random_num = mt_rand(100000,999999);
    	while(true){
    		$check_otp = $this->PasswordReset_model->checkByEmailOrPhone($random_num);	   
	    	if(!count($check_otp)){
	    		break;
	    	}
	    	$random_num = mt_rand(100000,999999);
        }
        // dd($random_num);
    	// dd($mobile_no);

    	if(!empty($mobile_no)){
            $check_umobile = $this->UserMaster_model->getAllValueByMobile($mobile_no);
    		if(count($check_umobile)){
    			foreach($check_umobile as $check_um){
    				$email = $check_um->email;
    			}
                $check_email =$this->PasswordReset_model->checkByEmailOrPhone($email);
    			//Sms logic insert here
    			if(count($check_email)){
                    $data = ['email'=>$email,'phone' => $mobile_no,'otp'=>$random_num];
                    $this->PasswordReset_model->updatePhoneOtpByEmail($data);
    			}else{
                    $data = ['phone'=>$mobile_no,'otp'=>$random_num];
    				$this->PasswordReset_model->insert($data);
    			}
    			return 1;
    		}else{
    			return 0;
    		}
    	}
    }

    function resetSms(Request $request){
    	$data = [$request->mobile,$request->otp,$request->password];
    	$check_mobilewithOtp = Password_reset::where('phone',$request->mobile)
    										->where('otp',$request->otp)
    								  ->get();
    	// dd(count($check_mobilewithOtp));
    	if(count($check_mobilewithOtp)){

    		$user_mobile = User_Master::where('phone',$request->mobile)->get();
            foreach($user_mobile as $mobile){
                $email_user = $mobile->email;
            }
            User_Organisation::where('email',$email_user)
    			->update(['password'=>bcrypt($request->password)]);
    		Password_reset::where('phone',$request->mobile)
    					   ->delete();
    		Session::flash('status','Successfuly Reset Password');
    		return redirect('/passwords/reset');
    	}else{
    		Session::flash('status','Inavlid OTP!! Please Try again');
    		return redirect('/passwords/reset');
    	}  
    }
}
