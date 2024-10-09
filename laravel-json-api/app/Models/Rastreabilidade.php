<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rastreabilidade extends Model
{
    use HasFactory;

    protected $table = 'rastreabilidades';

    protected $fillable = ['id', 'numero_serie', 'data_geracao', 'responsavel_criacao', 'cliente_id', 'produto_id', 'pv', 'op', 'codigo_net', 'ref_sistema', 'obra_alocada', 'n_fatura', 'data_enviado', 'garantia_dias', 'expira_garantia', 'status_garantia', 'condicao_garantia', 'created_at', 'updated_at'];
public $timestamps = true;
protected $primaryKey = 'id';

}