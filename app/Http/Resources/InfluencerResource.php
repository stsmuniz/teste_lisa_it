<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'instagram_username' => $this->instagram_username,
            'pivot' => $this->when($this->pivot, function() {
                return [
                    'campaign_id' => $this->pivot->campaign_id,
                    'influencer_id' => $this->pivot->influencer_id
                ];
            })
        ];
    }
}
