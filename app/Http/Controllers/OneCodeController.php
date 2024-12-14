<?php

namespace App\Http\Controllers;

use App\Models\Grupos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneCodeController extends Controller
{
    public $url;
    public $token;

    public function __construct()
    {
        $token = env('ONECODE_TOKEN');
        $this->url = env('ONECODE_URL');
        $this->token = "Bearer $token";
    }


    public function getGruposToSave():void
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->get("{$this->url}/api/contacts?pageSize=1000000");

        $contacts = $response->json()['contacts'];

        $grupos = array_filter($contacts, function($value, $ley){
            return $value['isGroup'] == true;
        }, ARRAY_FILTER_USE_BOTH);

        $grupos = $this->saveGrupos($grupos);
    }

    public function getGruposByArray():array
    {
        try{
            $grupos = Grupos::all()->pluck('nome','id')->toArray();
            return $grupos;
        }catch(\Exception $e){
            Log::error('Error (getGruposByArray): '.$e->getMessage());
            return [];
        }
    }

    public function sendNotifications($mensagens):bool
    {
        try{
            $model = Grupos::whereIn('id', array_keys($mensagens))->get();

            foreach($model as $value){
                foreach($mensagens[$value['id']] as $mensagem){
                    //Criar lógica de verificação de posição do veículo com requisição externa
                
                    $mensagem_ = "{$mensagem['placa']}\n\nGPS: {$mensagem['data']}\n\n{$mensagem['nome_rua']}\n\n{$mensagem['nome_cidade']} - {$mensagem['abrev_estado']}\n\nVelocidade: {$mensagem['velocidade']}\n\nIgnicação Ligada: {$mensagem['ign']}";

                    Http::withHeaders([
                        'Authorization' => $this->token,
                    ])->post("{$this->url}/api/send/{$value['numero']}",[
                        'body' => $mensagem_ ,
                        'connectionFrom' => 0,
                        'ticketStrategy' => 'create',
                    ]);
                }
            }
    
            return true;
        }catch(\Exception $e){
            Log::error('Error (sendNotifications): '.$e->getMessage());
            return false;
        }
        

    }


    public function saveGrupos(array $grupos):void
    {
        DB::beginTransaction();
        try{
            foreach($grupos as $grupo){
                Grupos::updateOrCreate(
                    [
                        'onecode_id'=>$grupo['id']
                    ],
                    [
                        'nome'=>$grupo['name'],
                        'numero'=>$grupo['number'],
                        'onecode_id'=>$grupo['id']
                    ]
                );
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error('Occoreu um erro ao tentar salvar os grupos: '.$e->getMessage());
        }
    }
}
