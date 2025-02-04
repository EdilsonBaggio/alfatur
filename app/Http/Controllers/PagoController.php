<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Logistica;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->query('estado');

        $query = Venda::with('logistica');

        if ($filtro === 'recaudado') {
            $query->where('estado_pagamento', 'Recaudado');
        } elseif ($filtro === 'no-recaudado') {
            $query->where('estado_pagamento', '!=', 'Recaudado');
        }

        $pagos = $query->get();

        return view('pagos-full', compact('pagos', 'filtro'));
    }
}
