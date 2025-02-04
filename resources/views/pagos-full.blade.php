@extends('layout.masterdash')



@section('content')
<div class="content-tabelas">
    <div class="container">
        <div class="card">
            <div class="card-header">
                TODOS LOS VIAJES POR RECAUDACION
            </div>
            <div class="card-body table">
                <div class="mb-3 text-end button-filtros">
                    <a href="{{ route('pagos.full') }}" class="btn btn-primary {{ request('estado') == '' ? 'active' : '' }}">
                        Todos
                    </a>
                    <a href="{{ route('pagos.full', ['estado' => 'recaudado']) }}" class="btn btn-success {{ request('estado') == 'recaudado' ? 'active' : '' }}">
                        Recaudado
                    </a>
                    <a href="{{ route('pagos.full', ['estado' => 'no-recaudado']) }}" class="btn btn-danger {{ request('estado') == 'no-recaudado' ? 'active' : '' }}">
                        No Recaudado
                    </a>
                </div>
            
                <table class="table table-striped logistica">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Reservas</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data</th>
                            <th scope="col" style="text-align: right">Total</th>
                            <th scope="col" style="text-align: right">A Pagar</th>
                            <th scope="col" style="text-align: center">Comprovante</th>
                            <th scope="col" style="text-align: center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pagos as $pago)
                        <tr>
                            <td data-label="ID">VF-{{ $pago->id }}</td>
                            <td data-label="Reservas">{{ $pago->id }}</td>
                            <td data-label="Nome">{{ $pago->nome }}</td>
                            <td data-label="Data">{{ \Carbon\Carbon::parse($pago->data_pagamento)->locale('es')->translatedFormat('l d-m') }}</td>
                            <td data-label="Total"  style="text-align: right">{{ '$' . number_format($pago->valor_total, 0, ',', '.') }}</td>
                            <td data-label="A Pagar" style="text-align: right">{{ '$' . number_format($pago->valor_a_pagar, 0, ',', '.') }}</td>
                            <td data-label="Comprovante" style="text-align: center">
                                @php
                                    $extensao = strtolower(pathinfo($pago->comprovante, PATHINFO_EXTENSION)); // Garantir comparação insensível a maiúsculas
                                @endphp
                                @if(in_array($extensao, ['jpg', 'jpeg', 'png', 'gif']))
                                    @isset($pago->comprovante) <!-- Verifica se o usuário tem um comprovante -->
                                        <!-- Link com atributo 'data-lightbox' para Lightbox -->
                                        <a style="color: green; font-size:22px" href="{{ asset($pago->comprovante) }}" data-lightbox="comprovante-{{$pago->id}}" data-title="Comprovante de Venda" target="_blank"><i class="bi bi-images"></i></a>
                                    @else
                                        N/A
                                    @endisset
                                @elseif($extensao === 'pdf')
                                    <a style="color: green; font-size:22px" href="{{ asset($pago->comprovante) }}" target="_blank"><i class="bi bi-filetype-pdf"></i></a>
                                @else
                                    <span>Arquivo não suportado</span>
                                @endif
                            </td>
                            <td data-label="Estado" style="text-align: center">
                                <span style="padding: 5px; font-size: 16px" class="badge {{ $pago->estado_pagamento == 'Recaudado' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $pago->estado_pagamento }}
                                </span>
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
