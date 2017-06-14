<?php

namespace Tests\Browser;

// use App\User_Master;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    // use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function testEmailBlankField(){
        $this->browse(function (Browser $browser){
            $browser->visit('/login')
                    ->type('email', '')
                    ->type('password', 'abc')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }

    public function testPasswordBlankField(){
        $this->browse(function (Browser $browser){
            $browser->visit('/login')
                    ->type('email', 'Brijeshdubey144@gmail.com')
                    ->type('password', '')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }

    public function testWrongEmail(){
        $this->browse(function (Browser $browser){
            $browser->visit('/login')
                    ->type('email', 'Brijeshdubey1445@gmail.com')
                    ->type('password', 'Brijesh@123')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }

    public function testWrongPassword(){
        $this->browse(function (Browser $browser){
            $browser->visit('/login')
                    ->type('email', 'Brijeshdubey144@gmail.com')
                    ->type('password', 'Brijesh')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }

    public function testLoginURL()
    {
        $this->browse(function (Browser $browser){
            $browser->visit('/login')
                    ->type('email', 'brijeshdubey144@gmail.com')
                    ->type('password', 'Brijesh@123')
                    ->press('Login')
                    ->assertPathIs('/home');
        });
    }
}
