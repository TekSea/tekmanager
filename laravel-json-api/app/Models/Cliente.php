<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = ['id', 'cnpj_cpf', 'nome', 'nome_fantasia', 'uf', 'cidade', 'representante', 'situacao', 'created_at', 'updated_at'];
public $timestamps = true;
protected $primaryKey = 'id';

}