<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class CustomProdutoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/produtos/buscar",
     *     summary="Buscar produtos por descrição",
     *     description="Busca produtos com base em uma palavra-chave presente na descrição do produto.",
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Descrição ou parte da descrição do produto a ser buscado."
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Lista de produtos que correspondem ao termo de busca.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 properties={
     *                     @OA\Property(property="id", type="integer", description="ID do produto", example=1),
     *                     @OA\Property(property="ref_sistema", type="string", description="Referência do sistema para o produto", example="ABC123"),
     *                     @OA\Property(property="ncm", type="string", description="Código NCM do produto", example="12345678"),
     *                     @OA\Property(property="produto", type="string", description="Descrição detalhada do produto", example="Produto Exemplo"),
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
        $clientes = Produto::where('produto', 'LIKE', "%{$query}%")->limit(20)->get();
        return response()->json($clientes);
    }

}