<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInfluencerRequest;
use App\Models\Influencer;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/influencers",
     *     summary="List all influencers",
     *     tags={"Influencers"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page (default: 10)",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of influencers"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $influencers = Influencer::paginate($perPage);

        return response()->json($influencers);
    }

    /**
     * @OA\Post(
     *     path="/api/influencers",
     *     summary="Create a new influencer",
     *     security={{"bearerAuth":{}}},
     *     tags={"Influencers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "instagram_username", "followers_qty", "category"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="instagram_username", type="string", example="johndoe"),
     *             @OA\Property(property="followers_qty", type="integer", example=100000),
     *             @OA\Property(property="category", type="string", example="Lifestyle")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Influencer created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="instagram_username", type="string", example="johndoe"),
     *             @OA\Property(property="followers_qty", type="integer", example=100000),
     *             @OA\Property(property="category", type="string", example="Lifestyle"),
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
     *                     property="instagram_username",
     *                     type="array",
     *                     @OA\Items(type="string", example="The instagram username has already been taken.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreInfluencerRequest $request)
    {
        $influencer = Influencer::create($request->validated());

        return response()->json($influencer, 201);
    }
}
