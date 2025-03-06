<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and generate token for authentication
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_can_list_campaigns()
    {
        // Create some test campaigns
        Campaign::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/campaigns');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'start_date',
                        'end_date',
                        'budget',
                    ]
                ],
                'current_page',
                'per_page',
                'total'
            ]);
    }

    public function test_can_create_campaign()
    {
        $campaignData = [
            'name' => 'Summer Campaign 2024',
            'description' => 'Our biggest summer campaign',
            'start_date' => '2024-06-01',
            'end_date' => '2024-08-31',
            'budget' => 50000.00
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/campaigns', $campaignData);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Summer Campaign 2024'
            ]);

        $this->assertDatabaseHas('campaigns', [
            'name' => 'Summer Campaign 2024'
        ]);
    }

    public function test_cannot_create_campaign_with_invalid_data()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/campaigns', [
            'name' => '', // Empty name
            'description' => '', // Empty description
            'start_date' => 'not-a-date', // Invalid date
            'end_date' => '', // Missing end_date
            'budget' => 'not-a-number' // Invalid number
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'description',
                'start_date',
                'end_date',
                'budget'
            ]);

        // Test invalid date format
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/campaigns', [
            'name' => 'Test Campaign',
            'description' => 'Test Description',
            'start_date' => '2024-01-01',
            'end_date' => 'not-a-date', // Invalid date format
            'budget' => 1000
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);

        // Test end_date before start_date
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/campaigns', [
            'name' => 'Test Campaign',
            'description' => 'Test Description',
            'start_date' => '2024-01-01',
            'end_date' => '2023-12-31', // Date before start_date
            'budget' => 1000
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    public function test_cannot_create_campaign_with_end_date_before_start_date()
    {
        $campaignData = [
            'name' => 'Invalid Date Campaign',
            'description' => 'Test campaign',
            'start_date' => '2024-08-01',
            'end_date' => '2024-07-01', // End date before start date
            'budget' => 50000.00
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/campaigns', $campaignData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    public function test_list_campaigns_is_paginated()
    {
        Campaign::factory()->count(25)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/campaigns');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data',
                'per_page',
                'total'
            ]);

        // Assert that we're getting the default number of items per page
        $this->assertEquals(10, count($response->json('data')));

        // Test custom pagination
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/campaigns?per_page=15');

        $response->assertStatus(200);
        $this->assertEquals(15, count($response->json('data')));
    }

    public function test_campaign_dates_are_properly_formatted()
    {
        $campaignData = [
            'name' => 'Date Format Test Campaign',
            'description' => 'Testing date formats',
            'start_date' => '2024-06-01',
            'end_date' => '2024-08-31',
            'budget' => 50000.00
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/campaigns', $campaignData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'start_date',
                'end_date'
            ]);

        // Verify the dates are in ISO format
        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{6}Z$/',
            $response->json('start_date')
        );
    }

    public function test_cannot_create_campaign_with_negative_budget()
    {
        $campaignData = [
            'name' => 'Negative Budget Campaign',
            'description' => 'Test campaign',
            'start_date' => '2024-08-01',
            'end_date' => '2024-09-01',
            'budget' => -1000.00 // Negative budget
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/campaigns', $campaignData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['budget']);
    }
}
