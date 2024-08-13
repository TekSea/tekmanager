<?php

namespace App\Http\Controllers;

use App\Models\OauthClient;
use Illuminate\Http\Request;

class OauthClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/oauthClients",
     *     summary="Get all oauthClients",
     *     description="",
     *     @OA\Response(response="200", description="Get all oauthClients")
     * )
     */
    public function index()
    {
        $oauthClients = OauthClient::all();
        return response()->json($oauthClients);
    }

    /**
     * @OA\Post(
     *     path="/api/oauthClients",
     *     summary="Create a new oauthClient",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", ),
                 *                 @OA\Property(property="user_id", type="integer", ),
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="secret", type="string", ),
                 *                 @OA\Property(property="provider", type="string", ),
                 *                 @OA\Property(property="redirect", type="string", ),
                 *                 @OA\Property(property="personal_access_client", type="integer", ),
                 *                 @OA\Property(property="password_client", type="integer", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new oauthClient")
     * )
     */
    public function store(Request $request)
    {
        $oauthClient = OauthClient::create($request->all());
        return response()->json($oauthClient, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/oauthClients/{id}",
     *     summary="Get a oauthClient by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a oauthClient by ID")
     * )
     */
    public function show($id)
    {
        $oauthClient = OauthClient::where('id', $id)->firstOrFail();
        return response()->json($oauthClient);
    }

    /**
     * @OA\Put(
     *     path="/api/oauthClients/{id}",
     *     summary="Update a oauthClient",
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
                 *                 @OA\Property(property="user_id", type="integer", ),
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="secret", type="string", ),
                 *                 @OA\Property(property="provider", type="string", ),
                 *                 @OA\Property(property="redirect", type="string", ),
                 *                 @OA\Property(property="personal_access_client", type="integer", ),
                 *                 @OA\Property(property="password_client", type="integer", ),
                 *                 @OA\Property(property="revoked", type="integer", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a oauthClient")
     * )
     */
    public function update(Request $request, $id)
    {
        $oauthClient = OauthClient::where('id', $id)->firstOrFail();
        $oauthClient->update($request->all());
        return response()->json($oauthClient, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/oauthClients/{id}",
     *     summary="Delete a oauthClient",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a oauthClient")
     * )
     */
    public function destroy($id)
    {
        $oauthClient = OauthClient::where('id', $id)->firstOrFail();
        $oauthClient->delete();
        return response()->json(null, 204);
    }
}