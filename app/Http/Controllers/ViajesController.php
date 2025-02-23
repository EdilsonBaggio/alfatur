<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logistica;
use App\Models\Venda;
use App\Models\Pagamento;
use App\Models\Tour;

class ViajesController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->query('estado', 'Todos');

        $query = \App\Models\Logistica::select(
            'logistics.id',
            'logistics.venda_id',
            'logistics.data',
            'logistics.hora',
            'logistics.nome',         // Nome do cliente
            'logistics.tour',
            'logistics.pax_total',
            'logistics.endereco',
            'logistics.hotel',
            'logistics.estado_pagamento',
            'logistics.telefone',
            'logistics.vendedor',     // Vendedor
            'logistics.valor_total',
            'logistics.valor_pago',
            'logistics.valor_a_pagar',
            'logistics.condutor',     // Agora pega direto da tabela logistics
            'logistics.guia',         // Agora pega direto da tabela logistics
            'logistics.voucher',
            'logistics.observacao',
            'logistics.conferido',
            'logistics.status'
        );

        if ($estado !== 'Todos') {
            $query->where('logistics.status', $estado);
        }

        $viajes = $query->get();

        return view('viajes-full', compact('viajes', 'estado'));
    }

    public function updateStatus(Request $request, $id)
    {
        $logistica = Logistica::findOrFail($id);
        $logistica->status = $request->status;
        $logistica->hora = $request->hora;
        $logistica->save();

        return response()->json(['success' => true]);
    }

    public function getVendaDetails($id)
    {
        $viaje = Venda::with(['tours', 'pagamentos'])->find($id);

        if (!$viaje) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }

        // Pegando os pagamentos relacionados à venda
        $pagamentos = $viaje->pagamentos ?? [];
        // Pegando os tours relacionados à venda
        $tours = $viaje->tours;

        return view('voucher_modal_content', compact('viaje', 'tours', 'pagamentos'));
    }

}