<?php

namespace app\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /*
     * Get user Email 
     *
     * @var user_email
     * @decription use for encode email in url 
    */

    protected $user_token;

    /*
     * Get user Email 
     *
     * @var user_email
     * @decription use for encode email in url 
    */

    protected $user_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($user_email,$user_token)
    {
        $this->user_email = $user_email;
        $this->user_token = $user_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('email.ForgetPassword')
                    ->with(['token' => $this->user_token
                           ,'email' => $this->user_email]);
    }
}
