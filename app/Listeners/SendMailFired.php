<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\VerifyUser;
use App\Mail\ForgetPassword;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        if(isset($event->user_data['random_num'])){
            //For Verify
            Mail::to($event->user_data['user_email'])
                  ->send(new VerifyUser($event->user_data['random_num']
                                        ,$event->user_data['token_data']));
        }else{
            //For Forget
            Mail::to($event->user_data['user_email'])
                    ->send(new ForgetPassword($event->user_data['user_email']
                                                ,$event->user_data['token_data']));
        }
    }
}
