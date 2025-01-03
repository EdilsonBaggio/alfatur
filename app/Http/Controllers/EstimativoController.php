<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Tour;
use Carbon\Carbon;

class EstimativoController extends Controller
{
    public function index(Request $request)
    {
        // Obtém a data inicial passada pelo usuário ou usa a data atual
        $startDate = $request->input('filterDate', Carbon::now()->format('Y-m-d'));  // Data do filtro ou data atual
        
        // Garante que a data seja no formato correto e sem horário
        $startDate = Carbon::parse($startDate)->startOfDay();  // Início do dia
        $endDate = $startDate->copy()->addDays(90)->endOfDay(); // Final do dia após 14 dias

        // Busca os tours com dados vinculados à venda dentro do intervalo de 14 dias
        $tours = Tour::with('venda')
            ->whereBetween('data_tour', [$startDate, $endDate])  // Utiliza whereBetween para filtrar entre o intervalo
            ->orderBy('data_tour')
            ->get();

        // Agrupa os tours por data (formato alterado para 'Y-m-d' para consistência)
        $groupedTours = $tours->groupBy(function ($tour) {
            return Carbon::parse($tour->data_tour)->format('Y-m-d'); // Agrupa por data no formato 'Y-m-d'
        });

        // Retorna a view com os dados e a data de filtro
        return view('estimativo.index', compact('groupedTours', 'startDate'));
    }
}
