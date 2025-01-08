<?php

namespace App\Http\Controllers;

use App\Models\Logistica;
use App\Models\Venda;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class LogisticaController extends Controller
{
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
        $users = User::whereIn('role', ['guia', 'condutor'])->get();

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
            $logistica->guia = User::find($request->guia_id)->name;
            $logistica->condutor = User::find($request->condutor_id)->name;
            $logistica->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Atribuição realizada com sucesso!',
            'guia_name' => User::find($request->guia_id)->name,
            'condutor_name' => User::find($request->condutor_id)->name
        ]);
    }
}