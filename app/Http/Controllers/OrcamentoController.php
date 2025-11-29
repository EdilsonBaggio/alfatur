<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orcamento;
use App\Models\OrcamentoTour;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OrcamentoController extends Controller
{

    public function lista()
    {
        $orcamentos = Orcamento::with('tours')->where('user_id', Auth::id())->get();
        return view('orcamentos.lista', compact('orcamentos'));
    }

    public function store(Request $request)
    {
        // Validação com mensagem personalizada
        $validator = Validator::make($request->all(), [
            'user_id'         => 'required|integer|exists:users,id',
            'vendedor'        => 'required|string|max:255',
            'nome'            => 'required|string|max:255',
            'telefone'        => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'valor_total'     => 'required|numeric|min:0',

            'tour'            => 'required|array|min:1',
            'tour.*'          => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Llene los campos requeridos para enviar la cotización.',
                'errors' => $validator->errors()
            ], 422);
        }

        $orcamento = Orcamento::create($request->only([
            'user_id', 'vendedor', 'nome', 'telefone', 'email',
            'hotel', 'zona', 'direcao_hotel', 'habitacao',
            'pais_origem', 'idioma', 'valor_total', 'observacoes'
        ]));

        // Confirma que os arrays existem
        $tours = $request->input('tour', []);
        $datas = $request->input('data_tour', []);
        $pax_adultos = $request->input('pax_adulto', []);
        $preco_adultos = $request->input('preco_adulto', []);
        $pax_infantis = $request->input('pax_infantil', []);
        $preco_infantis = $request->input('preco_infantil', []);

        for ($i = 0; $i < count($tours); $i++) {
            OrcamentoTour::create([
                'orcamento_id'    => $orcamento->id,
                'tour'            => $tours[$i],
                'data_tour'       => $datas[$i] ?? null,
                'pax_adulto'      => $pax_adultos[$i] ?? 0,
                'preco_adulto'    => $preco_adultos[$i] ?? 0,
                'pax_infantil'    => $pax_infantis[$i] ?? 0,
                'preco_infantil'  => $preco_infantis[$i] ?? 0,
            ]);
        }

        $telefone = preg_replace('/[^0-9]/', '', $orcamento->telefone);
        $cotacao = 0.006;

        $mensagem = "*Orçamento Turismo Chile*\n\n";
        $mensagem .= "*Vendedor:* {$orcamento->vendedor}\n";
        $mensagem .= "*Cliente:* {$orcamento->nome}\n";
        $mensagem .= "*Telefone:* {$orcamento->telefone}\n";
        $mensagem .= "*Email:* {$orcamento->email}\n";
        $mensagem .= "*Hotel:* {$orcamento->hotel}\n";
        $mensagem .= "*Zona:* {$orcamento->zona}\n";
        $mensagem .= "*Direção Hotel:* {$orcamento->direcao_hotel}\n";
        $mensagem .= "*Habitação:* {$orcamento->habitacao}\n";
        $mensagem .= "*País de Origem:* {$orcamento->pais_origem}\n";
        $mensagem .= "*Idioma:* {$orcamento->idioma}\n";

        $valorTotalPesos = $orcamento->valor_total;
        $valorTotalReais = number_format($valorTotalPesos * $cotacao, 2, ',', '.');
        $mensagem .= "*Observações:* {$orcamento->observacoes}\n\n";

        $mensagem .= "*Tours Selecionados:*\n";
        for ($i = 0; $i < count($tours); $i++) {
            $precoAdultoReais = number_format(($preco_adultos[$i] ?? 0) * $cotacao, 2, ',', '.');
            $precoInfantilReais = number_format(($preco_infantis[$i] ?? 0) * $cotacao, 2, ',', '.');

            $mensagem .= "\n *Tour:* {$tours[$i]}\n";
            $mensagem .= " *Data:* " . ($datas[$i] ?? '-') . "\n";
            $mensagem .= " *Adultos:* " . ($pax_adultos[$i] ?? 0) . " x CLP " . ($preco_adultos[$i] ?? 0) . " (R$ {$precoAdultoReais})\n";
            $mensagem .= " *Infantis:* " . ($pax_infantis[$i] ?? 0) . " x CLP " . ($preco_infantis[$i] ?? 0) . " (R$ {$precoInfantilReais})\n";
        }
        $mensagem .= "*Valor Total:* CLP {$valorTotalPesos} (R$ {$valorTotalReais})\n";

        $mensagem = mb_convert_encoding($mensagem, 'UTF-8', 'UTF-8');
        $mensagemUrl = rawurlencode($mensagem);
        $link = "https://wa.me/55{$telefone}?text={$mensagemUrl}";

        return response()->json([
            'success' => true,
            'message' => 'Orçamento criado e mensagem de WhatsApp pronta para envio.',
            'whatsapp_link' => $link,
            'data' => $orcamento->load('tours'),
        ]);
    }

    public function destroy($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->delete();

        return redirect()->back()->with('success', 'Orçamento excluído com sucesso.');
    }

}
