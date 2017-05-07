<?php

namespace Tests\Browser;

use App\Password_reset;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class resetPassword extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    //Start Reset Password by Email
    
    public function testInvalidEmail(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/passwords/reset')
                    ->value('#email','Brijeshdubeyid.com')
                    ->press('Send Password Reset Link')
                    ->assertPathIs('/passwords/reset')
                    ->assertSee('The email must be a valid email address.');
        });
    }

    public function testMissMatchEmail(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/passwords/reset')
                    ->value('#email','Brijeshdubey144@gmail.com.com')
                    ->press('Send Password Reset Link')
                    ->assertPathIs('/passwords/reset')
                    ->assertSee('Provide Correct Email or Phone No.');
        });
    }

    public function testCorrectResetURL()
    {
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/passwords/reset')
                    ->value('#email','Brijeshdubeyid@gmail.com')
                    ->press('Send Password Reset Link')
                    ->assertPathIs('/passwords/reset')
                    ->assertSee('Successful send Email');
                    
            $getToken = Password_reset::where('email','Brijeshdubeyid@gmail.com')                   ->first();
            $dataToken = $getToken->token;
            $email = $getToken->email;

            $browser->visit('/passwords/reset/'.$dataToken)
                    ->type('email',$email)
                    ->value('#password','Brijesh@new')
                    ->value('#password-confirm','Brijesh@new')
                    ->press('Reset Password')
                    ->assertPathIs('/passwords/reset/'.$dataToken)
                    ->assertSee('Successfuly Reset Password');        
        });
    }

    //End Reset Password By Email

    //Start Reset Password By Mobile No;

    public function testCorrectResetURL()
    {
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Forgot Your Password?')
                    ->assertPathIs('/passwords/reset')
                    ->value('#email','9594116610')
                    ->press('Send Password Reset Link')
                    ->assertPathIs('/passwords/email')
                    ->assertSee('Successful send OTP');
                    
            $getToken = Password_reset::where('phone','9594116610')                   ->first();
            $mobile_otp = $getToken->otp;

            $browser->value('#otp',$mobile_otp)
                    ->value('#password','Brijesh@new')
                    ->value('#password-confirm','Brijesh@new')
                    ->press('Reset Password')
                    ->assertPathIs('/passwords/reset')
                    ->assertSee('Successfuly Reset Password');        
        });
    }

    //End Reset Password By Mobile No;


}
