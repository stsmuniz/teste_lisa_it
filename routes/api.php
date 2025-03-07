<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\CampaignInfluencerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// Auth Routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('campaigns', CampaignController::class)->only([
        'index', 'store'
    ]);

    Route::apiResource('influencers', InfluencerController::class)->only([
        'index', 'store'
    ]);

    Route::apiResource('campaigns.influencers', CampaignInfluencerController::class)->only([
        'index', 'store', 'destroy'
    ]);
});




