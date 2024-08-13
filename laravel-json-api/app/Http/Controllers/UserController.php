<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     description="",
     *     @OA\Response(response="200", description="Get all users")
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", ),
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="email", type="string", ),
                 *                 @OA\Property(property="email_verified_at", type="string", ),
                 *                 @OA\Property(property="password", type="string", ),
                 *                 @OA\Property(property="remember_token", type="string", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new user")
     * )
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get a user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a user by ID")
     * )
     */
    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update a user",
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
                 *                 @OA\Property(property="name", type="string", ),
                 *                 @OA\Property(property="email", type="string", ),
                 *                 @OA\Property(property="email_verified_at", type="string", ),
                 *                 @OA\Property(property="password", type="string", ),
                 *                 @OA\Property(property="remember_token", type="string", ),
                 *                 @OA\Property(property="created_at", type="string", ),
                 *                 @OA\Property(property="updated_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a user")
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a user")
     * )
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->delete();
        return response()->json(null, 204);
    }
}