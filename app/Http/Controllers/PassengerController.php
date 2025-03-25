<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passenger;

class PassengerController extends Controller
{
    // Cadastrar passageiros
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venda_id' => 'required|exists:vendas,id',
            'passengers' => 'required|array',
            'passengers.*.passport' => 'nullable|string',
            'passengers.*.name' => 'required|string',
            'passengers.*.phone' => 'nullable|string',
            'passengers.*.nationality' => 'nullable|string',
        ]);

        $passengers = [];

        foreach ($validated['passengers'] as $passengerData) {
            $passengers[] = Passenger::create(array_merge($passengerData, [
                'venda_id' => $validated['venda_id']
            ]));
        }

        return response()->json([
            'message' => 'Passageiros cadastrados com sucesso!',
            'data' => $passengers
        ], 201);
    }

    // Buscar passageiros pelo ID da venda
    public function getPassengers($venda_id)
    {
        $passengers = Passenger::where('venda_id', $venda_id)->get();

        if ($passengers->isEmpty()) {
            return response()->json(['message' => 'Nenhum passageiro encontrado.'], 200);
        }

        return response()->json($passengers, 200);
    }

    // Remover passageiro pelo ID
    public function destroy($id)
    {
        $passenger = Passenger::find($id);
    
        if (!$passenger) {
            return response()->json(['message' => 'Passageiro não encontrado.'], 404);
        }
    
        $passenger->delete();
    
        return response()->json(['message' => 'Passageiro removido com sucesso!']);
    }
    
}
