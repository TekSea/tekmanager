<?php

namespace App\Http\Controllers;

use App\Models\PersonalAccessToken;
use Illuminate\Http\Request;

class PersonalAccessTokenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/personalAccessTokens",
     *     summary="Get all personalAccessTokens",
     *     description="",
     *     @OA\Response(response="200", description="Get all personalAccessTokens")
     * )
     */
    public function index()
    {
        $personalAccessTokens = PersonalAccessToken::all();
        return response()->json($personalAccessTokens);
    }

    /**
     * @OA\Post(
     *     path="/api/personalAccessTokens",
     *     summary="Create a new personalAccessToken",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", ),
                 *                 @OA\Property(property="tokenable_type", type="string", ),
                 *                 @OA\Property(property="tokenable_id", type="integer", ),
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="token", type="string", ),
                 *                 @OA\Property(property="abilities", type="string", ),
                 *                 @OA\Property(property="last_used_at", type="string", ),
                 *                 @OA\Property(property="expires_at", type="string", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new personalAccessToken")
     * )
     */
    public function store(Request $request)
    {
        $personalAccessToken = PersonalAccessToken::create($request->all());
        return response()->json($personalAccessToken, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/personalAccessTokens/{id}",
     *     summary="Get a personalAccessToken by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a personalAccessToken by ID")
     * )
     */
    public function show($id)
    {
        $personalAccessToken = PersonalAccessToken::where('id', $id)->firstOrFail();
        return response()->json($personalAccessToken);
    }

    /**
     * @OA\Put(
     *     path="/api/personalAccessTokens/{id}",
     *     summary="Update a personalAccessToken",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", ),
                 *                 @OA\Property(property="tokenable_type", type="string", ),
                 *                 @OA\Property(property="tokenable_id", type="integer", ),
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="token", type="string", ),
                 *                 @OA\Property(property="abilities", type="string", ),
                 *                 @OA\Property(property="last_used_at", type="string", ),
                 *                 @OA\Property(property="expires_at", type="string", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a personalAccessToken")
     * )
     */
    public function update(Request $request, $id)
    {
        $personalAccessToken = PersonalAccessToken::where('id', $id)->firstOrFail();
        $personalAccessToken->update($request->all());
        return response()->json($personalAccessToken, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/personalAccessTokens/{id}",
     *     summary="Delete a personalAccessToken",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a personalAccessToken")
     * )
     */
    public function destroy($id)
    {
        $personalAccessToken = PersonalAccessToken::where('id', $id)->firstOrFail();
        $personalAccessToken->delete();
        return response()->json(null, 204);
    }
}