<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Mail;
use App\User_Master;
use App\Password_reset;
use Session;
use App\User_Organisation;
use Illuminate\Support\Facades\Log;

class PassswordController extends Controller
{
    
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
    	$token_data = str_random(32);
    	// dd($token_data);
    	if(!empty($user_email)){
    		// dd($user_email);
    		$check_email = User_Master::where('email',$user_email)->get();
    		if(count($check_email)){
    			// dd($check_email);
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

    	$check_dup_email = Password_reset::where('email',$data['email'])
    										->get();
    	if(count($check_dup_email)){
    		Password_reset::where('email', $data['email'])
          					->update(['token' => $data['token']]); 
    	}else{
    		Password_reset::create($data);
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

    	$data = [$request->token,$request->email,$request->password];
    	$check_email = Password_reset::where('email',$request->email)
    								  ->where('token',$request->token)
    								  ->get();
    	if(count($check_email)){
    		User_Organisation::where('email',$request->email)
    			->update(['password'=>bcrypt($request->password)]);
    		Password_reset::where('email',$request->email)
    					   ->delete();
    		Session::flash('status','Successfuly Reset Password');
    		return back();
    	}else{
    		Session::flash('status','Inavlid Email or Session Expire');
    		return back();
    	}
    }

    // Reset Password Email Proceess End

    function sendSms($mobile_no){

    	$check_mobile = Password_reset::where('mobile',$mobile_no)
    								   ->get();
    	if(count($check_mobile)){
    		Password_reset::where('mobile',$mobile_no)->delete();
    	}
    	$random_num = mt_rand(1000,9999);
    	while(true){
    		$check_otp = Password_reset::where('otp',$random_num)
    								   ->get();							   
	    	if(!count($check_otp)){
	    		break;
	    	}
	    	$random_num = mt_rand(1000,9999);
        }
        // dd($random_num);
    	// dd($mobile_no);

    	if(!empty($mobile_no)){
    		$check_umobile = User_Master::where('phone',$mobile_no)->get();
    		if(count($check_umobile)){
    			foreach($check_umobile as $check_um){
    				$email = $check_um->email;
    			}
    	    	$check_email = Password_reset::where('email',$email)
    								   ->get();
    			//Sms logic insert here
    			if(count($check_email)){
    				Password_reset::where('email', $email)
          					->update(['mobile' => $mobile_no,'otp'=>$random_num]);
    			}else{
    				Password_reset::create(['mobile'=>$mobile_no,'otp'=>$random_num]);
    			}
    			return 1;
    		}else{
    			return 0;
    		}
    	}
    }

    function resetSms(Request $request){
    	$data = [$request->mobile,$request->otp,$request->password];
    	$check_mobilewithOtp = Password_reset::where('mobile',$request->mobile)
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
    		Password_reset::where('mobile',$request->mobile)
    					   ->delete();
    		Session::flash('status','Successfuly Reset Password');
    		return redirect('/passwords/reset');
    	}else{
    		Session::flash('status','Inavlid OTP!! Please Try again');
    		return redirect('/passwords/reset');
    	}  
    }
}
