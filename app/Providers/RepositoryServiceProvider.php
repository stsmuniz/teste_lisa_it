<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\CampaignServiceInterface;
use App\Services\CampaignService;
use App\Interfaces\Repositories\CampaignRepositoryInterface;
use App\Repositories\CampaignRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CampaignServiceInterface::class, CampaignService::class);
        $this->app->bind(CampaignRepositoryInterface::class, CampaignRepository::class);
    }
}
