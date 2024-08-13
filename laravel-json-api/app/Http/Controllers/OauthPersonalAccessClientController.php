<?php

namespace App\Http\Controllers;

use App\Models\OauthPersonalAccessClient;
use Illuminate\Http\Request;

class OauthPersonalAccessClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/oauthPersonalAccessClients",
     *     summary="Get all oauthPersonalAccessClients",
     *     description="",
     *     @OA\Response(response="200", description="Get all oauthPersonalAccessClients")
     * )
     */
    public function index()
    {
        $oauthPersonalAccessClients = OauthPersonalAccessClient::all();
        return response()->json($oauthPersonalAccessClients);
    }

    /**
     * @OA\Post(
     *     path="/api/oauthPersonalAccessClients",
     *     summary="Create a new oauthPersonalAccessClient",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", ),
                 *                 @OA\Property(property="client_id", type="integer", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new oauthPersonalAccessClient")
     * )
     */
    public function store(Request $request)
    {
        $oauthPersonalAccessClient = OauthPersonalAccessClient::create($request->all());
        return response()->json($oauthPersonalAccessClient, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/oauthPersonalAccessClients/{id}",
     *     summary="Get a oauthPersonalAccessClient by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a oauthPersonalAccessClient by ID")
     * )
     */
    public function show($id)
    {
        $oauthPersonalAccessClient = OauthPersonalAccessClient::where('id', $id)->firstOrFail();
        return response()->json($oauthPersonalAccessClient);
    }

    /**
     * @OA\Put(
     *     path="/api/oauthPersonalAccessClients/{id}",
     *     summary="Update a oauthPersonalAccessClient",
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
                 *                 @OA\Property(property="client_id", type="integer", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a oauthPersonalAccessClient")
     * )
     */
    public function update(Request $request, $id)
    {
        $oauthPersonalAccessClient = OauthPersonalAccessClient::where('id', $id)->firstOrFail();
        $oauthPersonalAccessClient->update($request->all());
        return response()->json($oauthPersonalAccessClient, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/oauthPersonalAccessClients/{id}",
     *     summary="Delete a oauthPersonalAccessClient",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a oauthPersonalAccessClient")
     * )
     */
    public function destroy($id)
    {
        $oauthPersonalAccessClient = OauthPersonalAccessClient::where('id', $id)->firstOrFail();
        $oauthPersonalAccessClient->delete();
        return response()->json(null, 204);
    }
}