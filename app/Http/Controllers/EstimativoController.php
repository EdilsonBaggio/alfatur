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
        // Obtém as datas fornecidas no formulário ou define um intervalo padrão
        $startDate = $request->input('filterDateStart') ?? Carbon::now()->format('Y-m-d');
        $endDate = $request->input('filterDateEnd') ?? Carbon::now()->addDays(30)->format('Y-m-d');

        // Converte as datas para objetos Carbon e aplica horários
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Busca os tours vinculados à venda do usuário autenticado no intervalo especificado
        $tours = Tour::with('venda')
            ->whereBetween('data_tour', [$startDate, $endDate])
            ->whereHas('venda', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('data_tour')
            ->get();

        // Agrupa os tours por data
        $groupedTours = $tours->groupBy(function ($tour) {
            return Carbon::parse($tour->data_tour)->format('Y-m-d');
        });

        // Retorna a view com os dados e as datas de filtro
        return view('estimativo.index', compact('groupedTours', 'startDate', 'endDate'));
    }
}
