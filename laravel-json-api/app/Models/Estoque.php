<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $table = 'estoques';

    protected $fillable = ['id', 'ref_sistema', 'ncm', 'produto', 'created_at', 'updated_at'];
public $timestamps = true;
protected $primaryKey = 'id';

}