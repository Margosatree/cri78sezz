<?php

namespace Tests\Browser;

use App\User_Organisation;
use Illuminate\Support\Facades\Crypt;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChangePasswordTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $email = 'brijeshdubey144@gmail.com';
        $user = User_Organisation::where('email',$email)->get()->first();
        $user_old_pass = 'Brijesh@123';
        $this->browse(function (Browser $browser) use($email,$user_old_pass) {
            $user_new_pass = 'Brijesh@45';
            $browser->visit('/login')
                    ->type('email', $email)
                    ->type('password', $user_old_pass)
                    ->press('Login')
                    ->assertPathIs('/home')
                    ->clickLink($email)
                    ->clickLink('Change Pass')
                    ->assertPathIs('/pass/request')
                    ->value('#current_password',$user_old_pass)
                    ->value('#password',$user_new_pass)
                    ->value('#password-confirm',$user_new_pass)
                    ->press('Change Password')
                    ->assertPathIs('/home')
                    ->assertSee('Password Save Sucessfuly');
        });
    }
}
