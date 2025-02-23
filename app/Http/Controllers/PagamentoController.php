<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'venda_id' => 'required|integer',
            'forma_pagamento' => 'required|string|max:255',
            'data_pagamento' => 'required|date',
            'valor_pago' => 'required|numeric',
            'valor_a_pagar' => 'required|numeric',
            'valor_recebido' => 'required|numeric',
            'estado_pagamento' => 'required|string|max:255',
            'comprovante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Tratamento do arquivo de comprovante
        if ($request->hasFile('comprovante')) {
            $file = $request->file('comprovante');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $comprovantePath = 'uploads/' . $fileName;
        } else {
            $comprovantePath = null;
        }
        
        // Criar pagamento
        $pagamento = Pagamento::create([
            'venda_id' => $validated['venda_id'],
            'forma_pagamento' => $validated['forma_pagamento'],
            'data_pagamento' => $validated['data_pagamento'],
            'valor_pago' => $validated['valor_pago'],
            'valor_a_pagar' => $validated['valor_a_pagar'],
            'valor_recebido' => $validated['valor_recebido'],
            'estado_pagamento' => $validated['estado_pagamento'],
            'comprovante' => $comprovantePath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pagamento registrado com sucesso!',
            'data' => $pagamento
        ]);
    }

}
