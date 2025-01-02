<?php

namespace App\Http\Controllers;

use App\Models\TourPlaces;
use Illuminate\Http\Request;

class TourController extends Controller
{
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