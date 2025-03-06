<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Http\Requests\CampaignRequest;
use App\Interfaces\Services\CampaignServiceInterface;
use App\Http\Resources\CampaignResource;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private $campaignService;

    public function __construct(CampaignServiceInterface $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     * List all campaigns
     *
     * @OA\Get(
     *     path="/api/campaigns",
     *     tags={"Campaigns"},
     *     summary="Get list of campaigns",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return CampaignResource::collection(Campaign::paginate($perPage));
    }

    /**
     * Store a new campaign
     *
     * @OA\Post(
     *     path="/api/campaigns",
     *     tags={"Campaigns"},
     *     summary="Create a new campaign",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "start_date", "end_date", "budget"},
     *             @OA\Property(property="name", type="string", example="Summer Campaign 2024"),
     *             @OA\Property(property="description", type="string", example="Campaign description here"),
     *             @OA\Property(property="start_date", type="string", format="date-time", example="2024-06-01T00:00:00Z"),
     *             @OA\Property(property="end_date", type="string", format="date-time", example="2024-08-01T00:00:00Z"),
     *             @OA\Property(property="budget", type="integer", example=5000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaign created successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(CampaignRequest $request)
    {
        $campaign = Campaign::create($request->validated());
        return (new CampaignResource($campaign))
            ->response()
            ->setStatusCode(201);
    }
}
