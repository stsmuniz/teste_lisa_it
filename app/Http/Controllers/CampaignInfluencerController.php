<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Interfaces\Services\CampaignServiceInterface;
use App\Http\Resources\InfluencerResource;
use App\Http\Resources\CampaignInfluencerResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\AttachInfluencerRequest;

class CampaignInfluencerController extends Controller
{
    private $campaignService;
    protected $service;

    public function __construct(CampaignServiceInterface $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     * List all influencers for a campaign
     *
     * @OA\Get(
     *     path="/api/campaigns/{campaign}/influencers",
     *     tags={"Campaign Influencers"},
     *     summary="Get list of influencers for a campaign",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="campaign",
     *         in="path",
     *         required=true,
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
    public function index(Request $request, Campaign $campaign)
    {
        $perPage = $request->query('per_page', 10);
        return CampaignInfluencerResource::collection(
            $campaign->influencers()->with('influencer')->paginate($perPage)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/campaigns/{campaign}/influencers",
     *     summary="Add influencers to a campaign",
     *     security={{"bearerAuth":{}}},
     *     tags={"Campaign Influencers"},
     *     @OA\Parameter(
     *         name="campaign",
     *         in="path",
     *         required=true,
     *         description="Campaign ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"influencer_id"},
     *             @OA\Property(
     *                 property="influencer_id",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Influencer successfully added to campaign",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Influencer added successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="influencer_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The selected influencer_id is invalid.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Campaign $campaign, AttachInfluencerRequest $request)
    {
        try {
            $this->campaignService->attachInfluencer($campaign, $request->influencer_id);
            return response()->json(null, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
