<?php

namespace Tests\Browser;

use DB;
use App\verify_user;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends DuskTestCase
{
    use DatabaseTransactions;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    // public function testRegistrationForOrg()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/login')
    //                 ->clickLink('Register')
    //                 ->assertSee('Register')
    //                 ->value('#username','Brijesh144')
    //                 ->value('#phone','9594116619')
    //                 ->value('#email','brijeshdubey144@gmail.com')
    //                 ->value('#password','Brijesh@144')
    //                 ->value('#password-confirm','Brijesh@144')
    //                 ->press('Register');
    //         $getToken = verify_user::where('email','brijeshdubey144@gmail.com')                   ->first();
    //         $dataToken = $getToken->token;


    //         //Verify Email and Mobile OTP
    //         $email_otp =  $getToken->email_otp;
    //         $mobile_otp =  $getToken->mobile_otp;
    //         $browser->assertPathIs('/verify/'.$dataToken)
    //                 ->value('#verify_email',$email_otp)
    //                 ->value('#verify_phone',$mobile_otp)
    //                 ->press('Verify');


    //         //Add Personal Detail
    //         $browser->assertPathIs('/userBio/createInfo')
    //                 ->value('#first_name','Brijesh')
    //                 ->value('#middle_name','Achchhelal')
    //                 ->value('#last_name','Dubey')
    //                 ->keys('#date_of_birth', '26021998')
    //                 ->radio('gender','male')
    //                 ->radio('physically_challenged','no')
    //                 ->press('Submit');

    //         //Add Bio
    //         $browser->assertPathIs('/userBio/create')
    //                 ->value('#address','Abc')
    //                 ->value('#pin','400066')
    //                 ->value('#suburb','mumbai')
    //                 ->value('#city','mumbai')
    //                 ->value('#state','maharashtra')
    //                 ->value('#country','india')
    //                 ->press('Submit');

    //         //Add Org
    //         $browser->assertPathIs('/orgcriProfile/create')
    //                 ->value('#name','IT')
    //                 ->value('#business_type','Cool')
    //                 ->value('#business_operation','Must')
    //                 ->value('#address','Borivali')
    //                 ->value('#landmark','National Park')
    //                 ->value('#pin','400066')
    //                 ->value('#city','mumbai')
    //                 ->value('#state','state')
    //                 ->value('#country','india')
    //                 ->value('#spoc','dont know')
    //                 ->press('Add')
    //                 ->assertPathIs('/home');
    //     });
    // }

    //Registration For Cricket Profile
    public function testRegistrationForCProfile()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->clickLink('Register')
                    ->assertSee('Register')
                    ->value('#username','Brijesh143')
                    ->value('#phone','9594146619')
                    ->value('#email','brijeshdubey14@gmail.com')
                    ->value('#password','Brijesh@144')
                    ->value('#password-confirm','Brijesh@144')
                    ->press('Register');
            $getToken = verify_user::where('email','brijeshdubey14@gmail.com')                   ->first();
            $dataToken = $getToken->token;


            //Verify Email and Mobile OTP
            $email_otp =  $getToken->email_otp;
            $mobile_otp =  $getToken->mobile_otp;
            $browser->assertPathIs('/verify/'.$dataToken)
                    ->value('#verify_email',$email_otp)
                    ->value('#verify_phone',$mobile_otp)
                    ->press('Verify');


            //Add Personal Detail
            $browser->assertPathIs('/userBio/createInfo')
                    ->value('#first_name','Brijesh')
                    ->value('#middle_name','Achchhelal')
                    ->value('#last_name','Dubey')
                    ->keys('#date_of_birth', '26021998')
                    ->radio('gender','male')
                    ->radio('physically_challenged','no')
                    ->press('Submit');

            //Add Bio
            $browser->assertPathIs('/userBio/create')
                    ->value('#address','Abc')
                    ->value('#pin','400066')
                    ->value('#suburb','mumbai')
                    ->value('#city','mumbai')
                    ->value('#state','maharashtra')
                    ->value('#country','india')
                    ->press('Submit');

            //Add Org
            $browser->assertPathIs('/orgcriProfile/create')
                    ->select('your_role')
                    ->radio('batsman_style','Lefthand')
                    ->value('#batsman_order','3')
                    ->radio('bowler_style','Lefthand')
                    ->value('#player_type','National Park')
                    ->value('#description','400066')
                    ->attach('image', __DIR__.'/photos/Brijesh_dp.png')
                    ->press('Submit')
                    ->assertPathIs('/userAchieve/create')
                    ->press('Skip')
                    ->assertPathIs('/home');
        });
    }
}
