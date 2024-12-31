<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\User;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendasController extends Controller
{

    public function index()
    {
        // Buscar as vendas com os tours relacionados e filtrar por user_id
        $vendas = Venda::with('tours')->where('user_id', Auth::id())->get();

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

            // Tours dinâmicos
            'tour.*' => 'required|string',
            'data_tour.*' => 'required|date',
            'pax_adulto.*' => 'required|integer',
            'preco_adulto.*' => 'required|numeric',
            'pax_infantil.*' => 'nullable|integer',
            'preco_infantil.*' => 'nullable|numeric',

            // Pagamento
            'estado_pagamento' => 'required|string',
            'forma_pagamento' => 'required|string',
            'data_pagamento' => 'required|date',
            'valor_total' => 'required|numeric',
            'valor_pago' => 'required|numeric',
            'valor_a_pagar' => 'required|numeric',

            // Observações e comprovante
            'observacoes' => 'nullable|string',
            'comprovante' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // Processa o upload do comprovante, se fornecido
        $comprovantePath = null;
        if ($request->hasFile('comprovante')) {
            $comprovantePath = $request->file('comprovante')->store('comprovantes', 'public');
        }

        // Criar Venda
        $venda = Venda::create([
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

        // Salva os tours associados
        foreach ($request->tour as $index => $tour) {
            $venda->tours()->create([
                'tour' => $tour,
                'data_tour' => $request->data_tour[$index],
                'pax_adulto' => $request->pax_adulto[$index],
                'preco_adulto' => $request->preco_adulto[$index],
                'pax_infantil' => $request->pax_infantil[$index] ?? null,
                'preco_infantil' => $request->preco_infantil[$index] ?? null,
            ]);
        }

        // Redireciona com mensagem de sucesso
        return redirect()->back()->with('success', 'Venda adicionada com sucesso!');
    }

}
