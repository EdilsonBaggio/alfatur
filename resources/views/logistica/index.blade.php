@extends('layout.masterdash')

@section('content')
<div id="loading" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center; background-color: #fff; z-index: 9999;">
  <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Carregando...</span>
  </div>
</div>
<div class="content-tabelas">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
              Lista de Logísticas
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-md-3">
                  <div class="input-group input-group-sm">
                    <input type="date" id="dateFilter" class="form-control" value="{{ $filterDate }}" placeholder="Filtrar por datas (ex: 2025-02-13, 2025-02-14)">
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                  <table class="table table-bordered table-striped logistica mt-4">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>ID</th>
                        <th>Pax</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Conductor</th>
                        <th>Guía</th>
                        <th>Valor Total</th>
                        <th>Valor a Pagar</th>
                        <th>Hotel</th>
                        <th>Teléfono</th>
                        <th>Vendedor</th>
                        <th>Estado de Pago</th>
                        <th>Voucher</th>
                        <th>Verificado</th>
                        <th>Acciones</th>
                    </tr>
                    
                    </thead>
                    <tbody id="logisticsTableBody">
                      @php
                        $groupedLogistics = collect($logistics)->groupBy(function($item) {
                          return $item->tour . ' - ' . \Carbon\Carbon::parse($item->data)->format('d/m/Y');
                        });
                      @endphp

                      @foreach ($groupedLogistics as $key => $group)
                        <!-- Cabeçalho do Grupo -->
                        <tr>
                          <td colspan="18" style="background: #000; color: #fff; text-align: left; padding: 10px;">
                            {{ $key }}
                          </td>
                        </tr>

                        <!-- Linha com Selects e Botões -->
                        <tr>
                          <td colspan="18" style="text-align: left; padding: 10px;">
                            <form id="assignForm" method="POST">
                                @csrf
                                <!-- Restante do conteúdo do formulário -->
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm mb-3 d-flex">
                                            <i class="bi bi-arrow-90deg-down p-2"></i>
                                            <select id="guia" class="form-select">
                                                <option value="">Selecione o Guia</option>
                                                @foreach ($users->filter(fn($user) => $user->role === 'Guia') as $guia)
                                                    <option value="{{ $guia->id }}">{{ $guia->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm mb-3">
                                            <select id="condutor" class="form-select">
                                                <option value="">Selecione o Condutor</option>
                                                @foreach ($users->filter(fn($user) => $user->role === 'Condutor') as $condutor)
                                                    <option value="{{ $condutor->id }}">{{ $condutor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm mb-3">
                                            <button type="button" class="btn btn-primary btn-assign">Asignar Guia y Condutor</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                          </td>
                        </tr>

                        <!-- Linhas de Dados -->
                        @foreach ($group as $logistica)
                          <tr class="logistics-row" data-logistica-date="{{ \Carbon\Carbon::parse($logistica->data)->format('Y-m-d') }}">
                            <td><input type="checkbox" name="logistics_ids[]" value="{{ $logistica->id }}"></td>
                            <td>{{ \Carbon\Carbon::parse($logistica->data)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($logistica->hora)->format('H:i') }}</td>
                            <td><div style="width: 70px">ALF-{{ $logistica->venda_id }}</div></td>
                            <td>{{ number_format($logistica->pax_total, 0, ',', '.') }}</td>
                            <td>{{ $logistica->nome }}</td>
                            <td>{{ $logistica->venda->direcao_hotel }}</td>
                            <td class="guia-cell">{{ empty($logistica->guia) ? 'Asignar' : $logistica->guia }}</td>
                            <td class="condutor-cell">{{ empty($logistica->condutor) ? 'Asignar' : $logistica->condutor }}</td>
                            <td>{{ number_format($logistica->valor_total, 2, ',', '.') }}</td>
                            <td>{{ number_format($logistica->valor_a_pagar, 2, ',', '.') }}</td>
                            <td>{{ $logistica->hotel }}</td>
                            <td>{{ $logistica->telefone }}</td>
                            <td>{{ $logistica->vendedor }}</td>
                            <td>
                              @if($logistica->estado_pagamento === 'Pago')
                                <span class="badge bg-success">Pago</span>
                              @else
                                <span class="badge bg-warning">Pendente</span>
                              @endif
                            </td>
                            <td><i class="bi bi-ticket-detailed"></i></td>
                            <td>{{ $logistica->conferido ? 'Sim' : 'Não' }}</td>
                            <td>
                              <a href="{{ route('logistics.edit', $logistica->id) }}">
                                <i class="bi bi-pen-fill" style="font-size: 1.2rem; color: cornflowerblue;"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
        </div>          
    </div>
</div>
@endsection

@section('script')
<script>
  window.addEventListener('load', function () {
      document.getElementById('loading').style.display = 'none';
  });

  // Filtrar por data
  document.getElementById('dateFilter').addEventListener('change', function() {
    var selectedDates = this.value.split(',').map(function(date) {
      return date.trim();
    }).join(',');

    // Redirecionar para a rota com as datas selecionadas
    window.location.href = "{{ route('logistica.index') }}?dateFilter=" + selectedDates;
  });

  $(document).ready(function () {
    // Clique no botão para atribuir Guia e Condutor
    $('.btn-assign').click(function () {
        // Obter os IDs das logísticas selecionadas
        var selectedLogistics = [];
        $('input[type="checkbox"]:checked').each(function () {
            selectedLogistics.push($(this).val());
        });

        // Obter os valores selecionados dos selects
        var guiaId = $('#guia').val();
        var condutorId = $('#condutor').val();

        // Validação - Verificar se pelo menos um checkbox foi selecionado
        if (selectedLogistics.length === 0) {
            alert('Por favor, selecione pelo menos uma logística.');
            return;
        }

        // Verificar se os campos Guia e Condutor estão selecionados
        if (!guiaId) {
            alert('Por favor, selecione um Guia.');
            return;
        }

        if (!condutorId) {
            alert('Por favor, selecione um Condutor.');
            return;
        }

        // Enviar via AJAX
        $.ajax({
            url: "{{ route('logistics.assign') }}", // Rota para atribuir Guia e Condutor
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}', // CSRF token para proteção
                logistics_ids: selectedLogistics, // Array de IDs selecionados
                guia_id: guiaId,
                condutor_id: condutorId
            },
            success: function (response) {
                if (response.success) {
                    alert('Guia e Condutor atribuídos com sucesso!');

                    // Atualizar a tabela dinamicamente
                    $.each(selectedLogistics, function (index, id) {
                        var row = $('input[value="' + id + '"]').closest('tr');
                        
                        // Atualiza Guia e Condutor
                        row.find('.guia-cell').text(response.guia_name || 'Atribuir');
                        row.find('.condutor-cell').text(response.condutor_name || 'Atribuir');
                    });
                } else {
                    alert('Erro: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Erro ao processar a requisição. Tente novamente.');
            }
        });
    });
  });
</script>

@endsection
