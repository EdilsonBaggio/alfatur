<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EstimativoController extends Controller
{
    public function index(Request $request)
    {
        // Obtém a data inicial passada pelo usuário ou usa a data atual
        $startDate = $request->input('filterDate', Carbon::now()->format('Y-m-d'));  
        
        // Garante que a data seja no formato correto e sem horário
        $startDate = Carbon::parse($startDate)->startOfDay();  
        $endDate = $startDate->copy()->addDays(14)->endOfDay(); 

        // Busca os tours com dados vinculados à venda e filtra pelo user_id
        $tours = Tour::with('venda')
            ->whereBetween('data_tour', [$startDate, $endDate]) // Intervalo de 14 dias
            ->whereHas('venda', function ($query) { // Filtro pela tabela vendas
                $query->where('user_id', Auth::id());
            })
            ->orderBy('data_tour')
            ->get();

        // Agrupa os tours por data
        $groupedTours = $tours->groupBy(function ($tour) {
            return Carbon::parse($tour->data_tour)->format('Y-m-d'); 
        });

        // Retorna a view com os dados e a data de filtro
        return view('estimativo.index', compact('groupedTours', 'startDate'));
    }
}
