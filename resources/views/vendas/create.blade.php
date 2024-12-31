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
                        <label for="nome">Nombre:</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telefone">Teléfono:</label>
                        <input type="text" name="telefone" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hotel">Hotel:</label>
                        <input type="text" name="hotel" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zona">Zona:</label>
                        <select name="zona" class="form-select" id="zona" required>
                            <option value="" selected="selected">Seleccione...</option>
                            <option value="Estacion Central">Estacion Central</option>
                            <option value="Centro">Centro</option>
                            <option value="Providencia">Providencia</option>
                            <option value="Las Condes">Las Condes</option>
                            <option value="Otro">Otro</option>
                            <option value="Ñao Sei">Ñao Sei</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="direcao_hotel">Dirección Hotel:</label>
                        <input type="text" name="direcao_hotel" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="habitacao">Habitacion:</label>
                        <input type="text" name="habitacao" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pais_origem">País de Origem:</label>
                        <input type="text" name="pais_origem" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="idioma">Idioma:</label>
                        <input type="text" name="idioma" class="form-control">
                    </div>
                </div>

                <!-- Tours -->
                <div class="row dados" id="tours-container">
                    <div class="col-md-12 pt-4 pb-4">
                        <h3>Tours</h3>
                    </div>
                    <div class="tour-item col-md-12">
                        <!-- Tour 1 -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tour">Tour:</label>
                                <input type="text" name="tour[]" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="data_tour">Data Tour:</label>
                                <input type="date" name="data_tour[]" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pax_adulto">PAX Adulto:</label>
                                <input type="number" name="pax_adulto[]" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="preco_adulto">Preço Adulto:</label>
                                <input type="number" step="0.01" name="preco_adulto[]" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pax_infantil">PAX Infantil:</label>
                                <input type="number" name="pax_infantil[]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="preco_infantil">Preço Infantil:</label>
                                <input type="number" step="0.01" name="preco_infantil[]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botão para adicionar mais tours -->
                <div class="pt-4">
                    <button type="button" id="add-tour" class="btn btn-primary">+ Tour</button>
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
@section('script')
<script>
    $(document).ready(function () {
        let tourIndex = 1; // Índice inicial para IDs únicos nos tours

        $('#add-tour').on('click', function () {
            // Clonar o primeiro bloco de tour
            let newTour = $('.tour-item:first').clone();

            // Atualizar o índice para garantir IDs únicos
            newTour.find('input, select').each(function () {
                let name = $(this).attr('name').replace('[]', '[' + tourIndex + ']'); // Adiciona índice
                $(this).attr('name', name); // Atualiza o nome
                $(this).val(''); // Limpa o valor
            });

            // Adicionar o novo bloco ao container
            $('#tours-container').append(newTour);
            tourIndex++;
        });
    });
</script>
@endsection