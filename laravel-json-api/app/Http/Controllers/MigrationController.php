<?php

namespace App\Http\Controllers;

use App\Models\Migration;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/migrations",
     *     summary="Get all migrations",
     *     description="",
     *     @OA\Response(response="200", description="Get all migrations")
     * )
     */
    public function index()
    {
        $migrations = Migration::all();
        return response()->json($migrations);
    }

    /**
     * @OA\Post(
     *     path="/api/migrations",
     *     summary="Create a new migration",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", ),
                 *                 @OA\Property(property="migration", type="string", ),
                 *                 @OA\Property(property="batch", type="integer", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new migration")
     * )
     */
    public function store(Request $request)
    {
        $migration = Migration::create($request->all());
        return response()->json($migration, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/migrations/{id}",
     *     summary="Get a migration by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a migration by ID")
     * )
     */
    public function show($id)
    {
        $migration = Migration::where('id', $id)->firstOrFail();
        return response()->json($migration);
    }

    /**
     * @OA\Put(
     *     path="/api/migrations/{id}",
     *     summary="Update a migration",
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
                 *                 @OA\Property(property="migration", type="string", ),
                 *                 @OA\Property(property="batch", type="integer", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a migration")
     * )
     */
    public function update(Request $request, $id)
    {
        $migration = Migration::where('id', $id)->firstOrFail();
        $migration->update($request->all());
        return response()->json($migration, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/migrations/{id}",
     *     summary="Delete a migration",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a migration")
     * )
     */
    public function destroy($id)
    {
        $migration = Migration::where('id', $id)->firstOrFail();
        $migration->delete();
        return response()->json(null, 204);
    }
}