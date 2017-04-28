<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user_token;

    /*
     * Get user Email 
     *
     * @var user_email
     * @decription use for encode email in url 
    */

    protected $email_otp;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($email_otp,$user_token)
    {
        $this->email_otp = $email_otp;
        $this->user_token = $user_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('email.VerifyUser')
                    ->with(['token' => $this->user_token
                           ,'email_otp' => $this->email_otp]);
    }
}
