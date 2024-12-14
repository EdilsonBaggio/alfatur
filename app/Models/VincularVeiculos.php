<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VincularVeiculos extends Model
{
    use HasFactory;use SoftDeletes;

    protected $fillable = [
        'placa',
        'grupo_cliente',
        'whatsapp',
        'deleted_at'
    ];

    public function grupoNome()
    {
        return $this->hasOne(Grupos::class,'id','grupo_cliente');
    }
}
