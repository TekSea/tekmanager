<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/produtos",
     *     summary="Get all produtos",
     *     description="Tabela que armazena informações sobre os produtos",
     *     @OA\Response(response="200", description="Get all produtos")
     * )
     */
    public function index()
    {
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/produtos",
     *     summary="Create a new produto",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", description="Identificador único de cada item no estoque", example=1),
                        @OA\Property(property="ref_sistema", type="string", description="Referência do sistema para o item", example="example"),
                        @OA\Property(property="ncm", type="string", description="Código NCM (Nomenclatura Comum do Mercosul) do item", example="example"),
                        @OA\Property(property="produto", type="string", description="Descrição detalhada do produto", example="example"),
                        @OA\Property(property="created_at", type="string", description="Data de criação do registro", example="2022-01-01 00:00:00"),
                        @OA\Property(property="updated_at", type="string", description="Data de atualização do registro", example="2022-01-01 00:00:00")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new produto")
     * )
     */
    public function store(Request $request)
    {
        $produto = Produto::create($request->all());
        return response()->json($produto, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/produtos/{id}",
     *     summary="Get a produto by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the produto"
     *     ),
     *     @OA\Response(response="200", description="Get a produto by ID")
     * )
     */
    public function show($id)
    {
        $produto = Produto::where('id', $id)->firstOrFail();
        return response()->json($produto);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/produtos/{id}",
     *     summary="Update a produto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the produto"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", description="Identificador único de cada item no estoque", example=1),
                        @OA\Property(property="ref_sistema", type="string", description="Referência do sistema para o item", example="example"),
                        @OA\Property(property="ncm", type="string", description="Código NCM (Nomenclatura Comum do Mercosul) do item", example="example"),
                        @OA\Property(property="produto", type="string", description="Descrição detalhada do produto", example="example"),
                        @OA\Property(property="created_at", type="string", description="Data de criação do registro", example="2022-01-01 00:00:00"),
                        @OA\Property(property="updated_at", type="string", description="Data de atualização do registro", example="2022-01-01 00:00:00")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a produto")
     * )
     */
    public function update(Request $request, $id)
    {
        $produto = Produto::where('id', $id)->firstOrFail();
        $produto->update($request->all());
        return response()->json($produto, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/produtos/{id}",
     *     summary="Delete a produto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the produto"
     *     ),
     *     @OA\Response(response="204", description="Delete a produto")
     * )
     */
    public function destroy($id)
    {
        $produto = Produto::where('id', $id)->firstOrFail();
        $produto->delete();
        return response()->json(null, 204);
    }
}