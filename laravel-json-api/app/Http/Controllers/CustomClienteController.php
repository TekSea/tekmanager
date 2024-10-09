<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class CustomClienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/clientes/buscar",
     *     summary="Buscar clientes por nome",
     *     description="Retorna uma lista de clientes cujo nome corresponde ao termo de busca fornecido.",
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Nome ou parte do nome do cliente a ser buscado."
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Lista de clientes que correspondem ao termo de busca",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 properties={
     *                     @OA\Property(property="id", type="integer", description="ID do cliente", example=1),
     *                     @OA\Property(property="nome", type="string", description="Nome do cliente", example="João Silva"),
     *                     @OA\Property(property="cnpj_cpf", type="string", description="CNPJ ou CPF do cliente", example="12345678900"),
     *                     @OA\Property(property="nome_fantasia", type="string", description="Nome fantasia do cliente, se aplicável", example="João Lanches"),
     *                     @OA\Property(property="uf", type="string", description="Unidade federativa (estado) do cliente", example="SP"),
     *                     @OA\Property(property="cidade", type="string", description="Cidade do cliente", example="São Paulo"),
     *                     @OA\Property(property="representante", type="string", description="Representante associado ao cliente", example="Pedro Almeida"),
     *                     @OA\Property(property="situacao", type="string", description="Situação do cliente (ativo/inativo)", example="ativo"),
     *                     @OA\Property(property="created_at", type="string", description="Data de criação do registro", example="2022-01-01 00:00:00"),
     *                     @OA\Property(property="updated_at", type="string", description="Data de atualização do registro", example="2022-01-01 00:00:00")
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Parâmetro de busca 'query' está faltando ou é inválido.",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="error", type="string", example="O parâmetro de busca 'query' é obrigatório.")
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="error", type="string", example="Erro ao processar a solicitação.")
     *             }
     *         )
     *     )
     * )
     */
    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $clientes = Cliente::where('nome', 'LIKE', "%{$query}%")->limit(20)->get();
        return response()->json($clientes);
    }

}