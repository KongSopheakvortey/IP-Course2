<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\Http;

use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test ID: Category-001
     * Description: Check if we can acceess the get all categories api
     * Precondition: None
     * Test Step: 1. Hit the get all categories api 
     *            2. Check if the response status is 200
     * Test Data: None
     * expected Result: The response status should be 200
     * Actual Result: The response status should be 200
     * Status: passed
     * Remark: None
     * 
     * /**
     * Test ID: Product-002
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

     */

    public function test_get_all_categories()
    {
        $response = $this->getJson('/api/categories'); 
        $response->assertStatus(200);
    }
}
