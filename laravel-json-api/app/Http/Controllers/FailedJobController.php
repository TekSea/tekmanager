<?php

namespace App\Http\Controllers;

use App\Models\FailedJob;
use Illuminate\Http\Request;

class FailedJobController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/failedJobs",
     *     summary="Get all failedJobs",
     *     description="",
     *     @OA\Response(response="200", description="Get all failedJobs")
     * )
     */
    public function index()
    {
        $failedJobs = FailedJob::all();
        return response()->json($failedJobs);
    }

    /**
     * @OA\Post(
     *     path="/api/failedJobs",
     *     summary="Create a new failedJob",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", ),
                 *                 @OA\Property(property="uuid", type="string", ),
                 *                 @OA\Property(property="connection", type="string", ),
                 *                 @OA\Property(property="queue", type="string", ),
                 *                 @OA\Property(property="payload", type="string", ),
                 *                 @OA\Property(property="exception", type="string", ),
                 *                 @OA\Property(property="failed_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new failedJob")
     * )
     */
    public function store(Request $request)
    {
        $failedJob = FailedJob::create($request->all());
        return response()->json($failedJob, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/failedJobs/{id}",
     *     summary="Get a failedJob by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a failedJob by ID")
     * )
     */
    public function show($id)
    {
        $failedJob = FailedJob::where('id', $id)->firstOrFail();
        return response()->json($failedJob);
    }

    /**
     * @OA\Put(
     *     path="/api/failedJobs/{id}",
     *     summary="Update a failedJob",
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
                 *                 @OA\Property(property="uuid", type="string", ),
                 *                 @OA\Property(property="connection", type="string", ),
                 *                 @OA\Property(property="queue", type="string", ),
                 *                 @OA\Property(property="payload", type="string", ),
                 *                 @OA\Property(property="exception", type="string", ),
                 *                 @OA\Property(property="failed_at", type="string", )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a failedJob")
     * )
     */
    public function update(Request $request, $id)
    {
        $failedJob = FailedJob::where('id', $id)->firstOrFail();
        $failedJob->update($request->all());
        return response()->json($failedJob, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/failedJobs/{id}",
     *     summary="Delete a failedJob",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a failedJob")
     * )
     */
    public function destroy($id)
    {
        $failedJob = FailedJob::where('id', $id)->firstOrFail();
        $failedJob->delete();
        return response()->json(null, 204);
    }
}