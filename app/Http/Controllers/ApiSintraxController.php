<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiSintraxController extends Controller
{
    public $url;

    public function __construct(){
        $this->url = env('SINTRAX_URL');
    }

    public function sintraxReturn(array $grupos, int $pktId)
    {
        try{
            $response = Http::withOptions([
                'decode_content' => false,
            ])->post("{$this->url}/ultimaposicao", [
                'login' => env('SINTRAX_LOGIN'),
                'cgruChave' => env('SINTRAX_CGRU'),
                'cusuChave' => env('SINTRAX_CUSU'),
                'pktId' => "$pktId",
            ]);

            $posicoes = $response->json();

            if($posicoes){
                $posicoes = $posicoes['posicoes'];

                $mensagens = [];

                foreach($grupos as $grupo){
                    foreach($posicoes as $resultado){
                        $same = $this->compare($grupo['placa'], $resultado['cveiPlaca']);

                        if($same){
                            $mensagens[$grupo['grupo_cliente']][] = [
                                'placa'=>$resultado['cveiPlaca'],
                                'data'=>Carbon::createFromFormat('d/m/Y H:i:s',$resultado['llpoDataGps'])->subHours(3)->format('d/m/Y H:i:s'),
                                'nome_rua'=> isset($resultado['truaNome']) ? $resultado['truaNome']:'-',
                                'nome_cidade'=>isset($resultado['tmunNome']) ? $resultado['tmunNome']:'-',
                                'abrev_estado'=>isset($resultado['testAbrev']) ? $resultado['testAbrev']:'-',
                                'velocidade'=>isset($resultado['llpoVelocidade']) ? $resultado['llpoVelocidade']:'-',
                                'descricao'=>isset($resultado['tmodDescricao']) ? $resultado['tmodDescricao']:'-',
                                'ign'=>isset($resultado['llpoIgn']) ? $resultado['llpoIgn']:'-',
                                'pktId'=>$resultado['pktId']
                            ];

                            break;
                        }
                    }
                }

                return $mensagens;
            }

            return [];
        }catch(\Exception $e){
            Log::error($e);
            return [];
        }
    }

    public function compare($placa1, $placa2) {
        // $pattern = '/^[A-Z]{3}-\d{4}/';
        // $placa1 = $this->extract($placa1);
        // $placa2 = $this->extract($placa2);

        return trim($placa1) === trim($placa2);
    }

    // Desabilitado para que a comparação seja estrita
    // public function extract($texto){
    //     $pattern = '/\b[A-Z]{3}-\d{1}[A-Z0-9]{3}\b|\b[A-Z]{3}-\d{4}\b|\b[A-Z]{2}-\d{4}\b/';

    //     preg_match_all($pattern, $texto, $matches);    

    //     return $matches[0] ?? null;
    // }
}
