<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegistration()
    {
        session_start();
        $_SESSION['testLogin'] = time().'z';

        $response = $this->post('/api/registration', array('name' => 'Petr', 'surname' => 'Petrov', 'login' => $_SESSION['testLogin'], 'password' => '123'));
        $_SESSION['testAuthKey']=json_decode($response->content())->authKey;
        $response->assertStatus(200);
    }
    public function testAuthorization()
    {
        $login = time();
        $response = $this->post('/api/login', array( 'login' => $_SESSION['testLogin'], 'password' => '123'));
        $response->assertStatus(200);
    }
}
