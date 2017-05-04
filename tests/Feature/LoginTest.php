<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testURL()
    {
        $response = $this->call('GET','/login');
        $this->assertEquals(200,$response->status());
    }

    public function testBlankFields(){
    	$response =  $this->post('/login',['email'=>'',
    											  'password'=>'']);
    	$response->assertStatus(302);
    	$response->assertRedirect('/');
    }

    public function testWrongValues(){
    	$response =  $this->post('/login',['email'=>'Brijeshdubey@gmail.com',
    											  'password'=>'Brijesh']);
    	$response->assertStatus(302);
    	$response->assertRedirect('/');
    }

    public function testCorrectData(){
    	$response =  $this->post('/login',['email'=>'brijeshdubeyid@gmail.com',
    											  'password'=>'Brijesh@123']);
    	// dd($response);
    	$response->assertStatus(302);
    	$response->assertRedirect('/home');
    }
}
