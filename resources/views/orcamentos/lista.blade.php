@extends('layout.masterdash')

@section('content')
<div class="content-tabelas">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Orçamentos
            </div>
            <div class="card-body">
              <div class="content-table">
                <table id="orcamentosTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Hotel</th>
                            <th>Idioma</th>
                            <th>Valor Total</th>
                            <th>Data</th>
                            <th>Tours</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orcamentos as $orcamento)
                            <tr>
                                <td>{{ $orcamento->nome }}</td>
                                <td>{{ $orcamento->email }}</td>
                                <td>{{ $orcamento->telefone }}</td>
                                <td>{{ $orcamento->hotel }}</td>
                                <td>{{ $orcamento->idioma }}</td>
                                <td>CLP {{ number_format($orcamento->valor_total, 0, ',', '.') }}</td>
                                <td>{{ $orcamento->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if ($orcamento->tours->count())
                                        <ul class="mb-0 ps-3">
                                            @foreach ($orcamento->tours as $tour)
                                                <li>
                                                    <strong>{{ $tour->tour }}</strong> - 
                                                    {{ $tour->data_tour }} | 
                                                    Adultos: {{ $tour->pax_adulto }} | 
                                                    Infantis: {{ $tour->pax_infantil }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        Nenhum
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('vendas.criarDeOrcamento', $orcamento->id) }}" class="btn btn-success btn-sm mb-1">Criar Venda</a>
                                
                                    <form action="{{ route('orcamentos.destroy', $orcamento->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este orçamento?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
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

@section('scripts')
    <!-- DataTables CSS e JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#orcamentosTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
                },
                pageLength: 10,
                responsive: true
            });
        });
    </script>
@endsection
