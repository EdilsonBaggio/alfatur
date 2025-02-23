<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'pagamentos';

    protected $fillable = [
        'venda_id',
        'forma_pagamento',
        'data_pagamento',
        'valor_pago',
        'valor_a_pagar',
        'valor_recebido',
        'estado_pagamento',
        'comprovante',
    ];
    
    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}
