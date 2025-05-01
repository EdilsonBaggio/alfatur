<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Tour;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use App\Mail\VoucherFinancieroMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function gerarVoucherPDF($id)
    {
        $venda = Venda::findOrFail($id);
        $viaje = $venda;
        $tours = Tour::where('venda_id', $venda->id)->get();
        $pagamentos = Pagamento::where('venda_id', $venda->id)->get();

        // Gerar o conteúdo do PDF em memória
        $pdf = Pdf::loadView('email.venda', compact('venda', 'viaje', 'tours', 'pagamentos'))->output();

        // Enviar e-mail com o PDF anexado
        Mail::to($venda->email)->send(new VoucherFinancieroMail($venda, $viaje, $tours, $pagamentos, $pdf));
        

        return back()->with('success', '¡Cupón generado y enviado exitosamente!');
    }

    public function reenviarDadosLogin($id)
    {
        $venda = Venda::findOrFail($id);

        // Reconstruir o login conforme sua regra: ID + primeiro nome
        $primeiroNome = explode(' ', trim($venda->nome))[0];
        $usuario = 'ALF-' . $venda->id . strtolower($primeiroNome); // ou só $venda->id . $primeiroNome
        $senha = 'senha123'; // recupere de onde salvou originalmente

        if ($venda->email) {
            \Mail::to($venda->email)->send(new \App\Mail\VoucherConfirmadoMail($venda, $usuario, $senha));
        }

        return back()->with('success', 'Dados de login reenviados com sucesso!');
    }

}
