<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Migration extends Model
{
    use HasFactory;

    protected $table = 'migrations';

    protected $fillable = ['id', 'migration', 'batch'];
public $timestamps = false;
protected $primaryKey = 'id';

}