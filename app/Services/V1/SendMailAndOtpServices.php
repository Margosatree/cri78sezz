<?php 

namespace App\Services\V1;

use Illuminate\Support\Str;
use App\Model\ResetVerify_model;
use App\Services\V1\SendOtpServices;
use Illuminate\Support\Facades\Mail;

class SendMailAndOtpServices{

    /**
     * reset_verif model instance.
     *
     * @var \App\Model\BaseModel\reset_verif
     */
    protected $ResetVerify_model;

	public function __construct(){
		$this->ResetVerify_model = new ResetVerify_model();
	}

    /**
     * During ForgetPassword it detect whether request is mobile no. or Email
     *
     * @param  $data
     * @return 
     */
    public function forgetPassword($data){

        if(!is_numeric($data)){
            return $this->sendEmailForForgetPass($data);
        }else{
            return $this->sendOtpForForgetPass($data);            
        }
    }

     /**
     * For ForgetPassword it use for sending Reset Password Link via Email
     *
     * @param  $email
     * @return 
     */
	public function sendEmailForForgetPass($email){
        //genrateToken --done
        $forgetpass_token = $this->generateToken();

        //event is fire with token --remaining

        //save Token in Reset_Verify Table with Flag=1 --done
        return $this->saveToken($email,$forgetpass_token);
	}

    /**
     * For ForgetPassword it use for Storing Token in Reset_Verif Table
     *  Here Flag 1 means its comes for reset Password not for verify
     * @param  $token and $flag
     * @return 
     */
	public function saveToken($email,$forgetpass_token){
        //--done
        $insert_data = array();
        $check_data =['email'=>$email,'is_password_reset'=>1];
        $update_data =array('token'=>$forgetpass_token);
        $check_by_email = $this->ResetVerify_model->getValueByEmailOrMobile($check_data);
        if($check_by_email){
            return $this->ResetVerify_model->updateByEmailOrMobile($check_data,$update_data);
        }
        $insert_data = array_merge($check_data,$update_data);
        return $this->ResetVerify_model->insertData($insert_data);
	}

    /**
     * For ForgetPassword it use for sending Otp for Reset Password
     *
     * @param  $mobile_no
     * @return 
     */
    public function sendOtpForForgetPass($mobile_no){
        //generate Otp --done
        $forgetpass_otp = $this->generateOtp();

        //Fire Event  --remaing

        //Store Otp in reset_Verify table with flag=1;
        return $this->saveOtp($mobile_no,$forgetpass_otp);
    }

     /**
     * For ForgetPassword it use for storing Otp for Reset Password
     *
     * @param  $mobile_no
     * @return 
     */
    public function saveOtp($mobile_no,$forgetpass_otp){

        //save otp in reset_verify table with flag=1; --done
        $insert_data = array();
        $check_data =['mobile'=>$mobile_no,'is_password_reset'=>1];
        $update_data =array('mobile_otp'=>$forgetpass_otp);
        $check_by_email = $this->ResetVerify_model->getValueByEmailOrMobile($check_data);
        if($check_by_email){
            return $this->ResetVerify_model->updateByEmailOrMobile($check_data,$update_data);
        }
        $insert_data = array_merge($check_data,$update_data);
        return $this->ResetVerify_model->insertData($insert_data);
    }


    /**
     * For VerifyUser it use for Sending and Storing Email and otp
     *
     * @param  $email and $mobile
     * @return array
     */

    public function sendVerifyNotify($email,$mobile){

        //genrate Otp for Email --done
        $verify_email_otp = $this->generateOtp();

        //generate Token For Email --done
        $forgetpass_token = $this->generateToken();

        //genrate Otp for Mobile
        $verify_mobile_otp = $this->generateOtp();

        $email_mobile_data = array(
                                     ''=>''
                                    ,''=>''
                                );

        return $this->saveVerifyEmailMobileData();

        // $return_data = array();
        // $email_data = $this->sendEmailForVerify($email);
        // $mobile_data = $this->sendMobileOtpForVerify($email,$mobile);
        // $return_data =['email_data'=>$email_data,'mobile_data'=>$mobile_data];
        // return $return_data;
    }


