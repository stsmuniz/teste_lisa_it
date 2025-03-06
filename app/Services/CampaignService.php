<?php

namespace App\Services;

use App\Models\Campaign;
use App\Interfaces\Services\CampaignServiceInterface;
use App\Interfaces\Repositories\CampaignRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class CampaignService implements CampaignServiceInterface
{
    private $repository;

    public function __construct(CampaignRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated($perPage);
    }

    public function create(array $data): Campaign
    {
        return $this->repository->create($data);
    }

    public function update(Campaign $campaign, array $data): Campaign
    {
        return $this->repository->update($campaign, $data);
    }

    public function delete(Campaign $campaign): bool
    {
        return $this->repository->delete($campaign);
    }

    public function attachInfluencer(Campaign $campaign, int $influencerId): bool
    {
        return $this->repository->attachInfluencer($campaign, $influencerId);
    }

    public function detachInfluencer(Campaign $campaign, int $influencerId): bool
    {
        return $this->repository->detachInfluencer($campaign, $influencerId);
    }

    public function getInfluencers(Campaign $campaign, int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getInfluencers($campaign, $perPage);
    }
}
