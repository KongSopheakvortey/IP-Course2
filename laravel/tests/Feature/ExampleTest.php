<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\Http;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_http_returns_a_successful_response(): void
    {

        $response = Http::get('http://your-link.com');

        $response->assertStatus(200);
    }
}
