<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendasController extends Controller
{

    public function index()
    {
        $vendas = Venda::where('user_id', Auth::id())->get();
        return view('vendas.list', compact('vendas'));
    }

    public function create()
    {
        return view('vendas.create');
    }

    public function store(Request $request)
    {
        // Validação dos campos
        $request->validate([
            // Dados pessoais
            'vendedor' => 'required|string',
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'nullable|email',
            'hotel' => 'required|string',
            'zona' => 'required|string',
            'direcao_hotel' => 'required|string',
            'habitacao' => 'required|string',
            'pais_origem' => 'nullable|string',
            'idioma' => 'nullable|string',

            // Tour 1
            'tour' => 'required|string',
            'data_tour' => 'required|date',
            'pax_adulto' => 'required|integer',
            'preco_adulto' => 'required|numeric',
            'pax_infantil' => 'nullable|integer',
            'preco_infantil' => 'nullable|numeric',

            // Pagamento
            'estado_pagamento' => 'required|string',
            'forma_pagamento' => 'required|string',
            'data_pagamento' => 'required|date',
            'valor_total' => 'required|numeric',
            'valor_pago' => 'required|numeric',
            'valor_a_pagar' => 'required|numeric',

            // Observações e comprovante
            'observacoes' => 'nullable|string',
            'comprovante' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048', // Suporta PDF e imagens até 2MB
        ]);

        // Processa o upload do comprovante, se fornecido
        $comprovantePath = null;
        if ($request->hasFile('comprovante')) {
            $comprovantePath = $request->file('comprovante')->store('comprovantes', 'public');
        }

        // Criação do registro
        Venda::create([
            'user_id' => auth()->id(),
            'vendedor' => $request->vendedor,
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'hotel' => $request->hotel,
            'zona' => $request->zona,
            'direcao_hotel' => $request->direcao_hotel,
            'habitacao' => $request->habitacao,
            'pais_origem' => $request->pais_origem,
            'idioma' => $request->idioma,

            // Tour 1
            'tour' => $request->tour,
            'data_tour' => $request->data_tour,
            'pax_adulto' => $request->pax_adulto,
            'preco_adulto' => $request->preco_adulto,
            'pax_infantil' => $request->pax_infantil,
            'preco_infantil' => $request->preco_infantil,

            // Pagamento
            'estado_pagamento' => $request->estado_pagamento,
            'forma_pagamento' => $request->forma_pagamento,
            'data_pagamento' => $request->data_pagamento,
            'valor_total' => $request->valor_total,
            'valor_pago' => $request->valor_pago,
            'valor_a_pagar' => $request->valor_a_pagar,

            // Observações e comprovante
            'observacoes' => $request->observacoes,
            'comprovante' => $comprovantePath,
        ]);

        // Redireciona com mensagem de sucesso
        return redirect()->back()->with('success', 'Venda adicionada com sucesso!');
    }

}
