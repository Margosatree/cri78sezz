<?php

namespace App\Listeners;

use App\Events\SendOtp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOtpFired
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
     * @param  SendOtp  $event
     * @return void
     */
    public function handle(SendOtp $event)
    {
        //
    }
}
