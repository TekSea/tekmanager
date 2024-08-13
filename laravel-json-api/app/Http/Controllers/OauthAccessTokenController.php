<?php

namespace App\Http\Controllers;

use App\Models\OauthAccessToken;
use Illuminate\Http\Request;

class OauthAccessTokenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/oauthAccessTokens",
     *     summary="Get all oauthAccessTokens",
     *     description="",
     *     @OA\Response(response="200", description="Get all oauthAccessTokens")
     * )
     */
    public function index()
    {
        $oauthAccessTokens = OauthAccessToken::all();
        return response()->json($oauthAccessTokens);
    }

    /**
     * @OA\Post(
     *     path="/api/oauthAccessTokens",
     *     summary="Create a new oauthAccessToken",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="string", ),
                 *                 @OA\Property(property="user_id", type="integer", ),
                 *                 @OA\Property(property="client_id", type="integer", ),
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="scopes", type="string", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", ),
                 *                 @OA\Property(property="expires_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new oauthAccessToken")
     * )
     */
    public function store(Request $request)
    {
        $oauthAccessToken = OauthAccessToken::create($request->all());
        return response()->json($oauthAccessToken, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/oauthAccessTokens/{id}",
     *     summary="Get a oauthAccessToken by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a oauthAccessToken by ID")
     * )
     */
    public function show($id)
    {
        $oauthAccessToken = OauthAccessToken::where('id', $id)->firstOrFail();
        return response()->json($oauthAccessToken);
    }

    /**
     * @OA\Put(
     *     path="/api/oauthAccessTokens/{id}",
     *     summary="Update a oauthAccessToken",
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
     *                 @OA\Property(property="id", type="string", ),
                 *                 @OA\Property(property="user_id", type="integer", ),
                 *                 @OA\Property(property="client_id", type="integer", ),
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="scopes", type="string", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", ),
                 *                 @OA\Property(property="expires_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a oauthAccessToken")
     * )
     */
    public function update(Request $request, $id)
    {
        $oauthAccessToken = OauthAccessToken::where('id', $id)->firstOrFail();
        $oauthAccessToken->update($request->all());
        return response()->json($oauthAccessToken, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/oauthAccessTokens/{id}",
     *     summary="Delete a oauthAccessToken",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a oauthAccessToken")
     * )
     */
    public function destroy($id)
    {
        $oauthAccessToken = OauthAccessToken::where('id', $id)->firstOrFail();
        $oauthAccessToken->delete();
        return response()->json(null, 204);
    }
}