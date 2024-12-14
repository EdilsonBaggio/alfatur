<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ConfigurarAlertas AS Alertas;
use Illuminate\Support\Facades\Vite;
use Carbon\Carbon;
use Livewire\Attributes\On;

class ConfigurarAlertas extends Component
{
    public $placa, $tempo, $ativo = true, $alertaId, $deleteAlertaId;

    protected $rules = [
        'placa' => 'required|unique:configurar_alertas',
        'tempo' => 'required|min:0|not_in:0|integer',
        'ativo' => 'required|boolean'
    ];

    protected $messages = [
        'placa.unique'=>'Essa placa já possui uma configuração salva!',
        'tempo'=>'O tempo dos alertas não pode ser menor que zero e precisa ser um número inteiro!'
    ];

    public function render()
    {
        return view('livewire.configurar-alertas');
    }
    
    public function data()
    {
        if (is_null($this->ativo)) {
            $this->ativo = true;
        }

        $alertas = Alertas::whereNull('deleted_at')->get();

        $dados = [];
        foreach ($alertas as $alerta) {
            $deleteUrl = Vite::asset('resources/images/lixeira.svg');
            $editarUrl = Vite::asset('resources/images/edit.svg');
            $dados[] = [
                'id' => $alerta->id,
                'placa' => $alerta->placa,
                'tempo' => $alerta->tempo,
                'ativo' => $alerta->ativo,

                'acoes' => '<button class="border-zero" id="openModal" data-toggle="modal" data-target="#confirmModal" data-id="'. $alerta->id .'""><img class="img-fluid apagar" src="' . $deleteUrl . '" alt=""></button><button class="border-zero editar" wire:click="editarAlerta(' . $alerta->id . ')"><img class="img-fluid apagar" src="' . $editarUrl . '" alt=""></button>'
            ];
        }

        $this->dispatch('alertasCarregados', json_encode($dados));
    }

    public function save()
    {
        $this->placa = trim($this->placa);

        if ($this->alertaId) {
            $alerta = Alertas::find($this->alertaId);

            if ($alerta) {

                $alerta->update([
                    'placa' => $this->placa,
                    'tempo' => $this->tempo,
                    'ativo' => $this->ativo,
                ]);
            }
        } else {
            $this->validate();
            Alertas::create([
                'placa' => $this->placa,
                'tempo' => $this->tempo,
                'ativo' => $this->ativo,
            ]);
        }

        $this->reset(['placa', 'tempo', 'ativo', 'alertaId']);
        $this->data();
    }

    public function cancelar()
    {
        $this->dispatch('closeModal');
    }

    #[On('confirmDelete')]
    public function confirmDelete($id)
    {
        $this->deleteAlertaId = $id;
        $this->dispatch('openModal');
    }

    public function deleteAlerta()
    {
        Alertas::find($this->deleteAlertaId)->delete();
        $this->data();
        $this->cancelar();
    }

    public function editarAlerta($id)
    {

        $this->resetValidation();

        $this->dispatch('editar');

        $alerta = Alertas::find($id);
        if ($alerta) {
            $this->alertaId = $alerta->id;
            $this->placa = $alerta->placa;
            $this->tempo = $alerta->tempo;
            $this->ativo = $alerta->ativo == 0 ? false:true;
        }
    }
}
