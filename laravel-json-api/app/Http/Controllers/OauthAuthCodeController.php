<?php

namespace App\Http\Controllers;

use App\Models\OauthAuthCode;
use Illuminate\Http\Request;

class OauthAuthCodeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/oauthAuthCodes",
     *     summary="Get all oauthAuthCodes",
     *     description="",
     *     @OA\Response(response="200", description="Get all oauthAuthCodes")
     * )
     */
    public function index()
    {
        $oauthAuthCodes = OauthAuthCode::all();
        return response()->json($oauthAuthCodes);
    }

    /**
     * @OA\Post(
     *     path="/api/oauthAuthCodes",
     *     summary="Create a new oauthAuthCode",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="string", ),
                 *                 @OA\Property(property="user_id", type="integer", ),
                 *                 @OA\Property(property="client_id", type="integer", ),
                 *                 @OA\Property(property="scopes", type="string", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="expires_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new oauthAuthCode")
     * )
     */
    public function store(Request $request)
    {
        $oauthAuthCode = OauthAuthCode::create($request->all());
        return response()->json($oauthAuthCode, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/oauthAuthCodes/{id}",
     *     summary="Get a oauthAuthCode by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a oauthAuthCode by ID")
     * )
     */
    public function show($id)
    {
        $oauthAuthCode = OauthAuthCode::where('id', $id)->firstOrFail();
        return response()->json($oauthAuthCode);
    }

    /**
     * @OA\Put(
     *     path="/api/oauthAuthCodes/{id}",
     *     summary="Update a oauthAuthCode",
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
                 *                 @OA\Property(property="scopes", type="string", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="expires_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a oauthAuthCode")
     * )
     */
    public function update(Request $request, $id)
    {
        $oauthAuthCode = OauthAuthCode::where('id', $id)->firstOrFail();
        $oauthAuthCode->update($request->all());
        return response()->json($oauthAuthCode, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/oauthAuthCodes/{id}",
     *     summary="Delete a oauthAuthCode",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a oauthAuthCode")
     * )
     */
    public function destroy($id)
    {
        $oauthAuthCode = OauthAuthCode::where('id', $id)->firstOrFail();
        $oauthAuthCode->delete();
        return response()->json(null, 204);
    }
}