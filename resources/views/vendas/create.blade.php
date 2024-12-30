@extends('layout.masterdash')
@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
          Vendas
        </div>
        <div class="card-body">
            <form action="{{ route('vendas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <!-- Vendedor -->
                <div class="form-group">
                    <label for="vendedor">Vendedor:</label>
                    <input type="text" value="{{ Auth::user()->name }}" name="vendedor" class="form-control" required>
                </div>

                <!-- Dados -->
                <div class="row dados">
                    <div class="col-md-12 pt-4 pb-4">
                        <h3>Dados</h3>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telefone">Telefone:</label>
                        <input type="text" name="telefone" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hotel">Hotel:</label>
                        <input type="text" name="hotel" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zona">Zona:</label>
                        <input type="text" name="zona" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="direcao_hotel">Direção Hotel:</label>
                        <input type="text" name="direcao_hotel" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="habitacao">Habitação:</label>
                        <input type="text" name="habitacao" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pais_origem">País:</label>
                        <input type="text" name="pais_origem" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="idioma">Idioma:</label>
                        <input type="text" name="idioma" class="form-control">
                    </div>
                </div>

                <!-- Tours -->
                <div class="row dados">
                    <div class="col-md-12 pt-4 pb-4">
                        <h3>Tours</h3>
                    </div>

                    <!-- Tour 1 -->
                    <div class="form-group col-md-6">
                        <label for="tour">Tour:</label>
                        <input type="text" name="tour" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="data_tour">Data Tour:</label>
                        <input type="date" name="data_tour" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pax_adulto">PAX Adulto:</label>
                        <input type="number" name="pax_adulto" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="preco_adulto">Preço Adulto:</label>
                        <input type="number" step="0.01" name="preco_adulto" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pax_infantil">PAX Infantil:</label>
                        <input type="number" name="pax_infantil" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="preco_infantil">Preço Infantil:</label>
                        <input type="number" step="0.01" name="preco_infantil" class="form-control">
                    </div>
                </div>

                <!-- Pagamento -->
                <div class="row dados">
                    <div class="col-md-12 pt-4 pb-4">
                        <h3>Pagamentos</h3>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="estado_pagamento">Estado do Pagamento:</label>
                        <input type="text" name="estado_pagamento" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="forma_pagamento">Forma de Pagamento:</label>
                        <input type="text" name="forma_pagamento" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="data_pagamento">Data do Pagamento:</label>
                        <input type="date" name="data_pagamento" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor_total">Valor Total:</label>
                        <input type="number" step="0.01" name="valor_total" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor_pago">Valor Pago:</label>
                        <input type="number" step="0.01" name="valor_pago" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor_a_pagar">Valor a Pagar:</label>
                        <input type="number" step="0.01" name="valor_a_pagar" class="form-control">
                    </div>
                </div>

                <!-- Observações e Comprovante -->
                <div class="form-group">
                    <label for="observacoes">Observações:</label>
                    <textarea name="observacoes" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="comprovante">Comprovante:</label>
                    <input type="file" name="comprovante">
                </div>

                <!-- Botão -->
                <button type="submit" class="btn btn-primary">Salvar Venda</button>
            </form>
        </div>
    </div>
</div>
@endsection
