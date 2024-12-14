<div wire:init='data'>
    <div class="row content-tabelas">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Configurar alertas
                </div>
                
                <div class="card-body">
                  <div class="content-table-menus">
                    <form id="d-flex align-items-stretch alerta-form" wire:submit.prevent="save">
                        <div class="d-flex align-content-between flex-wrap my-1 py-1 h-max">
                          <span>Placa</span>
                          <input type="text" class="my-2 form-control placa @error('placa') border-danger @enderror" wire:model="placa" id="placa" placeholder="Placa" required>
                          @error('placa') <small class="text-danger error" style="font-size: 10px;height:20px;">{{ $message }}</small>@else <small  style="font-size: 10px;height:20px;">Coloque a placa do carro no padrão que preferir!</small> @enderror
                        </div>

                        <div class="d-flex align-content-between flex-wrap  m-1 p-1 h-max">
                          <span class="w-100">Tempo de Disparo </span>
                          <input type="number" class="my-2  form-control" id="tempo" wire:model="tempo" placeholder="Em minutos" required>
                            @error('tempo') <span class="text-danger error"  style="font-size: 10px;height:20px;">{{ $message }}</span> @else <small  style="font-size: 10px;height:20px;">Evite colocar valores decimais e negativos!</small>  @enderror
                        </div>

                        <div class="form-check">
                            <span>Ativo</span>
                            <input type="checkbox" id="switch1" switch="primary" wire:model="ativo"/>
                            <label for="switch1" data-on-label="Sim" data-off-label="Não" class="mb-0"></label>
                        </div>
                        <button type="submit" class="btn button-enviar">Adicionar</button>
                      </form>
                  </div>
                  <input type="text" id="search-input" placeholder="Pesquisar..." class="form-control">

                  <div class="content-table" wire:ignore>
                    <table id="tabela-alertas" class="display mt-4" style="width: 100%">
                      <thead>
                          <tr>
                              <th class="td_placa">Placa</th>
                              <th class="td_tempo">Tempo de disparo do alerta</th>
                              <th class="td_ativo">Ativo</th>
                              <th class="td_acao">Ação</th>
                          </tr>
                      </thead>
                      <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                      </tbody>
                    </table>
                </div>
                </div>
            </div>          
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmação de Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" wire:click="cancelar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir este alerta?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancelar">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="deleteAlerta">Excluir</button>
            </div>
        </div>
        </div>
    </div>

    @push('script')

        <!-- JS do DataTables -->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

        <!-- JS do DataTables para Bootstrap -->
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

        <script>
            document.addEventListener('livewire:init', () => {
                var tabela = $('#tabela-alertas').DataTable({
                    "searching":true,
                    "lengthChange": false,
                    "dom": 'lrtip',
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por página",
                        "zeroRecords": "Nada encontrado - desculpe",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "Nenhum registro disponível",
                        "infoFiltered": "(filtrado de _MAX_ registros no total)",
                        "responsive": true,
                        "sSearch": "Pesquisar:",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        },
                        "sProcessing": "Processando...",
                        "sLoadingRecords": "Carregando...",
                        "sZeroRecords": "Nenhum registro encontrado"
                    },
                    "columnDefs": [
                        {
                            "targets": "td_placa",
                            "data": "placa"
                        },
                        {
                            "targets": "td_tempo",
                            "data": "tempo"
                        },
                        {
                            "targets": "td_ativo",
                            "data": "ativo",
                            "className": "td-ativo",
                            render: function (data, type, row, meta) {
                                return data == 0 ? "Não" : "Sim";
                            }
                        },
                        {
                            "targets": "td_acao",
                            "className": "td-acao",
                            "data": "acoes",
                            "render": function (data, type, row, meta) {
                                return data;
                            },
                            "width": 150,
                            "orderable": false
                        }
                    ],
                    "pageLength": 5
                });

                $('#search-input').on('keyup', function() {
                    tabela.search(this.value).draw();
                });
        
                Livewire.on('alertasCarregados', (alertas) => {
                    try {
                        const dados = JSON.parse(alertas);
                        tabela.clear().rows.add(dados).draw();
                    } catch (error) {
                        console.error('Erro ao processar alertas:', error);
                    }
                });

                Livewire.on('confirmDeleteDialog', () => {
                    if (confirm('Tem certeza que deseja excluir este veículo?')) {
                        Livewire.emit('deleteVeiculo');
                    }
                });


                Livewire.on('editar', function () {
                    $(document).ready(function(){
                        $('.button-enviar').text('Salvar');
                    });
                });
            });

            $(document).on('click', '#openModal', function() {
                var id = $(this).data('id');
                Livewire.dispatch('confirmDelete',[id]);
            });
     
            window.addEventListener('openModal', event => {
                $('#confirmModal').modal('show');
            })

            window.addEventListener('closeModal', event => {
                $('#confirmModal').hide();

                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
            })
        </script>
            
    @endpush
</div>
