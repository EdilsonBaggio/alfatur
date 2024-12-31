@extends('layout.masterdash')
@section('content')
<div class="content-tabelas">
    <div class="container">
        <div class="card">
            <div class="card-header">
              Lista de Vendas
            </div>
            <div class="card-body">
              <div class="content-table">
                  <div id="loading" style="text-align: center; margin-top: 20px;">
                      <div class="spinner-border text-primary" role="status">
                          <span class="sr-only">Carregando...</span>
                      </div>
                  </div>
                  <table id="tabela-vendas" class="display responsive table mt-4" style="width: 100%; display:none;">
                    <thead>
                      <tr>
                        <th class="td_id">ID</th>
                        <th class="td_vendedor">Vendedor</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Tour</th>
                        <th>Hotel</th>
                        <th>Valor Total</th>
                        <th>Valor Pagado</th>
                        <th>Valor por Pagar</th>
                        <th>Estado del Pago</th>
                        <th>Forma de Pago</th>
                        <th>Fecha de Pago</th>
                        <th>E-mail</th>
                        <th>Fecha del Tour</th>
                        <th>PAX Adulto</th>
                        <th>Precio Adulto</th>
                        <th>PAX Infantil</th>
                        <th>Precio Infantil</th>
                        <th>Observaciones</th>
                        <th>Comprobantes</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($vendas as $venda)
                        @foreach($venda->tours as $tour)
                          <tr>
                            <td>
                              <div class="id_venda">
                                #{{ $tour->id }}
                              </div>
                            </td>
                            <td>{{ $venda->vendedor }}</td>
                            <td>{{ $venda->nome }}</td>
                            <td>{{ $venda->telefone }}</td>
                            <td>{{ $tour->tour }}</td>
                            <td>{{ $venda->hotel }}</td>
                            <td>{{ $venda->valor_total }}</td>
                            <td>{{ $venda->valor_pago }}</td>
                            <td>{{ $venda->valor_a_pagar }}</td>
                            <td>{{ $venda->estado_pagamento }}</td>
                            <td>{{ $venda->forma_pagamento }}</td>
                            <td>{{ $venda->data_pagamento }}</td>
                            <td>{{ $venda->email }}</td>
                            <td>{{ $tour->data_tour }}</td>
                            <td>{{ $tour->pax_adulto }}</td>
                            <td>{{ $tour->preco_adulto }}</td>
                            <td>{{ $tour->pax_infantil }}</td>
                            <td>{{ $tour->preco_infantil }}</td>
                            <td>{{ $venda->observacoes }}</td>
                            <td>
                              @php
                                  $extensao = strtolower(pathinfo($venda->comprovante, PATHINFO_EXTENSION)); // Garantir comparação insensível a maiúsculas
                              @endphp
                          
                              @if(in_array($extensao, ['jpg', 'jpeg', 'png', 'gif']))
                                  @isset($venda->comprovante) <!-- Verifica se o usuário tem um comprovante -->
                                      <!-- Link com atributo 'data-lightbox' para Lightbox -->
                                      <a class="btn btn-primary btn-sm" href="{{ asset($venda->comprovante) }}" data-lightbox="comprovante-{{$venda->id}}" data-title="Comprovante de Venda" target="_blank">Ver Comprovante</a>
                                  @else
                                      N/A
                                  @endisset
                              @elseif($extensao === 'pdf')
                                  <a class="btn btn-primary btn-sm" href="{{ asset($venda->comprovante) }}" target="_blank">Ver Comprovante</a>
                              @else
                                  <span>Arquivo não suportado</span>
                              @endif
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

<!-- JS do Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- JS do DataTables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<!-- JS do DataTables para Bootstrap -->
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<!-- JS do DataTables Responsive -->
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
  $(document).ready(function () {
      // Inicializa o DataTable com configurações
      $('#tabela-vendas').DataTable({
          "scrollX": true,
          "lengthChange": false,
          "dom": 'Bfrtip',
          "buttons": [
              'copy', 'csv', 'excel'
          ],
          "columnDefs": [
              {
                  // Configurações específicas da coluna
              }
          ],
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
          "initComplete": function () {
              // Esconde o spinner de carregamento e exibe a tabela após o carregamento
              $('#loading').hide();
              $('#tabela-vendas').show();
          }
      });
  });
</script>

@endsection
