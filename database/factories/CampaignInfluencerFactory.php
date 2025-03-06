<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Influencer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignInfluencerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::factory(),
            'influencer_id' => Influencer::factory(),
        ];
    }
}
