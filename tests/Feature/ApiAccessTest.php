<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Guru;

class ApiAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_rejects_requests_without_token(): void
    {
        $response = $this->getJson('/api/gurus');
        $response->assertStatus(401)
                 ->assertJson(['error' => 'Unauthorized. Invalid API Key.']);
    }

    public function test_api_rejects_requests_with_invalid_token(): void
    {
        $response = $this->withHeader('X-API-KEY', 'invalid-token-123')
                         ->getJson('/api/gurus');
        
        $response->assertStatus(401)
                 ->assertJson(['error' => 'Unauthorized. Invalid API Key.']);
    }

    public function test_api_accepts_requests_with_valid_token(): void
    {
        Guru::factory()->create();

        $validToken = env('API_ACCESS_TOKEN');
        $response = $this->withHeader('X-API-KEY', $validToken)
                         ->getJson('/api/gurus');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data', 'current_page', 'last_page' // paginate returns this structure
        ]);
    }
}
