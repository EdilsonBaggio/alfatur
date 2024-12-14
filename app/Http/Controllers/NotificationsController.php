<?php

namespace App\Http\Controllers;

use App\Models\VincularVeiculos as Veiculos;
use App\Models\ConfigurarAlertas as Alertas;
use App\Models\Historico;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    protected $alertas, $veiculos, $alertas_id, $pktId;

    public function __construct()
    {
        $alerta = $this->getAlertas();
        $this->veiculos = $this->getVeiculos();

        $this->alertas = $alerta['alertas'];
        $this->alertas_id = $alerta['ids'];
    }

    private function getAlertas()
    {
        try{
            // Subconsulta para obter os IDs únicos com base em `placa`
            $subquery = Alertas::select(DB::raw('MIN(id) as id'))->where('ativo', 1)->groupBy('placa')->pluck('id');

            // Consulta principal para obter os registros completos com base nos IDs únicos
            $alertas = Alertas::whereIn('id', $subquery)->get();


            return ['alertas'=>$alertas,'ids'=>$subquery];
        }catch(\Exception $e){
            Log::error('Error (getAlertas): '.$e->getMessage());
            return ['alertas'=>null,'ids'=>[]];
        }
    }

    private function getVeiculos()
    {
        try{
            return Veiculos::all();
        }catch(\Exception $e){
            Log::error('Error (getVeiculos): '.$e->getMessage());
            return null;
        }
    }

   public function sendNotification():string
   {
        $historico = Historico::whereIn('alerta_id',$this->alertas_id)->orderBy('pktId', 'desc')->first('pktId');

        if($historico){
            $this->pktId = $historico->pktId;
        }else{
            $this->pktId = 0;
        }

        $alertas = $this->verifyAlerts();
        $grupos = $this->getGroups($alertas); 

        $api = new ApiSintraxController;
        $mensagens = $api->sintraxReturn($grupos, $this->pktId);


        if(empty($mensagens)){
            return 'Não existem novas posições para serem enviadas.';
        }else{
            $pktId =  array_reduce($mensagens, function ($result, $itens) {
                foreach($itens as $item){
                    $result[$item['placa']] = trim($item['pktId']);
                }
                return $result;
            }, []);

            $onecode = new OneCodeController;
            $onecode->sendNotifications($mensagens);

            if($onecode){
                return $this->saveHistory($alertas, $pktId);
            }else{
                return 'Ocorreu um erro ao tentar enviar as notificações.';
            }
        }

        
   }

   protected function verifyAlerts():array
   {
        try{ 
            $historico = Historico::whereIn('alerta_id',$this->alertas_id)->orderBy('created_at', 'desc')->first();
            

            if(empty($historico) == false){
                $historico = $historico->pluck('created_at','alerta_id');
            }

            $alertas = array_filter($this->alertas->toArray(), function($alerta) use ($historico){
                 // Verifique se há histórico para o alerta atual
                if (isset($historico[$alerta['id']])) {
                    // Obtenha a última notificação para o alerta atual
                    $ultimoHistoricoData = Carbon::parse($historico[$alerta['id']]);

                    // Verifique se o tempo atual está dentro do intervalo estipulado
                    $intervaloMinutos = $alerta['tempo']; // Tempo de notificação em minutos

                    $tempoAtual = Carbon::now();
                    $tempoLimite = $tempoAtual->subMinutes($intervaloMinutos);

                    return $tempoLimite->greaterThan($ultimoHistoricoData);
                }

                return true;
            });

            return $alertas;
        }catch(\Exception $e){
            Log::error('Error (verifyAlerts): '.$e->getMessage());
            return [];
        }
   }

   protected function getGroups($alertas):array
   {
        $alertas = array_reduce($alertas, function ($result, $item) {
            $result[] = trim($item['placa']);
            return $result;
        }, []);

        if($this->veiculos != null){
            $veiculos = $this->veiculos->toArray();
            
            $veiculos = array_filter($veiculos, function($veiculo) use ($alertas){
                return in_array(trim($veiculo['placa']), $alertas);
            });
    
            return $veiculos;
        }

        return [];
   }

   public function saveHistory($alertas, $sintrax):string
   {
        $data = [];
        DB::beginTransaction();
        try{    
            DB::disableQueryLog();

            foreach($alertas as $alerta){
                if(isset($sintrax[$alerta['placa']])){
                    $pktId = $sintrax[$alerta['placa']];

                    $data[] = [
                        'alerta_id'=>$alerta['id'], 
                        'created_at'=>Carbon::now(),
                        'pktId'=>$pktId
                    ];
                }
            }

            DB::table('historicos')->insert($data);

            DB::commit();

            return 'Notificações enviadas e salvas com sucesso!';
        }catch(\Exception $e){
            DB::rollback();

            Log::error('Error (saveHistory): '.$e->getMessage());

            return 'Notificações enviadas, porém ocorreu um erro ao tentar salvar o histórico.';
        }
   }
}
