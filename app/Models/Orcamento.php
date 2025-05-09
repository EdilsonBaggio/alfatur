<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
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
        'habitacao',
        'pais_origem',
        'idioma',
        'valor_total',
        'observacoes',
    ];

    public function tours()
    {
        return $this->hasMany(OrcamentoTour::class);
    }
}
