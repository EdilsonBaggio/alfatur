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
                  <table id="tabela-vendas" class="display table responsive mt-4" style="width: 100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Vendedor</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Hotel</th>
                        <th>Valor Total</th>
                        <th>Data do Pagamento</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($vendas as $venda)
                      <tr>
                        <td>{{ $venda->id }}</td>
                        <td>{{ $venda->vendedor }}</td>
                        <td>{{ $venda->nome }}</td>
                        <td>{{ $venda->telefone }}</td>
                        <td>{{ $venda->email }}</td>
                        <td>{{ $venda->hotel }}</td>
                        <td>{{ $venda->valor_total }}</td>
                        <td>{{ $venda->data_pagamento }}</td>
                        <td>
                          <a href="#" class="btn btn-primary btn-sm">Editar</a>
                        </td>
                      </tr>
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
            'copy', 'csv', 'excel', 'pdf', 'print'
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
