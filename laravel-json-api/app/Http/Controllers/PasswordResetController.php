<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/passwordResets",
     *     summary="Get all passwordResets",
     *     description="",
     *     @OA\Response(response="200", description="Get all passwordResets")
     * )
     */
    public function index()
    {
        $passwordResets = PasswordReset::all();
        return response()->json($passwordResets);
    }

    /**
     * @OA\Post(
     *     path="/api/passwordResets",
     *     summary="Create a new passwordReset",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="email", type="string", ),
                 *                 @OA\Property(property="token", type="string", ),
                 *                 @OA\Property(property="created_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new passwordReset")
     * )
     */
    public function store(Request $request)
    {
        $passwordReset = PasswordReset::create($request->all());
        return response()->json($passwordReset, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/passwordResets/{id}",
     *     summary="Get a passwordReset by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a passwordReset by ID")
     * )
     */
    public function show($id)
    {
        $passwordReset = PasswordReset::where('id', $id)->firstOrFail();
        return response()->json($passwordReset);
    }

    /**
     * @OA\Put(
     *     path="/api/passwordResets/{id}",
     *     summary="Update a passwordReset",
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
     *                 @OA\Property(property="email", type="string", ),
                 *                 @OA\Property(property="token", type="string", ),
                 *                 @OA\Property(property="created_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a passwordReset")
     * )
     */
    public function update(Request $request, $id)
    {
        $passwordReset = PasswordReset::where('id', $id)->firstOrFail();
        $passwordReset->update($request->all());
        return response()->json($passwordReset, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/passwordResets/{id}",
     *     summary="Delete a passwordReset",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a passwordReset")
     * )
     */
    public function destroy($id)
    {
        $passwordReset = PasswordReset::where('id', $id)->firstOrFail();
        $passwordReset->delete();
        return response()->json(null, 204);
    }
}