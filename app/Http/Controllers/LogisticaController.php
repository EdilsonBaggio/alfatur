<?php

namespace App\Http\Controllers;

use App\Models\Logistica;
use App\Models\Venda;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogisticsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class LogisticaController extends Controller
{
    public function getRoleAttribute($value)
    {
        return strtolower($value);
    }

    public function index(Request $request)
    {
        // Definir a data padrão para amanhã
        $defaultDate = \Carbon\Carbon::now()->addDay()->format('Y-m-d');

        // Obter a data do filtro ou usar a padrão (amanhã)
        $filterDate = $request->input('dateFilter', $defaultDate);

        // Garantir que a data esteja no formato 'Y-m-d'
        $filterDate = \Carbon\Carbon::parse($filterDate)->format('Y-m-d');

        // Filtrar logísticas pela data exata
        $logistics = Logistica::with(['venda', 'user'])
            ->whereDate('data', $filterDate)
            ->get();

        // Buscar usuários com papel de guia ou condutor
        $users = User::whereIn('role', ['guia', 'condutor', 'Agencia Externa'])->get();

        // Obter todas as vendas
        $vendas = Venda::all();

        // Retornar a view com os dados necessários
        return view('logistica.index', compact('logistics', 'vendas', 'users', 'filterDate'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'logistics_ids' => 'required|array|min:1',
            'logistics_ids.*' => 'exists:logistics,id',
            'guia_id' => 'required|exists:users,id',
            'condutor_id' => 'required|exists:users,id',
        ]);

        $logistics = Logistica::whereIn('id', $request->logistics_ids)->get();

        foreach ($logistics as $logistica) {
            $logistica->guia = User::find($request->guia_id)->id;
            $logistica->condutor = User::find($request->condutor_id)->id;
            $logistica->hora = Carbon::now()->format('H:i:s'); // Atualiza com a hora atual
            $logistica->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Atribuição realizada com sucesso!',
            'guia_name' => User::find($request->guia_id)->name,
            'condutor_name' => User::find($request->condutor_id)->name
        ]);
    }

    public function hora(Request $request)
    {
        $request->validate([
            'logistics_ids' => 'required|array|min:1',
            'logistics_ids.*' => 'exists:logistics,id',
            'guia_id' => 'required|string',
            'condutor_id' => 'required|string',
            'hora' => 'required|date_format:H:i',
        ]);

        $logistics = Logistica::whereIn('id', $request->logistics_ids)->get();

        foreach ($logistics as $logistica) {
            $logistica->guia = $request->guia_id;
            $logistica->condutor = $request->condutor_id;
            $logistica->hora = $request->hora; // Atualiza a hora
            $logistica->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Atribuição realizada com sucesso!',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $logisticsIds = $request->logistics_ids;
        $logistics = Logistics::whereIn('id', $logisticsIds)->get();
        
        $pdf = Pdf::loadView('logistics.pdf', compact('logistics'));
        return $pdf->download('logistics.pdf');
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados enviados
        $request->validate([
            'tour' => 'required|string|max:255',
            // 'data' => 'required|date',
            'hora' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'pax_total' => 'required|integer',
            'valor_total' => 'nullable|numeric',
            'valor_a_pagar' => 'nullable|numeric',
            'hotel' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:255',
            'conferido' => 'nullable|boolean',
        ]);

        // Busca a logística pelo ID
        $logistica = Logistica::findOrFail($id);

        // Atualiza os dados
        $logistica->update([
            'tour' => $request->input('tour'),
            // 'data' => $request->input('data'),
            'hora' => $request->input('hora'),
            'nome' => $request->input('nome'),
            'pax_total' => $request->input('pax_total'),
            'valor_total' => $request->input('valor_total'),
            'valor_a_pagar' => $request->input('valor_a_pagar'),
            'hotel' => $request->input('hotel'),
            'telefone' => $request->input('telefone'),
            'conferido' => $request->input('conferido', 0),
        ]);

        // Retorna resposta JSON ou mensagem de sucesso
        return response()->json(['success' => true, 'message' => 'Logística atualizada com sucesso!']);
    }

    public function assignagencia(Request $request)
    {
        $request->validate([
            'logistics_ids' => 'required|array|min:1',
            'logistics_ids.*' => 'exists:logistics,id',
            'agencia_id' => 'required|exists:users,id',
        ]);

        $logistics = Logistica::whereIn('id', $request->logistics_ids)->get();
        
        foreach ($logistics as $logistica) {
            $logistica->agencia = User::find($request->agencia_id)->id;
            $logistica->hora = Carbon::now()->format('H:i:s'); // Atualiza com a hora atual
            $logistica->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Atribuição realizada com sucesso!',
            'agencia_name' => User::find($request->agencia_id)->name,
        ]);
    }
}
