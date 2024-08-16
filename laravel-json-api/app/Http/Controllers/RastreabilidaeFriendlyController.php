<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RastreabilidaeFriendlyController extends Controller
{
    public function index()
    {
        // Buscando os dados da view 'view_rastreabilidade'
        $rastreabilidade = DB::table('view_rastreabilidade')->get();

        // Retornando os dados em formato JSON
        return response()->json($rastreabilidade);
    }
}
