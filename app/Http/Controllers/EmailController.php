<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Tour;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use App\Mail\VoucherFinancieroMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function enviarEmail($id)
    {

        // Buscar a venda pelo ID
        $viaje = Venda::findOrFail($id);

        // Buscar a venda existente pelo ID
        $venda = Venda::findOrFail($id);

        // Buscar os tours associados a essa venda
        $tours = Tour::where('venda_id', $venda->id)->get();

        // Buscar os pagamentos associados à venda
        $pagamentos = Pagamento::where('venda_id', $viaje->id)->get();

        // Enviar o e-mail com o voucher
        Mail::to($venda->email)->send(new VoucherFinancieroMail($venda, $viaje, $tours, $pagamentos));

        // Retornar com mensagem de sucesso
        return redirect()->back()->with('success', '¡Cupón enviado exitosamente!');
    }
}
