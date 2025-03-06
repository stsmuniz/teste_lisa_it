<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Influencer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignInfluencerTest extends TestCase
{
    use RefreshDatabase;

    protected $campaign;
    protected $influencer;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user
        $this->user = User::factory()->create();

        // Generate a Bearer token for the user
        $this->actingAs($this->user); // This will set the user for authentication

        // Create a campaign and an influencer
        $this->campaign = Campaign::factory()->create();
        $this->influencer = Influencer::factory()->create();
    }

    public function test_can_create_campaign_influencer_relationship()
    {
        $response = $this->postJson("/api/campaigns/{$this->campaign->id}/influencers", [
            'influencer_id' => $this->influencer->id
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('campaign_influencer', [
            'campaign_id' => $this->campaign->id,
            'influencer_id' => $this->influencer->id
        ]);
    }

    public function test_cannot_create_relationship_with_nonexistent_influencer()
    {
        $response = $this->postJson("/api/campaigns/{$this->campaign->id}/influencers", [
            'influencer_id' => 999
        ]);

        $response->assertUnprocessable();
    }

    public function test_cannot_attach_same_influencer_twice()
    {
        // First attach the influencer
        $response = $this->postJson("/api/campaigns/{$this->campaign->id}/influencers", [
            'influencer_id' => $this->influencer->id
        ]);

        $response->assertCreated();

        // Attempt to attach the same influencer again
        $response = $this->postJson("/api/campaigns/{$this->campaign->id}/influencers", [
            'influencer_id' => $this->influencer->id
        ]);

        $response->assertUnprocessable();
    }
}
