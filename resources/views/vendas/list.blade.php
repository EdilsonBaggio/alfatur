@extends('layout.masterdash')
@section('content')
<div class="content-tabelas">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
              Lista de Vendas
            </div>
            <div class="card-body">
              <div class="content-table">
                  <table id="tabela-vendas" class="display responsive table mt-4" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Vendedor</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Hotel</th>
                        <th>Valor Total</th>
                        <th>Valor Pago</th>
                        <th>Valor a Pagar</th>
                        <th>Estado do Pagamento</th>
                        <th>Forma de Pagamento</th>
                        <th>Data do Pagamento</th>
                        <th>Tour</th>
                        <th>Data Tour</th>
                        <th>PAX Adulto</th>
                        <th>Preço Adulto</th>
                        <th>PAX Infantil</th>
                        <th>Preço Infantil</th>
                        <th>Observacoes</th>
                        <th>Comprovantes</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($vendas as $venda)
                        @foreach($venda->tours as $tour)
                          <tr>
                            <td>{{ $venda->vendedor }}</td>
                            <td>{{ $venda->nome }}</td>
                            <td>{{ $venda->telefone }}</td>
                            <td>{{ $venda->email }}</td>
                            <td>{{ $venda->hotel }}</td>
                            <td>{{ $venda->valor_total }}</td>
                            <td>{{ $venda->valor_pago }}</td>
                            <td>{{ $venda->valor_a_pagar }}</td>
                            <td>{{ $venda->estado_pagamento }}</td>
                            <td>{{ $venda->forma_pagamento }}</td>
                            <td>{{ $venda->data_pagamento }}</td>
                            <!-- Dados do Tour -->
                            <td>{{ $tour->tour }}</td>
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
                                      <a href="{{ asset($venda->comprovante) }}" data-lightbox="comprovante-{{$venda->id}}" data-title="Comprovante de Venda" target="_blank">Ver Comprovante</a>
                                  @else
                                      N/A
                                  @endisset
                              @elseif($extensao === 'pdf')
                                  <a href="{{ asset($venda->comprovante) }}" target="_blank">Ver Comprovante</a>
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
  $(document).ready(function(){
    $('#tabela-vendas').DataTable({
        "scrollX": true,
        "lengthChange": false,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel'
        ],
        "columnDefs": [ 
          {
            "targets": [0], 
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
        }
    });
  });
</script>

@endsection
