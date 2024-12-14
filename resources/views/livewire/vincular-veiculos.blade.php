<div wire:init='data'>
    <div class="row content-tabelas">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                  Vincular veículos
                </div>
                <div class="card-body">
                  <div class="content-table-menus">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <span>Placa</span>
                            <input type="text" class="form-control placa" id="placa" placeholder="Placa" wire:model="placa" required>
                            @error('placa') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <span>Grupo de Cliente</span>
                            {{-- Trocar futuramente para estilo com classe. --}}
                            <select class="form-control" wire:model='grupo_cliente' style="height: 28px;margin-top:10px;font-size:11px;">
                                @foreach($grupos as $index=>$grupo)
                                    <option value="{{$index}}"> {{$grupo}} </option>
                                @endforeach
                            </select>
                            @error('grupo_cliente') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn button-adicionar table-responsive-sm">Adicionar</button>
                    </form>                              
                  </div>
                  
                  <input type="text" id="search-input" placeholder="Pesquisar..." class="form-control">

                  <div class="content-table" wire:ignore>
                      <table id="tabela-veiculos" class="display mt-4" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="td_placa">Placa</th>
                                <th class="td_grupo_cliente">Grupo de Cliente</th>
                                {{-- <th class="td_celular">Celular com Whatsapp</th> --}}
                                <th class="td_acao">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                {{-- <td></td> --}}
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
            Tem certeza de que deseja excluir este veículo?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancelar">Cancelar</button>
            <button type="button" class="btn btn-primary" wire:click="deleteVeiculo">Excluir</button>
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
                var tabela = $('#tabela-veiculos').DataTable({
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
                            "targets": "td_grupo_cliente",
                            "data": "grupo_cliente"
                        },
                        // {
                        //     "targets": "td_celular",
                        //     "data": "whatsapp"
                        // },
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
        
                Livewire.on('veiculosCarregados', (veiculos) => {
                    try {
                        const dados = JSON.parse(veiculos);
                        tabela.clear().rows.add(dados).draw();

                        $(".celular").mask('(00) 00000-0000');
                    } catch (error) {
                        console.error('Erro ao processar veículos:', error);
                    }
                });

                Livewire.on('editar', function () {
                    $(document).ready(function(){
                        $('.button-adicionar').text('Salvar');
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
