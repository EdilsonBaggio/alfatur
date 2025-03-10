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

        $query = Logistica::select(
            'logistics.id',
            'logistics.venda_id',
            'logistics.data',
            'logistics.hora',
            'logistics.nome',         
            'logistics.tour',
            'logistics.pax_total',
            'logistics.endereco',
            'logistics.hotel',
            'logistics.estado_pagamento',
            'logistics.telefone',
            'logistics.vendedor',     
            'logistics.valor_total',
            'logistics.valor_pago',
            'logistics.valor_a_pagar',
            'logistics.condutor',     
            'logistics.guia',         
            'logistics.voucher',
            'logistics.observacao',
            'logistics.conferido',
            'logistics.status'
        );

        if ($estado !== 'Todos') {
            $query->where('logistics.status', $estado);
        }

        $viajes = $query->get();

        foreach ($viajes as $viaje) {
            // Busca a venda associada a essa logística
            $venda = Venda::find($viaje->venda_id);
            
            // Busca todos os pagamentos vinculados à venda e soma os valores recebidos
            $totalPago = Pagamento::where('venda_id', $viaje->venda_id)->sum('valor_recebido');
        
            // Converte valores para float para evitar erros de precisão
            $totalVoucher = isset($venda->valor_total) ? floatval($venda->valor_total) : 0.0;
            $totalPago = floatval($totalPago);
            $total = (int) str_replace('.', '', (string) $totalPago);

        
            // Calcula o total pendente corretamente
            $viaje->total_pendiente = round(($totalVoucher - $total) * 100, 0); // Multiplica por 100 e arredonda
            
            // Depuração (remova depois de testar)
            \Log::info("Total Voucher: {$totalVoucher}, Total Pago: {$total}, Total Pendiente: {$viaje->total_pendiente}");
        }
        
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
    
        // Busca todos os pagamentos vinculados à venda e soma os valores recebidos
        $totalPago = Pagamento::where('venda_id', $viaje->id)->sum('valor_recebido');
    
        // Converte valores para float para evitar erros de precisão
        $totalVoucher = isset($viaje->valor_total) ? floatval($viaje->valor_total) : 0.0;
        $totalPago = floatval($totalPago);
        $total = (int) str_replace('.', '', (string) $totalPago);
    
        // Calcula o total pendente corretamente
        $viaje->total_pendiente = round(($totalVoucher - $total) * 100, 0); // Multiplica por 100 e arredonda
        
        // Depuração (remova depois de testar)
        \Log::info("Total Voucher: {$totalVoucher}, Total Pago: {$total}, Total Pendiente: {$viaje->total_pendiente}");
    
        // Garante que os relacionamentos sempre sejam coleções
        $pagamentos = $viaje->pagamentos ?? collect();
        $tours = $viaje->tours ?? collect();
    
        return view('voucher_modal_content', compact('viaje', 'tours', 'pagamentos'));
    }
    
}
