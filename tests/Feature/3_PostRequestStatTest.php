<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostRequestStatTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStatCreateWrongAuthKey()
    {
        $name=time().'z';
        $response = $this->post('/api/stat/create',array('authKey' => 'abc','name' => $name, 'categoryId' => $_SESSION['testCategoryId']));
        $response->assertStatus(404);
    }
    public function testStatCreate()
    {
        $name=time().'z';
        $response = $this->post('/api/stat/create',array('name' => $name, 'categoryId' => $_SESSION['testCategoryId'], 'authKey' => $_SESSION['testAuthKey']));
        $_SESSION['testStatId']=json_decode($response->content())->statId;
        $response->assertStatus(200);
    }
    public function testStatUpdateWrongAuthKey()
    {
        $name=time().'new';
        $response = $this->post('/api/stat/update',array('authKey' => 'abc','name' => $name, 'statId' => $_SESSION['testStatId']));

        $response->assertStatus(404);
    }
    public function testStatUpdate()
    {
        $name=time().'new';
        $response = $this->post('/api/stat/update',array('name' => $name, 'statId' => $_SESSION['testStatId'], 'authKey' => $_SESSION['testAuthKey']));

        $response->assertStatus(200);
    }

}
