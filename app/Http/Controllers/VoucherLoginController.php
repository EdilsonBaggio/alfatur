<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VoucherLoginController extends Controller
{
    public function showLogin()
    {
        return view('voucher.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
            'nome' => 'required|string',
        ]);

        // Exemplo de código: "ALF - 15111"
        preg_match('/\d+$/', $request->codigo, $matches);
        $vendaId = $matches[0] ?? null;

        $venda = Venda::find($vendaId);

        if ($venda && strcasecmp(explode(' ', $venda->nome)[0], $request->nome) === 0) {
            Session::put("voucher_access.$vendaId", true);
            return redirect()->route('voucher.show', ['id' => $vendaId]);
        }

        return redirect()->back()->with('error', 'Código ou nome inválido.');
    }

    public function showVenda($id)
    {
        $venda = Venda::with('tours', 'pagamentos')->findOrFail($id);

        // Ajustes para compatibilidade com o HTML
        $tours = $venda->tours; // já vem do with()
        $pagamentos = $venda->pagamentos; // se você tiver esse relacionamento definido

        return view('voucher.show', [
            'venda' => $venda,
            'tours' => $tours,
            'pagamentos' => $pagamentos,
            'viaje' => $venda, // usado no HTML como sinônimo de venda
        ]);
    }

}
 