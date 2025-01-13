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
              <div class="table">
                  <div>
                      <form id="assignForm" method="POST">
                        @csrf
                        <!-- Restante do conteúdo do formulário -->
                        <div class="row mt-3 content-atribuir">
                            <div class="col-md-2">
                                <div class="input-group input-group-sm d-flex">
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
                                <div class="input-group input-group-sm">
                                    <select id="condutor" class="form-select">
                                        <option value="">Selecione o Condutor</option>
                                        @foreach ($users->filter(fn($user) => $user->role === 'Condutor') as $condutor)
                                            <option value="{{ $condutor->id }}">{{ $condutor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-sm">
                                    <button type="button" class="btn btn-primary btn-assign">Asignar Guia y Condutor</button>
                                </div>
                            </div>
                        </div>
                    </form>
                  </div>
                  <table class="table table-bordered table-striped logistica mt-4">
                    <tbody id="logisticsTableBody">
                      <!-- Linha com Selects e Botões -->
                      @php
                        $groupedLogistics = collect($logistics)->groupBy(function($item) {
                          return $item->tour . ' - ' . \Carbon\Carbon::parse($item->data)->format('d/m/Y');
                        });
                      @endphp

                      @foreach ($groupedLogistics as $key => $group)
                      <!-- Cabeçalho do Grupo -->
                        <tr class="td_tour">
                          <td colspan="18" style="background: #000; color: #fff; text-align: left; padding: 10px;">
                            {{ $key }}
                          </td>
                        </tr>
                        <tr class="td_head">
                          <td colspan="18" class="p-0 border-0">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Pax</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Guía</th>
                                <th scope="col">Conductor</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Pendiente</th>
                                <th scope="col">Hotel</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Vendedor</th>
                                <th scope="col">Voucher</th>
                                <th scope="col">Verificado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                          </thead>
                          </td>
                        </tr>
                        <!-- Linhas de Dados -->
                        @foreach ($group as $logistica)
                          <tr id="logistica-{{ $logistica->id }}" class="logistics-row" data-logistica-date="{{ \Carbon\Carbon::parse($logistica->data)->format('Y-m-d') }}">
                            <td data-label="#"><input type="checkbox" class="check" name="logistics_ids[]" value="{{ $logistica->id }}"></td>
                            <td data-label="Fecha">{{ \Carbon\Carbon::parse($logistica->data)->format('d/m/Y') }}</td>
                            <td data-label="Hora">
                                <div style="width: 50px; cursor: pointer;" 
                                    onclick="openModal('{{ $logistica->id }}', '{{ \Carbon\Carbon::parse($logistica->hora)->format('H:i') }}')">
                                    <i class="bi bi-alarm"></i> {{ \Carbon\Carbon::parse($logistica->hora)->format('H:i') }}
                                </div>
                            </td>
                            <td data-label="ID"><div style="width: 50px">ALF-{{ $logistica->venda_id }}</div></td>
                            <td data-label="Nombre">{{ $logistica->nome }}</td>
                            <td data-label="Pax" style="text-align: center">{{ number_format($logistica->pax_total, 0, ',', '.') }}</td>
                            <td data-label="Dirección">{{ $logistica->venda->direcao_hotel }}</td>
                            <td data-label="Guia" class="guia-cell">
                                @if(empty($logistica->guia))
                                    Asignar
                                @else
                                    {{ \App\Models\User::find($logistica->guia)->name ?? 'Asignar' }}
                                @endif
                            </td>

                            <td data-label="Condutor" class="condutor-cell">
                                @if(empty($logistica->condutor))
                                    Asignar
                                @else
                                    {{ \App\Models\User::find($logistica->condutor)->name ?? 'Asignar' }}
                                @endif
                            </td>
                            <td data-label="Valor">${{ number_format($logistica->valor_total, 2, ',', '.') }}</td>
                            <td data-label="Pendiente" class="valor_a_pagar">{{ number_format($logistica->valor_a_pagar, 2, ',', '.') }}</td>
                            <td data-label="Hotel">{{ $logistica->hotel }}</td>
                            <td data-label="Teléfono">{{ $logistica->telefone }}</td>
                            <td data-label="Vendedor">{{ $logistica->vendedor }}</td>
                            <td data-label="Voucher" style="text-align: center"><i style="font-size: 1.2rem; color: cornflowerblue;" class="bi bi-ticket-detailed"></i></td>
                            <td data-label="Verificado" style="text-align: center">
                                {!! $logistica->conferido 
                                    ? '<i style="font-size: 1.2rem; color: green;" class="bi bi-hand-thumbs-up-fill"></i>' 
                                    : '<i style="font-size: 1.2rem; color: red;" class="bi bi-hand-thumbs-down-fill"></i>' !!}
                            </td>                          
                            <td data-label="Acciones" style="text-align: center">
                                <a href="#" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#updateModalEditar" 
                                  onclick="populateModal({{ json_encode($logistica) }})">
                                    <i class="bi bi-pen-fill" style="font-size: 1.2rem; color: cornflowerblue;"></i>
                                </a>
                            </td>                            
                          </tr>
                        @endforeach
                        <tr class="td_pax">
                          <td colspan="3">Exportar</td>
                          <td colspan="3" style="background-color: #81E979; color: #fff; font-weight: bold;"><div style="float: left;">PAX TOTAL</div><div style="float: right; width: 15px">{{ $group->sum('pax_total') }}</div></td>
                          <td colspan="12" class="td_ultima" style="text-align: left;"></td>
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
              <h5 class="modal-title" id="updateModalLabel">Asignar GUIA y Fijar Hora de Retiro en Hotel</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="updateForm">
                  <input type="hidden" id="logistica_id">

                  <!-- Campo Guia -->
                  <div class="mb-3">
                      <label for="guia" class="form-label">Guia</label>
                      {{-- <input type="text" class="form-control" id="guia_text" required> --}}
                      <select id="guia_text" class="form-select">
                          <option value="" selected>Selecione o Guia</option>
                          @foreach ($users->filter(fn($user) => $user->role === 'Guia') as $guia)
                              <option value="{{ $guia->id }}">{{ $guia->name }}</option>
                          @endforeach
                      </select>
                  </div>
                  
                  <!-- Campo Condutor -->
                  <div class="mb-3">
                      <label for="condutor" class="form-label">Condutor</label>
                      {{-- <input type="text" class="form-control" id="condutor_text" required> --}}
                      <select id="condutor_text" class="form-select">
                        <option value="" selected>Selecione o Condutor</option>
                        @foreach ($users->filter(fn($user) => $user->role === 'Condutor') as $condutor)
                            <option value="{{ $condutor->id }}">{{ $condutor->name }}</option>
                        @endforeach
                    </select>
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

<!-- Modal -->
<div class="modal fade" id="updateModalEditar" tabindex="-1" aria-labelledby="updateModalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="updateModalEditarLabel">Editar Logística</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="updateForm">
                  <input type="hidden" id="logistica_id">

                  <!-- Campo Tour -->
                  <div class="mb-3">
                      <label for="tour" class="form-label">Tour</label>
                      <input type="text" class="form-control" id="tour" placeholder="Digite o nome do tour" required>
                  </div>

                  <!-- Campo Data -->
                  {{-- <div class="mb-3">
                      <label for="data" class="form-label">Data</label>
                      <input type="date" class="form-control" id="data_editar" required>
                  </div> --}}

                  <!-- Campo Hora -->
                  <div class="mb-3">
                      <label for="hora" class="form-label">Hora</label>
                      <input type="time" class="form-control" id="hora_editar" required>
                  </div>

                  <!-- Campo Nome -->
                  <div class="mb-3">
                      <label for="nome" class="form-label">Nome</label>
                      <input type="text" class="form-control" id="nome" placeholder="Digite o nome" required>
                  </div>

                  <!-- Campo Pax -->
                  <div class="mb-3">
                      <label for="pax_total" class="form-label">Pax Total</label>
                      <input type="number" class="form-control" id="pax_total" placeholder="Quantidade de Pax" required>
                  </div>

                  <!-- Campo Valor Total -->
                  <div class="mb-3">
                      <label for="valor_total" class="form-label">Valor Total</label>
                      <input type="number" step="0.01" class="form-control" id="valor_total" placeholder="Digite o valor total" required>
                  </div>

                  <!-- Campo Valor Pendiente -->
                  <div class="mb-3">
                      <label for="valor_a_pagar" class="form-label">Valor Pendiente</label>
                      <input type="number" step="0.01" class="form-control" id="valor_a_pagar" placeholder="Digite o valor pendente" required>
                  </div>

                  <!-- Campo Hotel -->
                  <div class="mb-3">
                      <label for="hotel" class="form-label">Hotel</label>
                      <input type="text" class="form-control" id="hotel" placeholder="Digite o nome do hotel" required>
                  </div>

                  <!-- Campo Telefone -->
                  <div class="mb-3">
                      <label for="telefone" class="form-label">Telefone</label>
                      <input type="text" class="form-control" id="telefone" placeholder="Digite o telefone" required>
                  </div>

                  <!-- Campo Verificado -->
                  <div class="mb-3">
                      <label for="conferido" class="form-label">Verificado</label>
                      <select class="form-select" id="conferido">
                          <option value="1">Sim</option>
                          <option value="0">Não</option>
                      </select>
                  </div>

                  <button type="button" class="btn btn-primary" id="editarModal">Salvar Alterações</button>
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

      $('.valor_a_pagar').each(function () {
            console.log('Processando valor:', $(this).text()); // Debug
            let valor = parseFloat($(this).text().replace(',', '.')); // Converte texto para número
            console.log('Valor convertido:', valor); // Debug
            if (valor > 0) { // Verifica se o valor é maior que 0
                let tr = $(this).closest('tr'); // Seleciona a linha (tr) mais próxima
                console.log('Linha correspondente:', tr); // Debug
                tr.addClass('danger-row'); // Adiciona a classe
            }
        });

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
          Swal.fire({
            title: "Por favor!",
            text: "Seleccione al menos una logística.",
            icon: "error"
          });
          return;
        }

        // Verificar se os campos Guia e Condutor estão selecionados
        if (!guiaId) {
            Swal.fire({
              title: "Por favor!",
              text: "Seleccione una guía.",
              icon: "error"
            });
            return;
        }

        if (!condutorId) {
            Swal.fire({
              title: "Por favor!",
              text: "Seleccione un controlador.",
              icon: "error"
            });
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
                  Swal.fire({
                      title: "¡Guía y conductor asignados exitosamente!",
                      showDenyButton: false,
                      showCancelButton: false,
                      confirmButtonText: "Ok",
                      icon: "success"
                    }).then((result) => {
                      if (result.isConfirmed) {
                        $("#guia").val("").trigger("change");
                        $("#condutor").val("").trigger("change");
                        $(".check").prop('checked', false); 
                        $.each(selectedLogistics, function (index, id) {
                            var row = $('input[value="' + id + '"]').closest('tr');
                            row.find('.guia-cell').text(response.guia_name || 'Atribuir');
                            row.find('.condutor-cell').text(response.condutor_name || 'Atribuir');
                        });
                      }
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
        // $('#guia_text').val(guia);             
        // $('#condutor_text').val(condutor);     
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


  // Função para preencher o modal com os dados da logística
  function populateModal(logistica) {
      // Preenche os campos do modal com os dados do objeto `logistica`
      $('#logistica_id').val(logistica.id);
      $('#tour').val(logistica.tour);
      $('#nome').val(logistica.nome);
      $('#pax_total').val(logistica.pax_total);
      $('#valor_total').val(logistica.valor_total);
      $('#valor_a_pagar').val(logistica.valor_a_pagar);
      $('#hotel').val(logistica.hotel);
      $('#telefone').val(logistica.telefone);
      $('#vendedor').val(logistica.vendedor);
      $('#conferido').val(logistica.conferido); // 1 ou 0
      $('#hora_editar').val(logistica.hora);

      // Exibe o modal
      $('#updateModalEditar').modal('show');
  };

  // Salva as alterações ao clicar no botão
  $('#editarModal').click(function () {
      let id = $('#logistica_id').val();
      let tour = $('#tour').val();
      let nome = $('#nome').val();
      let pax_total = $('#pax_total').val();
      let valor_total = $('#valor_total').val();
      let valor_a_pagar = $('#valor_a_pagar').val();
      let hotel = $('#hotel').val();
      let telefone = $('#telefone').val();
      let conferido = $('#conferido').val();
      // let data = $('#data_editar').val();
      let hora = $('#hora_editar').val(); // Captura o valor do campo hora

      // Verificação simples para garantir que os campos obrigatórios não estão vazios
      if (!hora) {
          alert('Os campos Data e Hora são obrigatórios!');
          return; // Não envia o AJAX se os campos estiverem vazios
      }

      $.ajax({
          url: "{{ route('logistics.update', ':id') }}".replace(':id', id), // URL da rota Laravel
          type: 'POST',
          data: {
              _token: $('meta[name="csrf-token"]').attr('content'),
              tour: tour,
              nome: nome,
              pax_total: pax_total,
              valor_total: valor_total,
              valor_a_pagar: valor_a_pagar,
              hotel: hotel,
              telefone: telefone,
              conferido: conferido,
              // data: data,
              hora: hora  // Envia o valor do campo hora
          },
          success: function (response) {
              if (response.success) {
                  alert('Logística atualizada com sucesso!');
                  $('#updateModalEditar').modal('hide'); // Fecha o modal
                  location.reload();
                  // Atualize a lista ou tabela aqui, se necessário
              } else {
                  alert('Erro ao atualizar a logística!');
              }
          },
          error: function () {
              alert('Erro ao processar a requisição!');
          }
      });
  });

</script>

@endsection
