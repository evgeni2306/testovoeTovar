<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetRequestTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProductViewIntId()
    {
        $response = $this->get('/api/product='.$_SESSION['testProductId']);

        $response->assertStatus(200);
    }
    public function testProductViewZerrowId()
    {
        $response = $this->get('/api/product=0');

        $response->assertStatus(404);
    }

    public function testProductViewLetterId()
    {
        $response = $this->get('/api/product=x');

        $response->assertStatus(404);
    }

    public function testProductListByCategoryId()
    {
        $response = $this->get('/api/product/category='.$_SESSION['testCategoryId']);

        $response->assertStatus(200);
    }
    public function testProductListByCategoryZerrowId()
    {
        $response = $this->get('/api/product/category=0');

        $response->assertStatus(404);
    }
    public function testProductListByCategoryLetterId()
    {
        $response = $this->get('/api/product/category=p');

        $response->assertStatus(404);
    }

    public function testCategoryViewIntId()
    {
        $response = $this->get('/api/category='.$_SESSION['testCategoryId']);

        $response->assertStatus(200);
    }
    public function testCategoryViewZerrowId()
    {
        $response = $this->get('/api/category=0');

        $response->assertStatus(404);
    }
    public function testCategoryViewLetterId()
    {
        $response = $this->get('/api/category=x');

        $response->assertStatus(404);
    }
}
