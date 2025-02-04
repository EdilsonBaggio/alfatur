<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Logistica;
use App\Models\Tour;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->query('estado');

        // Carrega as vendas junto com os relacionamentos de logistica e tours
        $query = Venda::with(['logistica', 'tours']);

        if ($filtro === 'recaudado') {
            $query->where('estado_pagamento', 'Recaudado');
        } elseif ($filtro === 'no-recaudado') {
            $query->where('estado_pagamento', '!=', 'Recaudado');
        }

        $pagos = $query->get();

        return view('pagos-full', compact('pagos', 'filtro'));
    }

}
