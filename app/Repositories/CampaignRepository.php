<?php

namespace App\Repositories;

use App\Models\Campaign;
use App\Interfaces\Repositories\CampaignRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class CampaignRepository implements CampaignRepositoryInterface
{
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Campaign::paginate($perPage);
    }

    public function create(array $data): Campaign
    {
        return Campaign::create($data);
    }

    public function update(Campaign $campaign, array $data): Campaign
    {
        $campaign->update($data);
        return $campaign;
    }

    public function delete(Campaign $campaign): bool
    {
        return $campaign->delete();
    }

    public function attachInfluencer(Campaign $campaign, int $influencerId): bool
    {
        if ($campaign->influencers()->where('influencer_id', $influencerId)->exists()) {
            throw ValidationException::withMessages([
                'message' => 'The influencer is already attached to this campaign.'
            ]);
        }

        $campaign->influencers()->attach($influencerId);
        return true;
    }

    public function detachInfluencer(Campaign $campaign, int $influencerId): bool
    {
        return (bool) $campaign->influencers()->detach($influencerId);
    }

    public function getInfluencers(Campaign $campaign, int $perPage = 10): LengthAwarePaginator
    {
        return $campaign->influencers()->paginate($perPage);
    }
}
