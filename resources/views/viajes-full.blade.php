@extends('layout.masterdash')

@section('content')
<div class="content-tabelas">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Todos los viajes
            </div>
            <div class="card-body table">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="estado" class="form-label">Filtrar por Estado:</label>
                        <select id="estado" class="form-select">
                            <option value="Todos" {{ $estado == 'Todos' ? 'selected' : '' }}>Todos</option>
                            <option value="Reservado" {{ $estado == 'Reservado' ? 'selected' : '' }}>Reservado</option>
                            <option value="Confirmado" {{ $estado == 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                            <option value="Cancelado" {{ $estado == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="guia" class="form-label">Filtrar por Guia:</label>
                        <select id="guia" class="form-select">
                            <option value="Todos" {{ $guia == 'Todos' ? 'selected' : '' }}>Todos</option>
                            @foreach(\App\Models\User::where('role', 'guia')->get() as $user)
                                <option value="{{ $user->id }}" {{ $guia == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="condutor" class="form-label">Filtrar por Condutor:</label>
                        <select id="condutor" class="form-select">
                            <option value="Todos" {{ $condutor == 'Todos' ? 'selected' : '' }}>Todos</option>
                            @foreach(\App\Models\User::where('role', 'condutor')->get() as $user)
                                <option value="{{ $user->id }}" {{ $condutor == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <table class="table table-striped logistica">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Status</th>
                            <th scope="col">ID</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Tour</th>
                            <th style="text-align: center" scope="col">PAX</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Vendedor</th>
                            <th scope="col">Valor</th>
                            <th scope="col" style="text-align: center; font-size:18px"><i class="bi bi-cash-stack"></i></th>
                            <th scope="col" style="text-align: center">Guia</th>
                            <th style="text-align: center" scope="col">Condutor</th>
                            <th style="text-align: center" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viajes as $viaje)
                            <tr>
                                <td data-label="Data">{{ \Carbon\Carbon::parse($viaje->data)->locale('es')->translatedFormat('l d-m') }}</td>
                                <td data-label="Hora">{{ $viaje->hora }}</td>
                                <td data-label="Status">{{ $viaje->status }}</td>
                                <td data-label="ID">ALF-{{ $viaje->id }}</td>
                                <td data-label="Cliente">{{ $viaje->nome }}</td>
                                <td data-label="Tour">{{ $viaje->tour }}</td>
                                <td style="text-align: center" data-label="PAX">{{ $viaje->pax_total }}</td>
                                <td data-label="Telefone">{{ $viaje->telefone }}</td>
                                <td data-label="Vendedor">{{ $viaje->vendedor }}</td>
                                <td data-label="Valor">${{ number_format($viaje->valor_total, 0, ',', '.') }}</td>
                                <td data-label="Editar Valor" style="text-align: center; font-size:16px">
                                    <!-- Botão para abrir o modal -->
                                    <button type="button" class="border-0 desktop_viajes" data-id="{{ $viaje->venda_id }}" data-bs-toggle="modal" data-bs-target="#voucherModal">
                                        <i class="bi bi-cash-stack"></i>
                                    </button>
                                    {{-- <a href="/viajes-full/get-venda-details/{{ $viaje->venda_id }}" class="mobile_viajes" target="_blank"> <i class="bi bi-cash-stack"></i></a> --}}
                                </td>
                                <td data-label="Guia" style="text-align: center">
                                    @if(empty($viaje->guia))
                                        <i style="font-size: 18px; color:red" class="bi bi-person-raised-hand"></i>
                                    @else
                                        <div class="guia-name">{{ \App\Models\User::find($viaje->guia)->name ?? 'Asignar' }}</div>
                                        <div class="guia-whatsapp" style="display: none;">{{ \App\Models\User::find($viaje->guia)->whatsapp ?? 'Asignar' }}</div>
                                    @endif
                                </td>
                                <td data-label="Condutor" style="text-align: center">
                                    @if(empty($viaje->condutor))
                                        <i style="font-size: 18px; color:red" class="bi bi-person-raised-hand"></i>
                                    @else
                                        <div class="condutor-name">{{ \App\Models\User::find($viaje->condutor)->name ?? 'Asignar' }}</div>
                                        <div class="condutor-whatsapp" style="display: none;">{{ \App\Models\User::find($viaje->condutor)->whatsapp ?? 'Asignar' }}</div>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <a class="editar-status" style="cursor: pointer; font-size: 18px" data-id="{{ $viaje->id }}" data-status="{{ $viaje->status }}"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>          
    </div>
</div>


<!-- Modal de Edição de Status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Editar Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-viaje-id">
                <label for="modal-status">Novo Status:</label>
                <select id="modal-status" class="form-select mt-3">
                    <option value="Reservado">Reservado</option>
                    <option value="Confirmado">Confirmado</option>
                    <option value="Cancelado">Cancelado</option>
                </select>

                <label for="modal-hora" class="mt-3 mb-3">Nova Hora:</label>
                <input type="time" id="modal-hora" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success salvar-status">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucherModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-content">
                <iframe width="100%" height="1000px" id="vendaIframe" src="" scrolling="no" frameborder="no"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
  
@endsection
@section('script')
<script>
    $(document).ready(function() {
        // Filtragem por estado
        // $('#estado').change(function() {
        //     var estado = $(this).val();
        //     window.location.href = "{{ route('viajes.full') }}?estado=" + estado;
        // });

        // Abrir o modal e carregar os dados
        $('.editar-status').click(function() {
            var viajeId = $(this).data('id');
            var statusAtual = $(this).data('status');
            var horaAtual = $(this).data('hora');

            $('#modal-viaje-id').val(viajeId);
            $('#modal-status').val(statusAtual);
            $('#modal-hora').val(horaAtual);
            $('#statusModal').modal('show');
        });

        // Salvar a atualização via AJAX
        $('.salvar-status').click(function() {
            var viajeId = $('#modal-viaje-id').val();
            var novoStatus = $('#modal-status').val();
            var novaHora = $('#modal-hora').val();

            $.ajax({
                url: '/viajes-full/update-status/' + viajeId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: novoStatus,
                    hora: novaHora
                },
                success: function(response) {
                    if (response.success) {
                        $('#status-' + viajeId).text(novoStatus);
                        $('#hora-' + viajeId).text(novaHora);
                        $('#statusModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Erro ao atualizar os dados!');
                    }
                },
                error: function() {
                    alert('Erro na comunicação com o servidor.');
                }
            });
        });

        $(document).on('click', '[data-id]', function() {
            var viajeId = $(this).data('id'); // Obtém o ID do botão clicado
            var url = '/viajes-full/get-venda-details/' + viajeId; // URL da venda

            // Atualiza o iframe para carregar os detalhes dentro da página
            $('#vendaIframe').attr('src', url);
        });
    });

    function aplicarFiltros() {
        var estado = $('#estado').val();
        var guia = $('#guia').val();
        var condutor = $('#condutor').val();
        window.location.href = "{{ route('viajes.full') }}" + "?estado=" + estado + "&guia=" + guia + "&condutor=" + condutor;
    }

    $('#estado, #guia, #condutor').change(aplicarFiltros);

</script>
@endsection
