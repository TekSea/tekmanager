<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/clientes",
     *     summary="Get all clientes",
     *     description="Tabela que armazena informações dos clientes",
     *     @OA\Response(response="200", description="Get all clientes")
     * )
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/clientes",
     *     summary="Create a new cliente",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", description="Identificador único de cada cliente", example=1),
                        @OA\Property(property="cnpj_cpf", type="string", description="CNPJ ou CPF do cliente", example="example"),
                        @OA\Property(property="nome", type="string", description="Nome completo ou razão social do cliente", example="example"),
                        @OA\Property(property="nome_fantasia", type="string", description="Nome fantasia do cliente, se aplicável", example="example"),
                        @OA\Property(property="uf", type="string", description="Unidade federativa (estado) do cliente", example="example"),
                        @OA\Property(property="cidade", type="string", description="Cidade do cliente", example="example"),
                        @OA\Property(property="representante", type="string", description="Representante associado ao cliente", example="example"),
                        @OA\Property(property="situacao", type="string", description="Situação do cliente (ativo/inativo)", example="example"),
                        @OA\Property(property="created_at", type="string", description="Data de criação do registro", example="2022-01-01 00:00:00"),
                        @OA\Property(property="updated_at", type="string", description="Data de atualização do registro", example="2022-01-01 00:00:00")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new cliente")
     * )
     */
    public function store(Request $request)
    {
        $cliente = Cliente::create($request->all());
        return response()->json($cliente, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/clientes/{id}",
     *     summary="Get a cliente by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the cliente"
     *     ),
     *     @OA\Response(response="200", description="Get a cliente by ID")
     * )
     */
    public function show($id)
    {
        $cliente = Cliente::where('id', $id)->firstOrFail();
        return response()->json($cliente);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/clientes/{id}",
     *     summary="Update a cliente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the cliente"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", description="Identificador único de cada cliente", example=1),
                        @OA\Property(property="cnpj_cpf", type="string", description="CNPJ ou CPF do cliente", example="example"),
                        @OA\Property(property="nome", type="string", description="Nome completo ou razão social do cliente", example="example"),
                        @OA\Property(property="nome_fantasia", type="string", description="Nome fantasia do cliente, se aplicável", example="example"),
                        @OA\Property(property="uf", type="string", description="Unidade federativa (estado) do cliente", example="example"),
                        @OA\Property(property="cidade", type="string", description="Cidade do cliente", example="example"),
                        @OA\Property(property="representante", type="string", description="Representante associado ao cliente", example="example"),
                        @OA\Property(property="situacao", type="string", description="Situação do cliente (ativo/inativo)", example="example"),
                        @OA\Property(property="created_at", type="string", description="Data de criação do registro", example="2022-01-01 00:00:00"),
                        @OA\Property(property="updated_at", type="string", description="Data de atualização do registro", example="2022-01-01 00:00:00")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a cliente")
     * )
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::where('id', $id)->firstOrFail();
        $cliente->update($request->all());
        return response()->json($cliente, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/clientes/{id}",
     *     summary="Delete a cliente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the cliente"
     *     ),
     *     @OA\Response(response="204", description="Delete a cliente")
     * )
     */
    public function destroy($id)
    {
        $cliente = Cliente::where('id', $id)->firstOrFail();
        $cliente->delete();
        return response()->json(null, 204);
    }
}