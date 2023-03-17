<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostRequestCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCategoryCreateWrongAuthKey()
    {
        $name=time().'z';
        $response = $this->post('/api/category/create', array('authKey' => 'abc', 'name' => $name));
        $response->assertStatus(404);
    }
    public function testCategoryCreate()
    {
        $name=time().'z';
        $response = $this->post('/api/category/create', array('authKey' => $_SESSION['testAuthKey'], 'name' => $name));
        $_SESSION['testCategoryId']=json_decode($response->content())->categoryId;
        $response->assertStatus(200);
    }

    public function testCategoryUpdateWrongAuthKey()
    {
        $name=time().'new';
        $response = $this->post('/api/category/update', array('authKey' => 'abc',
            'categoryId'=>$_SESSION['testCategoryId'], 'name' => $name));
        $response->assertStatus(404);
    }
    public function testCategoryUpdate()
    {
        $name=time().'new';
        $response = $this->post('/api/category/update', array('authKey' => $_SESSION['testAuthKey'],
            'categoryId'=>$_SESSION['testCategoryId'], 'name' => $name));
        $response->assertStatus(200);
    }
}
