<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
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

    /**
     * Disable data wrapping for single resources.
     */
    public static function withoutWrapping()
    {
        return true;
    }
}
