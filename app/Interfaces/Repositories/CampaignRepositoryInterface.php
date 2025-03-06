<?php

namespace App\Interfaces\Repositories;

use App\Models\Campaign;
use Illuminate\Pagination\LengthAwarePaginator;

interface CampaignRepositoryInterface
{
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator;
    public function create(array $data): Campaign;
    public function update(Campaign $campaign, array $data): Campaign;
    public function delete(Campaign $campaign): bool;
    public function attachInfluencer(Campaign $campaign, int $influencerId): bool;
    public function detachInfluencer(Campaign $campaign, int $influencerId): bool;
    public function getInfluencers(Campaign $campaign, int $perPage = 10): LengthAwarePaginator;
}
