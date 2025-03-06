<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignInfluencerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date->toISOString(),
            'end_date' => $this->end_date->toISOString(),
            'budget' => $this->budget,
            'influencers' => $this->influencers->map(function ($influencer) {
                return [
                    'id' => $influencer->id,
                    'name' => $influencer->name,
                    'instagram_username' => $influencer->instagram_username,
                    'followers_qty' => $influencer->followers_qty,
                    'category' => $influencer->category,
                ];
            }),
        ];
    }

    /**
     * Create a paginated response.
     */
    public static function collection($resource)
    {
        return tap(parent::collection($resource), function($collection) {
            if (method_exists($collection->resource, 'currentPage')) {
                $collection->additional([
                    'current_page' => $collection->resource->currentPage(),
                    'per_page' => (int) $collection->resource->perPage(),
                    'total' => $collection->resource->total(),
                ]);
            }
        });
    }
}
