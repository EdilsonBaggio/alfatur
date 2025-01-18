@extends('layout.masterdash')
@section('content')
<div class="content-tabelas">
    <div class="container">
        <div class="card">
            <div class="card-header">
              Ativos
            </div>
            <div class="card-body">
              <div class="content-table">
                  <table id="tabela-tours-ativos" class="display table responsive mt-4" style="width: 100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($activeTours as $tour)
                      <tr>
                        <td>
                          <div class="id_tours">
                            #{{ $tour->id }}
                          </div>
                        </td>
                        <td>{{ $tour->name }}</td>
                        <td>{{ '$' . number_format($tour->price, 0, ',', '.') }}</td>
                        <td>{{ $tour->status ? '' : 'Ativo' }}</td>
                        <td>
                          <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
        </div>   
        
        <div class="card">
            <div class="card-header">
              Inativos
            </div>
            <div class="card-body">
              <div class="content-table">
                  <table id="tabela-tours-inativos" class="display table responsive mt-4" style="width: 100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($inactiveTours as $tour)
                      <tr>
                        <td>
                          <div class="id_tours">
                            #{{ $tour->id }}
                          </div>
                        </td>
                        <td>{{ $tour->name }}</td>
                        <td>{{ '$' . number_format($tour->price, 0, ',', '.') }}</td>
                        <td>{{ $tour->status ? 'Inativo' : '' }}</td>
                        <td>
                          <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-primary btn-sm">Editar</a>
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

<!-- JS do DataTables Responsivo -->
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<!-- CSS do DataTables Responsivo -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

<script>
  $(document).ready(function(){
    $('#tabela-tours-ativos').DataTable({
        "lengthChange": false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Nenhum registro encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ registros no total)",
            "sSearch": "Pesquisar:",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior"
            }
        },
        "responsive": true,
    });

    $('#tabela-tours-inativos').DataTable({
        "lengthChange": false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Nenhum registro encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ registros no total)",
            "sSearch": "Pesquisar:",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior"
            }
        },
        "responsive": true,
    });
  });
</script>
@endsection