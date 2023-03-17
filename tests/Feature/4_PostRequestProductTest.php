<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostRequestProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testProductCreateWrongAuthKey()
    {
        $response = $this->post('/api/product/create', array('authKey' => 'abc', 'name' => 'name', 'price' => '55',
            'amount' => '10', 'description' => 'description', 'categories' => [1]));

        $response->assertStatus(404);
    }

    public function testProductCreate()
    {
        $response = $this->post('/api/product/create', array('authKey' => $_SESSION['testAuthKey'],
            'name' => 'name', 'price' => '10',
            'amount' => '10', 'description' => 'description', 'categories' => [1]));
        $_SESSION['testProductId'] = json_decode($response->content())->productId;
        $response->assertStatus(200);
    }


    public function testProductUpdateWrongAuthKey()
    {
        $response = $this->post('/api/product/update', array('authKey' => 'abc', 'name' => 'new', 'price' => '24',
            'amount' => '24', 'description' => 'new', 'productId' => 1));

        $response->assertStatus(404);
    }

    public function testProductUpdate()
    {
        $name = time() . 'new';
        $response = $this->post('/api/product/update', array('authKey' => $_SESSION['testAuthKey'], 'name' => $name, 'price' => '24',
            'amount' => '24', 'description' => 'new', 'productId' => $_SESSION['testProductId']));

        $response->assertStatus(200);
    }

    public function testProductCategoryAddWrongAuthKey()
    {
        $response = $this->post('/api/product/category/add', array('authKey' => 'abc', 'productId' => 1, 'categoryId' => 1));

        $response->assertStatus(404);
    }

    public function testProductCategoryAdd()
    {
        $response = $this->post('/api/product/category/add', array('authKey' => $_SESSION['testAuthKey'],
            'categoryId' => $_SESSION['testCategoryId'], 'productId' => $_SESSION['testProductId']));

        $response->assertStatus(200);
    }


    public function testProductStatUpdateWrongAuthKey()
    {
        $response = $this->post('/api/product/stat/update', array('authKey' => 'abc', 'productId' => 1, 'statId' => 1, 'value' => 'new'));

        $response->assertStatus(404);
    }

    public function testProductStatUpdate()
    {
        $value = time() . 'new';
        $response = $this->post('/api/product/stat/update', array('authKey' => $_SESSION['testAuthKey'],
            'statId' => $_SESSION['testStatId'], 'productId' => $_SESSION['testProductId'], 'value' => $value));

        $response->assertStatus(200);
    }



}
