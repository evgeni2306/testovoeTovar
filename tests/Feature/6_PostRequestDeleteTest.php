<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostRequestDeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProductCategoryDeleteWrongAuthKey()
    {
        $response = $this->post('/api/product/category/delete', array('authKey' => 'abc', 'productId' => 1, 'categoryId' => 1));

        $response->assertStatus(404);
    }
    public function testProductCategoryDelete()
    {
        $response = $this->post('/api/product/category/delete', array('authKey' => $_SESSION['testAuthKey'],
            'categoryId' => $_SESSION['testCategoryId'], 'productId' => $_SESSION['testProductId']));

        $response->assertStatus(200);
    }

    public function testProductDeleteWrongAuthKey()
    {
        $response = $this->post('/api/product/delete', array('authKey' => 'abc', 'productId' => $_SESSION['testProductId']));

        $response->assertStatus(404);
    }

    public function testProductDelete()
    {
        $response = $this->post('/api/product/delete', array('authKey' => $_SESSION['testAuthKey'], 'productId' => $_SESSION['testProductId']));

        $response->assertStatus(200);
    }

    public function testStatDeleteWrongAuthKey()
    {
        $response = $this->post('/api/stat/delete', array('statId' => $_SESSION['testStatId'], 'authKey' => 'abc'));

        $response->assertStatus(404);
    }
    public function testStatDelete()
    {
        $response = $this->post('/api/stat/delete', array('statId' => $_SESSION['testStatId'], 'authKey' => $_SESSION['testAuthKey']));

        $response->assertStatus(200);
    }

    public function testCategoryDeleteWrongAuthKey()
    {
        $response = $this->post('/api/category/delete', array('authKey' => 'abc', 'categoryId' => $_SESSION['testCategoryId']));

        $response->assertStatus(404);
    }

    public function testCategoryDelete()
    {
        $response = $this->post('/api/category/delete', array('authKey' => $_SESSION['testAuthKey'], 'categoryId' => $_SESSION['testCategoryId']));

        $response->assertStatus(200);
        session_destroy();
    }

}
