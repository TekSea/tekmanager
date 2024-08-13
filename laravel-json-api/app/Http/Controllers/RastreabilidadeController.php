<?php

namespace App\Http\Controllers;

use App\Models\Rastreabilidade;
use Illuminate\Http\Request;

class RastreabilidadeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rastreabilidades",
     *     summary="Get all rastreabilidades",
     *     description="Tabela que armazena a rastreabilidade dos produtos",
     *     @OA\Response(response="200", description="Get all rastreabilidades")
     * )
     */
    public function index()
    {
        $rastreabilidades = Rastreabilidade::all();
        return response()->json($rastreabilidades);
    }

    /**
     * @OA\Post(
     *     path="/api/rastreabilidades",
     *     summary="Create a new rastreabilidade",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", description="Identificador único para rastreabilidade de cada produto"),
                 *                 @OA\Property(property="numero_serie", type="integer", description="Número de série do produto"),
                 *                 @OA\Property(property="data_geracao", type="string", description="Data de geração do produto ou registro"),
                 *                 @OA\Property(property="responsavel_criacao", type="string", description="Responsável pela criação do produto ou registro"),
                 *                 @OA\Property(property="cliente_id", type="integer", description="Identificador do cliente relacionado (FK para clientes)"),
                 *                 @OA\Property(property="estoque_id", type="integer", description="Identificador do item no estoque relacionado (FK para estoque)"),
                 *                 @OA\Property(property="pv", type="string", description="PV associado ao produto"),
                 *                 @OA\Property(property="op", type="string", description="Ordem de produção associada ao produto"),
                 *                 @OA\Property(property="codigo_net", type="integer", description="Código NET do produto"),
                 *                 @OA\Property(property="ref_sistema", type="string", description="Referência do sistema para o produto"),
                 *                 @OA\Property(property="produto", type="string", description="Descrição do produto"),
                 *                 @OA\Property(property="obra_alocada", type="string", description="Obra onde o produto foi alocado"),
                 *                 @OA\Property(property="n_fatura", type="string", description="Número da fatura associada ao produto"),
                 *                 @OA\Property(property="data_enviado", type="string", description="Data de envio do produto"),
                 *                 @OA\Property(property="garantia_dias", type="integer", description="Número de dias de garantia do produto"),
                 *                 @OA\Property(property="expira_garantia", type="string", description="Data de expiração da garantia"),
                 *                 @OA\Property(property="status_garantia", type="string", description="Status atual da garantia do produto"),
                 *                 @OA\Property(property="condicao_garantia", type="string", description="Condições específicas da garantia"),
                 *                 @OA\Property(property="created_at", type="string", description="Data de criação do registro"),
                 *                 @OA\Property(property="updated_at", type="string", description="Data de atualização do registro")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="201", description="Create a new rastreabilidade")
     * )
     */
    public function store(Request $request)
    {
        $rastreabilidade = Rastreabilidade::create($request->all());
        return response()->json($rastreabilidade, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/rastreabilidades/{id}",
     *     summary="Get a rastreabilidade by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Get a rastreabilidade by ID")
     * )
     */
    public function show($id)
    {
        $rastreabilidade = Rastreabilidade::where('id', $id)->firstOrFail();
        return response()->json($rastreabilidade);
    }

    /**
     * @OA\Put(
     *     path="/api/rastreabilidades/{id}",
     *     summary="Update a rastreabilidade",
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
     *                 @OA\Property(property="id", type="integer", description="Identificador único para rastreabilidade de cada produto"),
                 *                 @OA\Property(property="numero_serie", type="integer", description="Número de série do produto"),
                 *                 @OA\Property(property="data_geracao", type="string", description="Data de geração do produto ou registro"),
                 *                 @OA\Property(property="responsavel_criacao", type="string", description="Responsável pela criação do produto ou registro"),
                 *                 @OA\Property(property="cliente_id", type="integer", description="Identificador do cliente relacionado (FK para clientes)"),
                 *                 @OA\Property(property="estoque_id", type="integer", description="Identificador do item no estoque relacionado (FK para estoque)"),
                 *                 @OA\Property(property="pv", type="string", description="PV associado ao produto"),
                 *                 @OA\Property(property="op", type="string", description="Ordem de produção associada ao produto"),
                 *                 @OA\Property(property="codigo_net", type="integer", description="Código NET do produto"),
                 *                 @OA\Property(property="ref_sistema", type="string", description="Referência do sistema para o produto"),
                 *                 @OA\Property(property="produto", type="string", description="Descrição do produto"),
                 *                 @OA\Property(property="obra_alocada", type="string", description="Obra onde o produto foi alocado"),
                 *                 @OA\Property(property="n_fatura", type="string", description="Número da fatura associada ao produto"),
                 *                 @OA\Property(property="data_enviado", type="string", description="Data de envio do produto"),
                 *                 @OA\Property(property="garantia_dias", type="integer", description="Número de dias de garantia do produto"),
                 *                 @OA\Property(property="expira_garantia", type="string", description="Data de expiração da garantia"),
                 *                 @OA\Property(property="status_garantia", type="string", description="Status atual da garantia do produto"),
                 *                 @OA\Property(property="condicao_garantia", type="string", description="Condições específicas da garantia"),
                 *                 @OA\Property(property="created_at", type="string", description="Data de criação do registro"),
                 *                 @OA\Property(property="updated_at", type="string", description="Data de atualização do registro")
     *             }
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update a rastreabilidade")
     * )
     */
    public function update(Request $request, $id)
    {
        $rastreabilidade = Rastreabilidade::where('id', $id)->firstOrFail();
        $rastreabilidade->update($request->all());
        return response()->json($rastreabilidade, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/rastreabilidades/{id}",
     *     summary="Delete a rastreabilidade",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete a rastreabilidade")
     * )
     */
    public function destroy($id)
    {
        $rastreabilidade = Rastreabilidade::where('id', $id)->firstOrFail();
        $rastreabilidade->delete();
        return response()->json(null, 204);
    }
}