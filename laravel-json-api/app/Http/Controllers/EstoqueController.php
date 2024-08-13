<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/estoques",
     *     summary="Get all estoques",
     *     description="Tabela que armazena informações sobre os itens no estoque",
     *     @OA\Response(response="200", description="Get all estoques")
     * )
     */
    public function index()
    {
        $estoques = Estoque::all();
        return response()->json($estoques);
    }

    /**
     * @OA\Post(
     *     path="/api/estoques",
     *     summary="Create a new estoque",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", description="Identificador único de cada item no estoque"),
                 *                 @OA\Property(property="ref_sistema", type="string", description="Referência do sistema para o item"),
                 *                 @OA\Property(property="ncm", type="string", description="Código NCM (Nomenclatura Comum do Mercosul) do item"),
                 *                 @OA\Property(property="produto", type="string", description="Descrição detalhada do produto"),
                 *                 @OA\Property(property="created_at", type="string", description="Data de criação do registro"),
                 *                 @OA\Property(property="updated_at", type="string", description="Data de atualização do registro")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new estoque")
     * )
     */
    public function store(Request $request)
    {
        $estoque = Estoque::create($request->all());
        return response()->json($estoque, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/estoques/{id}",
     *     summary="Get a estoque by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a estoque by ID")
     * )
     */
    public function show($id)
    {
        $estoque = Estoque::where('id', $id)->firstOrFail();
        return response()->json($estoque);
    }

    /**
     * @OA\Put(
     *     path="/api/estoques/{id}",
     *     summary="Update a estoque",
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
     *                 @OA\Property(property="id", type="integer", description="Identificador único de cada item no estoque"),
                 *                 @OA\Property(property="ref_sistema", type="string", description="Referência do sistema para o item"),
                 *                 @OA\Property(property="ncm", type="string", description="Código NCM (Nomenclatura Comum do Mercosul) do item"),
                 *                 @OA\Property(property="produto", type="string", description="Descrição detalhada do produto"),
                 *                 @OA\Property(property="created_at", type="string", description="Data de criação do registro"),
                 *                 @OA\Property(property="updated_at", type="string", description="Data de atualização do registro")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a estoque")
     * )
     */
    public function update(Request $request, $id)
    {
        $estoque = Estoque::where('id', $id)->firstOrFail();
        $estoque->update($request->all());
        return response()->json($estoque, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/estoques/{id}",
     *     summary="Delete a estoque",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a estoque")
     * )
     */
    public function destroy($id)
    {
        $estoque = Estoque::where('id', $id)->firstOrFail();
        $estoque->delete();
        return response()->json(null, 204);
    }
}