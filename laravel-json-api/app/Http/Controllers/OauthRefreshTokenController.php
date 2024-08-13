<?php

namespace App\Http\Controllers;

use App\Models\OauthRefreshToken;
use Illuminate\Http\Request;

class OauthRefreshTokenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/oauthRefreshTokens",
     *     summary="Get all oauthRefreshTokens",
     *     description="",
     *     @OA\Response(response="200", description="Get all oauthRefreshTokens")
     * )
     */
    public function index()
    {
        $oauthRefreshTokens = OauthRefreshToken::all();
        return response()->json($oauthRefreshTokens);
    }

    /**
     * @OA\Post(
     *     path="/api/oauthRefreshTokens",
     *     summary="Create a new oauthRefreshToken",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="string", ),
                 *                 @OA\Property(property="access_token_id", type="string", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="expires_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new oauthRefreshToken")
     * )
     */
    public function store(Request $request)
    {
        $oauthRefreshToken = OauthRefreshToken::create($request->all());
        return response()->json($oauthRefreshToken, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/oauthRefreshTokens/{id}",
     *     summary="Get a oauthRefreshToken by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a oauthRefreshToken by ID")
     * )
     */
    public function show($id)
    {
        $oauthRefreshToken = OauthRefreshToken::where('id', $id)->firstOrFail();
        return response()->json($oauthRefreshToken);
    }

    /**
     * @OA\Put(
     *     path="/api/oauthRefreshTokens/{id}",
     *     summary="Update a oauthRefreshToken",
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
                 *                 @OA\Property(property="access_token_id", type="string", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="expires_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a oauthRefreshToken")
     * )
     */
    public function update(Request $request, $id)
    {
        $oauthRefreshToken = OauthRefreshToken::where('id', $id)->firstOrFail();
        $oauthRefreshToken->update($request->all());
        return response()->json($oauthRefreshToken, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/oauthRefreshTokens/{id}",
     *     summary="Delete a oauthRefreshToken",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a oauthRefreshToken")
     * )
     */
    public function destroy($id)
    {
        $oauthRefreshToken = OauthRefreshToken::where('id', $id)->firstOrFail();
        $oauthRefreshToken->delete();
        return response()->json(null, 204);
    }
}