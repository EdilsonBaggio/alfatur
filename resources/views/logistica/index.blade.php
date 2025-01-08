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
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group input-group-sm pt-3" style="width: 200px; margin: 0 auto">
                    <input type="date" id="dateFilter" class="form-control" value="{{ $filterDate }}" placeholder="Filtrar por datas (ex: 2025-02-13, 2025-02-14)">
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                  <table class="table table-bordered table-striped logistica mt-4">
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
                        <tr>
                          <td>#</td>
                          <td>Fecha</td>
                          <td>Hora</td>
                          <td>ID</td>
                          <td>Nombre</td>
                          <td>Pax</td>
                          <td>Dirección</td>
                          <td>Conductor</td>
                          <td>Guía</td>
                          <td>Valor</td>
                          <td>Pendiente</td>
                          <td>Hotel</td>
                          <td>Teléfono</td>
                          <td>Vendedor</td>
                          <td>Voucher</td>
                          <td>Verificado</td>
                          <td>Acciones</td>
                      </tr>
                        <!-- Linhas de Dados -->
                        @foreach ($group as $logistica)
                          <tr id="logistica-{{ $logistica->id }}" class="logistics-row" data-logistica-date="{{ \Carbon\Carbon::parse($logistica->data)->format('Y-m-d') }}">
                            <td><input type="checkbox" name="logistics_ids[]" value="{{ $logistica->id }}"></td>
                            <td>{{ \Carbon\Carbon::parse($logistica->data)->format('d/m/Y') }}</td>
                            <td>
                                <div style="width: 50px; cursor: pointer;" 
                                    onclick="openModal('{{ $logistica->id }}', '{{ \Carbon\Carbon::parse($logistica->hora)->format('H:i') }}')">
                                    <i class="bi bi-alarm"></i> {{ \Carbon\Carbon::parse($logistica->hora)->format('H:i') }}
                                </div>
                            </td>
                            <td><div style="width: 70px">ALF-{{ $logistica->venda_id }}</div></td>
                            <td>{{ $logistica->nome }}</td>
                            <td style="text-align: center">{{ number_format($logistica->pax_total, 0, ',', '.') }}</td>
                            <td>{{ $logistica->venda->direcao_hotel }}</td>
                            <td class="guia-cell">{{ empty($logistica->guia) ? 'Asignar' : $logistica->guia }}</td>
                            <td class="condutor-cell">{{ empty($logistica->condutor) ? 'Asignar' : $logistica->condutor }}</td>
                            <td>{{ number_format($logistica->valor_total, 2, ',', '.') }}</td>
                            <td>{{ number_format($logistica->valor_a_pagar, 2, ',', '.') }}</td>
                            <td>{{ $logistica->hotel }}</td>
                            <td>{{ $logistica->telefone }}</td>
                            <td>{{ $logistica->vendedor }}</td>
                            <td style="text-align: center"><i style="font-size: 1.2rem; color: cornflowerblue;" class="bi bi-ticket-detailed"></i></td>
                            <td style="text-align: center">{!! $logistica->conferido ? '<i style="font-size: 1.2rem; color: green;" class="bi bi-hand-thumbs-up-fill"></i>' : '<i style="font-size: 1.2rem; color: red;" class="bi bi-hand-thumbs-down-fill"></i>' !!}</td>
                            <td style="text-align: center">
                              <a href="{{ route('logistics.edit', $logistica->id) }}">
                                <i class="bi bi-pen-fill" style="font-size: 1.2rem; color: cornflowerblue;"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="3" class="border-right-0">Exportar</td>
                          <td style="background-color: #81E979;" class="border-right-0"></td>
                          <td style="background-color: #81E979; color: #fff; font-weight: bold" class="border-left-0 border-right-0"><div style="width: 70px">PAX TOTAL</div></td>
                          <td style="background-color: #81E979; color: #fff; font-weight: bold; text-align:center" class="border-left-0">{{ $group->sum('pax_total') }}</td>
                          <td colspan="12" style="text-align: left; padding: 10px;"></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
        </div>          
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="updateModalLabel">Atualizar Logística</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="updateForm">
                  <input type="hidden" id="logistica_id">

                  <!-- Campo Guia -->
                  <div class="mb-3">
                      <label for="guia" class="form-label">Guia</label>
                      <input type="text" class="form-control" id="guia_text" required>
                  </div>

                  <!-- Campo Condutor -->
                  <div class="mb-3">
                      <label for="condutor" class="form-label">Condutor</label>
                      <input type="text" class="form-control" id="condutor_text" required>
                  </div>

                  <!-- Campo Hora -->
                  <div class="mb-3">
                      <label for="hora" class="form-label">Hora</label>
                      <input type="time" class="form-control" id="hora" required>
                  </div>

                  <button type="button" class="btn btn-primary" id="saveChanges">Salvar</button>
              </form>
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


    //modal

    // Abre o modal ao clicar no ícone do relógio
    window.openModal = function (id, hora) {
        // Busca a linha (tr) correspondente pelo ID
        let row = $('#logistica-' + id);

        // Obtém os valores do guia e condutor pelas classes
        let guia = row.find('.guia-cell').text().trim();
        let condutor = row.find('.condutor-cell').text().trim();

        // Preenche os campos do modal com os IDs corretos
        $('#logistica_id').val(id);
        $('#guia_text').val(guia);             // Guia
        $('#condutor_text').val(condutor);     // Condutor
        $('#hora').val(hora);                  // Hora

        // Exibe o modal
        $('#updateModal').modal('show');
    };

    // Salva as alterações ao clicar no botão
    $('#saveChanges').click(function () {
        let id = $('#logistica_id').val();
        let guia = $('#guia_text').val();       // Corrigido para guia_text
        let condutor = $('#condutor_text').val(); // Corrigido para condutor_text
        let hora = $('#hora').val();           // Hora mantida

        $.ajax({
            url: "{{ route('logistics.hora') }}", // URL da rota Laravel
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                logistics_ids: [id], // Envia ID como array
                guia_id: guia,
                condutor_id: condutor,
                hora: hora
            },
            success: function (response) {
                if (response.success) {
                    alert('Atualizado com sucesso!');
                    location.reload(); // Atualiza a página
                } else {
                    alert('Erro ao atualizar!');
                }
            },
            error: function () {
                alert('Erro ao processar a requisição!');
            }
        });
    });
  });
</script>

@endsection