    /**
     * For VerifyUser it use for Sending and Storing Email otp ,Token and Mobile Otp
     *
     * @param  $email 
     * @return array
     */


    public function saveVerifyEmailMobileData($email_mobile_data){

        $insert_data = array();
        $check_data =array(
                             'mobile'=>$mobile_no
                            ,'is_password_reset'=>0
                        );
        
        $update_data =array('mobile_otp'=>$forgetpass_otp);
        $check_by_email = $this->ResetVerify_model->getValueByEmailOrMobile($check_data);
        if($check_by_email){
            return $this->ResetVerify_model->updateByEmailOrMobile($check_data,$update_data);
        }
        $insert_data = array_merge($check_data,$update_data);
        return $this->ResetVerify_model->insertData($insert_data);
    }

    /**
     * For VerifyUser it use for Sending and Storing Mobile otp 
     *
     * @param  $mobile 
     * @return array
     */

    public function sendMobileOtpForVerify($mobile){
        //genrate Otp for Mobile
        $verify_mobile_otp = $this->generateOtp();

        //Fire Event for mobile Otp
        //Store Email data with flag=0;
    }


    public function saveVerifyEmailOtp(){

    }
	
    /*
     * @generateToken - Generate Token For Email
     * @return Encrypted unique string as Token
     */

    protected function generateToken(){
        return hash_hmac('sha256',str::random(40),config('app.key'));
    }

    /*
     * @generateToken - Generate Otp For Verify and ForgetPassword
     * @return unique random number for sending otp
     */

    public function generateOtp(){
        $randomOtp = mt_rand(100000,999999);
        return $randomOtp;
    }



    //-----------------The End -----------------------//

	/**
     * Generate and save a verification token for the given user.
     *
     * @param  \App\Model\UserMaster_model  $user and 
     *	$flag is used for checking whether its comes for reset password or verify
     * @return bool
     */

	public function generate($user,$flag)
    {
        if (empty($user->email)) {
            //throw new UserHasNoEmailException();
        }
        return $this->saveToken($user, $this->generateToken(),$flag);
    }

	


	/**
     * Update and save the model instance with the verification token.
     *
     * @param  \App\Model\UserMaster_model  $user
     * @param  string  $token
     * @param  tinyint  $flag
     * @return bool
     *
     * @throws \App\Exceptions\ModelNotCompliantException
     */
//    protected function saveToken($user, $token, $flag)
//    {
//    	$this->send_otp_services = new SendOtpServices();
//        $random_num = $this->send_otp_services->generateOtp();
//
//        $store_data = ['email'=>$user->email,
//                        'token'=>$token,
//                        'email_otp'=>$random_num,
//                        'is_password_reset'=>$flag];
//                        
//        $this->storeEmail($store_data);
//        return $store_data;
//    }

    protected function storeEmail($data){
    	$check_user =['email'=>$data['email'],
    				'is_password_reset'=>$data['is_password_reset']];
    	$check_dup_email = $this->ResetVerify_model
    								->getValueByEmailOrMobile($check_user);
        if(count($check_dup_email)){
            return $this->ResetVerify_model->updateByEmail($data);
        }else{
            return $this->ResetVerify_model->createData($data);
        }
    }

     /**
     * Send by e-mail a link containing the verification token.
     *
     * @param  \App\Model\UserMaster_model  $user
     * @param  string  $subject
     * @param  string  $from
     * @param  string  $name
     * @return void
     *
     * @throws \Jrean\UserVerification\Exceptions\ModelNotCompliantException
     */

    public function send($user,$data)
    {

        //$this->emailVerificationLink($user,$data);

        //event(new VerificationEmailSent($user));
    }


     /**
     * Prepare and send the e-mail with the verification token link.
     *
     * @param  \App\Model\UserMaster_model  $user
     * @param  string  $subject
     * @param  string  $from
     * @param  string  $name
     * @return mixed 
     */
    protected function emailVerificationLink($user,$data)
    {
        return Mail::to($user_email)
                  ->send(new VerifyUser($random_num,$token_data));
    }


}

