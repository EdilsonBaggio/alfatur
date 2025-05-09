@extends('layout.masterdash')
@section('content')
<div class="content-tabelas">
    <div class="container">
        <div class="card">
            <div class="card-header">
              Lista de usuários
            </div>
            <div class="card-body">
              <div class="content-table">
                  <table id="tabela-usuarios" class="display table responsive mt-4" style="width: 100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Nível</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                      <tr>
                        <td>
                          <div class="id_usuario">
                            #{{ $user->id }}
                          </div>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                          <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Editar</a>
                          @if ($user->is_active)
                          <form action="{{ route('users.deactivate', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Desativar este usuário?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning btn-sm">Desativar</button>
                          </form>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>

            <div class="card-header">
              Usuários Inativos
            </div>
            <div class="card-body">
              <div class="content-table">
                @if($usersInactive->count())
                <table id="tabela-inativos" class="display table responsive mt-2" style="width: 100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Nível</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($usersInactive as $user)
                    <tr>
                      <td>
                        <div class="id_usuario">
                          #{{ $user->id }}
                        </div>
                      </td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->role }}</td>
                      <td>
                        <form action="{{ route('users.activate', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Ativar este usuário?');">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-success btn-sm">Ativar</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif
                
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

<script>
  $(document).ready(function(){
    $('#tabela-usuarios').DataTable({
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
        }
    });
    $('#tabela-inativos').DataTable({
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
        }
    });
    $(".celular").mask('(00) 00000-0000');
  });
</script>

@endsection
