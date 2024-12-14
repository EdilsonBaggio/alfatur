<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VincularVeiculos AS Veiculos;
use Illuminate\Support\Facades\Vite;
use Carbon\Carbon;
use Livewire\Attributes\On;

class VincularVeiculos extends Component
{
    public $placa, $grupo_cliente, $veiculoId, $grupos;

    protected $rules = [
        'placa' => 'required',
        'grupo_cliente' => 'required'
    ];

    public function render()
    {
        return view('livewire.vincular-veiculos');
    }

    public function data(){
        $veiculos = Veiculos::with('grupoNome')->get();

        // Preparar os dados dos veículos para o DataTables
        $dados = [];
        $deleteUrl = Vite::asset('resources/images/lixeira.svg');
        $editarUrl = Vite::asset('resources/images/edit.svg');

        foreach ($veiculos as $veiculo) {
            $dados[] = [
                'id' => $veiculo->id,
                'placa' => $veiculo->placa,
                'grupo_cliente' => $veiculo->grupoNome->nome,
                // 'whatsapp' => $veiculo->whatsapp,
                'acoes' => '<button class="border-zero" id="openModal" data-id="'. $veiculo->id .'"><img class="img-fluid apagar" src="' . $deleteUrl . '" alt=""></button><button class="border-zero editar" wire:click="editarVeiculo(' . $veiculo->id . ')"><img class="img-fluid apagar" src="' . $editarUrl . '" alt=""></button>'
            ];
        }

        // Emitir o evento com os dados dos veículos
        $this->dispatch('veiculosCarregados', json_encode($dados));

    }

    public function save()
    {
        $this->validate();

        if ($this->veiculoId) {
            $veiculo = Veiculos::find($this->veiculoId);
            if ($veiculo) {
                $veiculo->update([
                    'placa' => $this->placa,
                    'grupo_cliente' => $this->grupo_cliente,
                    // 'whatsapp' => $this->whatsapp,
                ]);
            }
        } else {
            Veiculos::create([
                'placa' => $this->placa,
                'grupo_cliente' => $this->grupo_cliente,
                // 'whatsapp' => $this->whatsapp,
            ]);
        }

        $this->reset(['placa', 'grupo_cliente', 'veiculoId']);
        $this->data();
    }

    #[On('confirmDelete')] 
    public function confirmDelete($id)
    {
        $this->veiculoId = $id;
        $this->dispatch('openModal');
    }

    public function deleteVeiculo()
    {
        Veiculos::where('id',$this->veiculoId)->delete();
        $this->data();
        $this->cancelar();
    }

    public function cancelar()
    {
        $this->dispatch('closeModal');
    }

    public function editarVeiculo($id)
    {
        $this->dispatch('editar');

        $veiculo = Veiculos::find($id);
        
        if ($veiculo) {
            $this->veiculoId = $veiculo->id;
            $this->placa = $veiculo->placa;
            $this->grupo_cliente = $veiculo->grupo_cliente;
            // $this->whatsapp = $veiculo->whatsapp;
        }
    }
}
