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

    // public function testBlankFields(){
    // 	$this->get('/login')
    // 		->press('Login')
    // 		->seePagesIs('/login');
    // }
}
