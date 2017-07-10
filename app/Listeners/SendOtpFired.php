<?php

namespace App\Listeners;

use App\Events\SendOtp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Services\V1\MobileOtpServices;

class SendOtpFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    protected $MobileOtpServices;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendOtp  $event
     * @return void
     */
    public function handle(SendOtp $event)
    {
        $this->MobileOtpServices=new MobileOtpServices();
        $sms_data = array(
                'SMSDetail'=>array(
                            'mobile'=>$event->user_data['mobile'],
                            'message'=>$event->user_data['message']
                    )
            );
        $this->MobileOtpServices->sendSms($sms_data);
    }
}
