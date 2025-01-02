<?php

namespace App\Http\Controllers;

use App\Models\TourPlaces;
use Illuminate\Http\Request;

class TourController extends Controller
{

    // Exibe a lista de tours
    public function index()
    {
        // Busca os tours ativos e inativos separadamente
        $activeTours = TourPlaces::where('status', 0)->get();
        $inactiveTours = TourPlaces::where('status', 1)->get();

        // Retorna a view com os dados separados
        return view('tours.list', compact('activeTours', 'inactiveTours'));
    }

    // Formulário para editar um tour
    public function edit($id)
    {
        $tour = TourPlaces::findOrFail($id);
        return view('tours.edit', compact('tour'));
    }

    // Atualiza um tour existente
    // Atualizar Tour
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'min_price' => 'required|numeric',
            'cost' => 'required|numeric',
            'child_price' => 'required|numeric',
            'child_cost' => 'required|numeric',
        ]);

        $tour = TourPlaces::findOrFail($id);

        // Atualiza os dados
        $tour->update([
            'name' => $request->name,
            'price' => $request->price,
            'min_price' => $request->min_price,
            'cost' => $request->cost,
            'child_price' => $request->child_price,
            'child_cost' => $request->child_cost,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('tours.list')->with('success', 'Tour atualizado com sucesso!');
    }

    public function create()
    {
        return view('tours.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'min_price' => 'required|numeric',
            'cost' => 'required|numeric',
            'child_price' => 'required|numeric',
            'child_cost' => 'required|numeric',
        ]);

        TourPlaces::create($request->all());
        return redirect()->route('tours.create')->with('success', 'Tour criado com sucesso!');
    }
}