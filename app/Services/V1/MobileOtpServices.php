<?php 

namespace App\Services\V1;

class MobileOtpServices{

    protected $method; 
    protected $groupName;
    protected $userid;
    protected $password;
    protected $msgType;
    protected $version;
    protected $intf_url;
    protected $sms_req_url;
    protected $intf_req_url;

    public function initConf(){
        $this->method = config('sms_details.sms_data.method');
        $this->groupName = config('sms_details.sms_data.groupName');
        $this->userid = config('sms_details.sms_data.userid');
        $this->password = config('sms_details.sms_data.password');
        $this->msgType = config('sms_details.sms_data.msgType');
        $this->version = config('sms_details.sms_data.version');
        $this->intf_url = config('sms_details.sms_data.intf_url');
        $this->sms_req_url = "method=".$this->method."&groupName=".$this->groupName."&userid=".$this->userid."&password=".$this->password."&";
        $this->intf_req_url = "v=".$this->version."&groupName=".$this->groupName."&userid=".$this->userid."&password=".$this->password."&"; 
        return 1;
    }


    public function sendSms($data){
        $config_status = $this->initConf();
        if($config_status){
            $smsDetail = $data['SMSDetail'];
            if(isset($smsDetail['mobile']) && isset($smsDetail['message'])){
                if(is_numeric($smsDetail['mobile']) && !is_null($smsDetail['message'])){
                    $encode_sms_message = urlencode($smsDetail['message']);
                    $msg_request = $this->sms_req_url."msgType=TEXT&sendTo=".$smsDetail['mobile']."&message=".$encode_sms_message;
//                    echo $this->intf_url.$msg_request;die();
                    $curl_scraped_page = $this->getCurlOutput($this->intf_url.$msg_request); 
                    return  ['Mobile'=> $smsDetail['mobile'],'message'=> $smsDetail['message'], 'URL'=>$this->intf_url.$msg_request];
                }
            }
        }else{
            return  0;
        }
    }
    
    function getCurlOutput($url){
        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $curl_scraped_page = curl_exec($ch); 
        curl_close($ch); 
        $curl_scraped_page = str_replace("'","",$curl_scraped_page);
        return $curl_scraped_page;
    }
}

