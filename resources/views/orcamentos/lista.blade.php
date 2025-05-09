@extends('layout.masterdash')

@section('content')
<div class="content-tabelas">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Orçamentos
            </div>
            <div class="card-body table">
                <table class="table table-striped logistica">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Hotel</th>
                            <th scope="col">Idioma</th>
                            <th scope="col">Valor Total</th>
                            <th scope="col">Data</th>
                            <th scope="col">Tours</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orcamentos as $orcamento)
                            <tr>
                                <td data-label="Nome">{{ $orcamento->nome }}</td>
                                <td data-label="Email">{{ $orcamento->email }}</td>
                                <td data-label="Telefone">{{ $orcamento->telefone }}</td>
                                <td data-label="Hotel">{{ $orcamento->hotel }}</td>
                                <td data-label="Idioma">{{ $orcamento->idioma }}</td>
                                <td data-label="Valor Total">CLP {{ number_format($orcamento->valor_total, 0, ',', '.') }}</td>
                                <td data-label="Data">{{ $orcamento->created_at->format('d/m/Y') }}</td>
                                <td data-label="Tours">
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
                                <td data-label="Ação">
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
@endsection

@section('scripts')
@endsection
