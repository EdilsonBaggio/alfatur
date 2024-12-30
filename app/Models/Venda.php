<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendedor',
        'nome',
        'telefone',
        'email',
        'hotel',
        'zona',
        'direcao_hotel',
        'pais_origem',
        'idioma',
        'habitacao',
        'tour',
        'data_tour',
        'pax_adulto',
        'preco_adulto',
        'pax_infantil',
        'preco_infantil',
        'estado_pagamento',
        'forma_pagamento',
        'data_pagamento',
        'valor_total',
        'valor_pago',
        'valor_a_pagar',
        'observacoes',
        'comprovante'
    ];
}
