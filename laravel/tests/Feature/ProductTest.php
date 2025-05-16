<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\Http;

use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test ID: Product-001
     * Description: Check if we can acceess the get all products api
     * Precondition: None
     * Test Step: 1. Hit the get all products api 
     *            2. Check if the response status is 200
     * Test Data: None
     * expected Result: The response status should be 200
     * Actual Result: The response status should be 200
     * Status: passed
     * Remark: None
     */

    public function test_get_all_products()
    {
        $response = $this->getJson('/api/products'); 
        $response->assertStatus(200);
    }
}
