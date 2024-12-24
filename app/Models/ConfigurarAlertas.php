<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigurarAlertas extends Model
{
    use HasFactory;use SoftDeletes;

    protected $fillable = [
        'placa',
        'tempo',
        'ativo',
        'deleted_at'
    ];
}
