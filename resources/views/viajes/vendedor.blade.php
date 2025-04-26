@extends('layout.masterdash')

@section('content')
<div class="content-tabelas">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Todos los viajes
            </div>
            <div class="card-body table">
                <form class="row g-3 my-3 justify-content-md-center" method="GET" action="{{ route('viajes.vendedor') }}">
                    <div class="col-md-3">
                        <label for="vendedor" class="form-label">Filtrar por Vendedor</label>
                        <select class="form-select" id="vendedor" name="vendedor">
                            <option value="todos" {{ request('vendedor') == 'todos' ? 'selected' : '' }}>Todos</option>
                            @foreach ($todosVendedores as $vendedor)
                                <option value="{{ $vendedor }}" {{ request('vendedor') == $vendedor ? 'selected' : '' }}>
                                    {{ $vendedor }}
                                </option>
                            @endforeach
                        </select>                        
                    </div>
            
                    <div class="col-md-3">
                        <label for="data_inicio" class="form-label">Desde</label>
                        <input type="date" id="data_inicio" name="data_inicio" class="form-control"
                               value="{{ $dataInicio }}">
                    </div>
            
                    <div class="col-md-3">
                        <label for="data_fim" class="form-label">Até</label>
                        <input type="date" id="data_fim" name="data_fim" class="form-control"
                               value="{{ $dataFim }}">
                    </div>
            
                    {{-- <div class="col-md-3">
                        <label for="tour" class="form-label">Tour</label>
                        <select class="form-select" id="tour" name="tour">
                            <option value="">Selecione Tour</option>
                            @php
                                $tours = $vendasReservadas->flatMap->tours->pluck('tour')->unique();
                            @endphp
                            @foreach ($tours as $tour)
                                <option value="{{ $tour }}" {{ request('tour') == $tour ? 'selected' : '' }}>{{ $tour }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col-md-1">
                        <label class="form-label mb-3"></label>
                        <button class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            
                <div class="alert alert-warning text-center">
                    Intervalo de tiempo: <strong>{{ \Carbon\Carbon::parse($dataInicio)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($dataFim)->format('d-m-Y') }}</strong>
                </div>
            
                {{-- VIAGENS REALIZADAS --}}
                <h4 class="bg-info text-white p-3">Viagens Reservadas</h4>
                <table class="table table-bordered table-sm text-center logistica">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Vendedor</th>
                            <th scope="col">Guia</th>
                            <th scope="col">Condutor</th>
                            <th scope="col">Tour</th>
                            <th scope="col">PAX</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Descontos</th>
                            <th scope="col">Livre</th>
                            <th scope="col">% Comissão venda</th>
                            <th scope="col">Pago Com.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPaxRealizadas = 0;
                            $totalPreco = 0;
                            $totalDescontos = 0;
                            $totalLivre = 0;
                        @endphp
                        @foreach ($vendasReservadas as $venda)
                            @php
                                $pax = 1; // ou pegar de outro campo se tiver
                                $totalPaxRealizadas += $pax;
                                $totalPreco += $venda->valor_total;
                                $totalLivre += $venda->valor_pago;
                                $totalDescontos += $venda->valor_a_pagar;
                            @endphp
                            <tr>
                                <td data-label="Data">{{ $venda->created_at->format('d-m-y') }}</td>
                                <td data-label="ID">VAL-{{ $venda->logistica->venda_id ?? 'N/A' }}</td>
                                <td data-label="Nome">{{ $venda->nome }}</td>
                                <td data-label="Vendedor">{{ $venda->vendedor }}</td>
                                <td data-label="Guia">{{ \App\Models\User::find(optional($venda->logistica)->guia)->name ?? 'Asignar' }}</td>
                                <td data-label="Condutor">{{ \App\Models\User::find(optional($venda->logistica)->condutor)->name ?? 'Asignar' }}</td>
                                <td data-label="Tour">
                                    @foreach ($venda->tours as $tour)
                                        {{ $tour->tour }}<br>
                                    @endforeach
                                </td>
                                <td data-label="PAX">{{ $pax }}</td>
                                <td data-label="Telefone">{{ $venda->telefone }}</td>
                                <td class="bg-success text-white" data-label="Preço">${{ number_format($venda->valor_total, 0, ',', '.') }}</td>
                                <td class="bg-danger text-white" data-label="Descontos">${{ number_format($venda->valor_a_pagar, 0, ',', '.') }}</td>
                                <td class="bg-primary text-white" data-label="Livre">${{ number_format($venda->valor_pago, 0, ',', '.') }}</td>
                                @php
                                    $percentual = $venda->user->commission_percentage ?? 0;
                                    $comissao = ($venda->valor_pago ?? 0) * ($percentual / 100);
                                @endphp
                                <td data-label="% Comissão venda">{{ $percentual }}%</td>
                                <td data-label="Pago Com.">${{ number_format($comissao, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold bg-light">
                            <td colspan="7" class="text-end">TOTAL PAX:</td>
                            <td>{{ $totalPaxRealizadas }}</td>
                            <td></td>
                            <td class="text-success">${{ number_format($totalPreco, 0, ',', '.') }}</td>
                            <td class="text-danger">${{ number_format($totalDescontos, 0, ',', '.') }}</td>
                            <td class="text-primary">${{ number_format($totalLivre, 0, ',', '.') }}</td>
                            <td colspan="2">$0</td>
                        </tr>
                    </tbody>
                </table>
            
                {{-- VIAGENS RESERVADAS --}}
                <h4 class="bg-warning text-dark p-3 mt-4">Viagens Confirmadas</h4>
                <table class="table table-bordered table-sm text-center logistica">
                    <thead class="table-warning">
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Vendedor</th>
                            <th scope="col">Guia</th>
                            <th scope="col">Condutor</th>
                            <th scope="col">Tour</th>
                            <th scope="col">PAX</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Descontos</th>
                            <th scope="col">Livre</th>
                            <th scope="col">% Comissão venda</th>
                            <th scope="col">Pago Com.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendasConfirmadas as $venda)
                            <tr>
                                <td data-label="Data">{{ $venda->created_at->format('d-m-y') }}</td>
                                <td data-label="ID">VAL-{{ $venda->logistica->venda_id ?? 'N/A' }}</td>
                                <td data-label="Nome">{{ $venda->nome }}</td>
                                <td data-label="Vendedor">{{ $venda->vendedor }}</td>
                                <td data-label="Guia">{{ \App\Models\User::find(optional($venda->logistica)->guia)->name ?? 'Asignar' }}</td>
                                <td data-label="Condutor">{{ \App\Models\User::find(optional($venda->logistica)->condutor)->name ?? 'Asignar' }}</td>
                                <td data-label="Tour">
                                    @foreach ($venda->tours as $tour)
                                        {{ $tour->tour }}<br>
                                    @endforeach
                                </td>
                                <td data-label="PAX">1</td>
                                <td data-label="Telefone">{{ $venda->telefone }}</td>
                                <td data-label="Preço" class="bg-success text-white">${{ number_format($venda->valor_total, 0, ',', '.') }}</td>
                                <td data-label="Descontos" class="bg-danger text-white">${{ number_format($venda->valor_a_pagar, 0, ',', '.') }}</td>
                                <td data-label="Livre" class="bg-primary text-white">${{ number_format($venda->valor_pago, 0, ',', '.') }}</td>
                                @php
                                    $percentual = $venda->user->commission_percentage ?? 0;
                                    $comissao = ($venda->valor_pago ?? 0) * (floatval($percentual) / 100);
                                @endphp
                                <td data-label="% Comissão venda">{{ $percentual }}%</td>
                                <td data-label="Pago Com.">${{ number_format($comissao, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>          
    </div>
</div>
@endsection

