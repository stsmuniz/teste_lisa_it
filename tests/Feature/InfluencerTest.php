<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Influencer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InfluencerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user
        $this->user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($this->user); // This will set the user for authentication
    }

    public function test_can_list_influencers()
    {
        // Create some test influencers
        Influencer::factory()->count(3)->create();

        $response = $this->getJson('/api/influencers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'instagram_username',
                        'followers_qty',
                        'category',
                    ]
                ],
                'current_page',
                'per_page',
                'total'
            ]);
    }

    public function test_can_create_influencer()
    {
        $data = [
            'name' => 'Test Influencer',
            'instagram_username' => 'test_influencer',
            'followers_qty' => 1000,
            'category' => 'lifestyle',
        ];

        $response = $this->postJson('/api/influencers', $data);

        $response->assertCreated();
        $this->assertDatabaseHas('influencers', $data);
    }

    public function test_cannot_create_influencer_without_required_fields()
    {
        $response = $this->postJson('/api/influencers', []);

        $response->assertUnprocessable();
    }

    public function test_cannot_create_influencer_with_duplicate_instagram_username()
    {
        // Create an influencer first
        Influencer::factory()->create([
            'instagram_username' => 'johndoe'
        ]);

        $influencerData = [
            'name' => 'John Doe',
            'instagram_username' => 'johndoe', // Same username
            'followers_qty' => 100000,
            'category' => 'Lifestyle'
        ];

        $response = $this->postJson('/api/influencers', $influencerData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['instagram_username']);
    }

    public function test_cannot_create_influencer_with_invalid_data()
    {
        $response = $this->postJson('/api/influencers', [
            'name' => '', // Empty name
            'instagram_username' => '', // Empty username
            'followers_qty' => 'not a number', // Invalid number
            'category' => '' // Empty category
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'instagram_username',
                'followers_qty',
                'category'
            ]);
    }

    public function test_list_influencers_is_paginated()
    {
        // Create more influencers than the default per page
        Influencer::factory()->count(25)->create();

        // Test default pagination (10 items)
        $response = $this->getJson('/api/influencers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);

        // Assert that we're getting the default number of items per page
        $this->assertEquals(10, count($response->json('data')));

        // Test custom pagination
        $response = $this->getJson('/api/influencers?per_page=15');

        $response->assertStatus(200);
        $this->assertEquals(15, count($response->json('data')));
    }
}
