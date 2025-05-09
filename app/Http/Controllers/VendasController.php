<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\User;
use App\Models\Tour;
use App\Models\TourPlaces;
use App\Models\Logistica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\VoucherConfirmadoMail;
use App\Models\Pagamento;
use App\Models\Orcamento;
use Illuminate\Support\Facades\Mail;

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
        $tourPlaces = TourPlaces::where('status', '!=', 1)->pluck('name', 'id');
        return view('vendas.create', compact('tourPlaces'));
    }

    // Define o método normalizeCurrency como privado
    private function normalizeCurrency($value) 
    {
        // Remove pontos e vírgulas, e converte o valor para string sem separadores
        return str_replace(['.', ','], '', $value);
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
            // Move o arquivo para a pasta 'uploads' na raiz pública
            $file = $request->file('comprovante');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);

            // Salva no banco apenas 'uploads/arquivo.extensão'
            $comprovantePath = 'uploads/' . $fileName;
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
            'valor_total' => $this->normalizeCurrency($request->valor_total),
            'valor_pago' => $this->normalizeCurrency($request->valor_pago),
            'valor_a_pagar' => $this->normalizeCurrency($request->valor_a_pagar),

            // Observações e comprovante
            'observacoes' => $request->observacoes,
            'comprovante' => $comprovantePath,
        ]);

        $venda->pagamentos()->create([
            'forma_pagamento' => $request->forma_pagamento,
            'data_pagamento' => $request->data_pagamento,
            'valor_pago' => $request->valor_pago,
            'valor_a_pagar' => $request->valor_a_pagar,
            'valor_recebido' => $request->valor_recebido,
            'estado_pagamento' => $request->estado_pagamento,
            'comprovante' => $comprovantePath,
        ]);

        // Salva os tours associados
        foreach ($request->tour as $index => $tour) {
            $createdTour = $venda->tours()->create([
                'tour' => $tour,
                'data_tour' => $request->data_tour[$index],
                'pax_adulto' => $request->pax_adulto[$index],
                'preco_adulto' => $request->preco_adulto[$index],
                'pax_infantil' => $request->pax_infantil[$index] ?? null,
                'preco_infantil' => $request->preco_infantil[$index] ?? null,
            ]);

            // Criar registros na tabela logística para cada tour relacionado
            Logistica::create([
                'venda_id' => $venda->id,
                'data' => $createdTour->data_tour, // Data do tour
                'hora' => $createdTour->hora ?? now()->format('H:i'), // Hora do tour (padrão: hora atual, se não fornecido)
                'nome' => $venda->nome, // Nome do cliente
                'tour' => $createdTour->tour,
                'pax_total' => $createdTour->pax_adulto + ($createdTour->pax_infantil ?? 0), // Total de passageiros
                'endereco' => $venda->zona, // Endereço ou zona
                'hotel' => $venda->hotel, // Nome do hotel
                'estado_pagamento' => $venda->estado_pagamento, // Estado do pagamento
                'telefone' => $venda->telefone, // Telefone
                'vendedor' => $venda->vendedor ?? auth()->user()->name, // Vendedor (padrão: usuário autenticado)
                'valor_total' => $venda->valor_total,
                'condutor' => $createdTour->motorista ?? null, // Motorista (opcional)
                'guia' => $createdTour->guia ?? null, // Guia (opcional)
                'valor_pago' => $venda->valor_pago, // Valor pago
                'valor_a_pagar' => $venda->valor_a_pagar, // Valor a pagar
                'voucher' => $venda->id ?? 'N/A', // Voucher (padrão: N/A)
                'observacao' => $venda->observacao ?? null, // Observação (opcional)
                'conferido' => $request->conferido ?? null, // Conferido (opcional)
                'status' => 'Reservado', // Pendente (opcional)
            ]);     
        }

        // Obtenha os tours relacionados à venda
        $tours = $venda->tours;

        if ($venda->email) {
            \Mail::to($venda->email)->send(new \App\Mail\VoucherConfirmadoMail($venda));
        }

        // Redireciona com mensagem de sucesso
        return response()->json(['message' => 'Venda criada com sucesso']);
        // return redirect()->route('vendas.list')->with('success', 'Venda criada com sucesso!');

    }

    public function edit($id)
    {
        // Busca a venda pelo ID e carrega os tours relacionados
        $venda = Venda::with('tours')->findOrFail($id);
        
        // Lista de locais disponíveis para tours
        $tourPlaces = TourPlaces::where('status', '!=', 1)->pluck('name', 'id');

        return view('vendas.editar', compact('venda', 'tourPlaces'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos campos
        $request->validate([
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

            'tour.*' => 'required|string',
            'data_tour.*' => 'required|date',
            'pax_adulto.*' => 'required|integer',
            'preco_adulto.*' => 'required|numeric',
            'pax_infantil.*' => 'nullable|integer',
            'preco_infantil.*' => 'nullable|numeric',

            'estado_pagamento' => 'required|string',
            'forma_pagamento' => 'required|string',
            'data_pagamento' => 'required|date',
            'valor_total' => 'required|numeric',
            'valor_pago' => 'required|numeric',
            'valor_a_pagar' => 'required|numeric',

            'observacoes' => 'nullable|string',
            'comprovante' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $venda = Venda::findOrFail($id);

        // Processa o upload do novo comprovante, se fornecido
        if ($request->hasFile('comprovante')) {
            $file = $request->file('comprovante');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $comprovantePath = 'uploads/' . $fileName;
        } else {
            $comprovantePath = $venda->comprovante;
        }

        // Atualiza os dados da venda
        $venda->update([
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

            'estado_pagamento' => $request->estado_pagamento,
            'forma_pagamento' => $request->forma_pagamento,
            'data_pagamento' => $request->data_pagamento,
            'valor_total' => $this->normalizeCurrency($request->valor_total),
            'valor_pago' => $this->normalizeCurrency($request->valor_pago),
            'valor_a_pagar' => $this->normalizeCurrency($request->valor_a_pagar),

            'observacoes' => $request->observacoes,
            'comprovante' => $comprovantePath,
        ]);

        // Atualiza os tours associados
        $venda->tours()->delete(); // Remove os tours antigos

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

        return redirect()->route('vendas.list')->with('success', 'Venda atualizada com sucesso!');
    }


    public function criarDeOrcamento(Request $request, $orcamentoId)
    {
        $orcamento = Orcamento::with('tours')->findOrFail($orcamentoId);

        // Cria uma nova venda a partir dos dados do orçamento
        $venda = Venda::create([
            'user_id' => auth()->id(),
            'vendedor' => auth()->user()->name,
            'nome' => $orcamento->nome,
            'telefone' => $orcamento->telefone,
            'email' => $orcamento->email,
            'hotel' => $orcamento->hotel,
            'zona' => $orcamento->zona,
            'direcao_hotel' => $orcamento->direcao_hotel,
            'habitacao' => $orcamento->habitacao,
            'pais_origem' => $orcamento->pais_origem,
            'idioma' => $orcamento->idioma,
            'estado_pagamento' => 'Pendiente',
            'forma_pagamento' => 'Efectivo en Van',
            'data_pagamento' => now()->toDateString(),
            'valor_total' => $orcamento->valor_total,
            'valor_pago' => 0,
            'valor_a_pagar' => 0,
            'status' => 'Reservado',
        ]);

        foreach ($orcamento->tours as $tour) {
            $createdTour = $venda->tours()->create([
                'tour' => $tour->tour,
                'data_tour' => $tour->data_tour,
                'pax_adulto' => $tour->pax_adulto,
                'preco_adulto' => $tour->preco_adulto,
                'pax_infantil' => $tour->pax_infantil,
                'preco_infantil' => $tour->preco_infantil,
            ]);

            Logistica::create([
                'venda_id' => $venda->id,
                'data' => $createdTour->data_tour,
                'hora' => $createdTour->hora ?? now()->format('H:i'),
                'nome' => $venda->nome,
                'tour' => $createdTour->tour,
                'pax_total' => $createdTour->pax_adulto + ($createdTour->pax_infantil ?? 0),
                'endereco' => $venda->zona,
                'hotel' => $venda->hotel,
                'estado_pagamento' => $venda->estado_pagamento,
                'telefone' => $venda->telefone,
                'vendedor' => $venda->vendedor,
                'valor_total' => $venda->valor_total,
                'condutor' => $createdTour->motorista ?? null,
                'guia' => $createdTour->guia ?? null,
                'valor_pago' => $venda->valor_pago,
                'valor_a_pagar' => $venda->valor_a_pagar,
                'voucher' => $venda->id,
                'observacao' => $venda->observacao ?? null,
                'conferido' => $request->conferido ?? null,
                'status' => $request->status ?? 'Reservado',
            ]);
        }

        // Obtenha os tours relacionados à venda
        $tours = $venda->tours;

        if ($venda->email) {
            \Mail::to($venda->email)->send(new \App\Mail\VoucherConfirmadoMail($venda));
        }

        $orcamento->delete();
        
        return redirect()->route('vendas.list', $venda->id);
    }
}
