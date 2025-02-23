@extends('layout.masterdash')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
          Editar Venda - {{ $venda->id }}
        </div>
        <div class="card-body">
            <form action="{{ route('vendas.update', $venda->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <input type="hidden" name="comissao" value="{{ auth()->user()->commission_percentage }}">

                <!-- Vendedor -->
                <div class="form-group">
                    <label for="vendedor">Vendedor:</label>
                    <input type="text" value="{{ old('vendedor', $venda->vendedor) }}" name="vendedor" class="form-control" required>
                </div>

                <!-- Dados -->
                <div class="row dados">
                    <div class="col-md-12 pt-4 pb-4">
                        <h3>Dados</h3>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" class="form-control" value="{{ old('nome', $venda->nome) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" class="form-control" value="{{ old('telefone', $venda->telefone) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $venda->email) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hotel">Hotel:</label>
                        <input type="text" name="hotel" class="form-control" value="{{ old('hotel', $venda->hotel) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zona">Zona:</label>
                        <select name="zona" class="form-select" id="zona" required>
                            <option value="" disabled>Seleccione...</option>
                            @foreach (['Estacion Central', 'Centro', 'Providencia', 'Las Condes', 'Otro', 'Ñao Sei'] as $zona)
                                <option value="{{ $zona }}" {{ old('zona', $venda->zona) == $zona ? 'selected' : '' }}>{{ $zona }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="direcao_hotel">Direção Hotel:</label>
                        <input type="text" name="direcao_hotel" class="form-control" value="{{ old('direcao_hotel', $venda->direcao_hotel) }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="habitacao">Habitação:</label>
                        <input type="text" name="habitacao" class="form-control" value="{{ old('habitacao', $venda->habitacao) }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pais_origem">País de Origem:</label>
                        <input type="text" name="pais_origem" class="form-control" value="{{ old('pais_origem', $venda->pais_origem) }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="idioma">Idioma:</label>
                        <input type="text" name="idioma" class="form-control" value="{{ old('idioma', $venda->idioma) }}">
                    </div>
                </div>

                <!-- Tours -->
                <div class="row dados" id="tours-container">
                    <div class="col-md-12 pt-4 pb-4">
                        <h3>Tours</h3>
                    </div>

                    @foreach ($venda->tours as $index => $tour)
                        <div class="tour-item col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="tour">Tour:</label>
                                    <select name="tour[]" class="form-select" required>
                                        <option value="" selected>Seleccione...</option>
                                        @foreach($tourPlaces as $id => $name)
                                            <option value="{{ $name }}" {{ old("tour.$index", $tour->tour) == $name ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="data_tour">Data Tour:</label>
                                    <input type="date" name="data_tour[]" class="form-control" value="{{ old("data_tour.$index", $tour->data_tour) }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pax_adulto">PAX Adulto:</label>
                                    <input type="text" name="pax_adulto[]" class="form-control pax" maxlength="3" value="{{ old("pax_adulto.$index", $tour->pax_adulto) }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="preco_adulto">Preço Adulto:</label>
                                    <input type="text" name="preco_adulto[]" class="form-control" 
                                           value="{{ old("preco_adulto.$index", number_format($tour->preco_adulto, 0, ',', '.')) }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pax_infantil">PAX Infantil:</label>
                                    <input type="text" name="pax_infantil[]" maxlength="3" class="pax form-control" value="{{ old("pax_infantil.$index", $tour->pax_infantil) }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="preco_infantil">Preço Infantil:</label>
                                    <input type="text" name="preco_infantil[]" class="form-control" 
                                           value="{{ old("preco_infantil.$index", number_format($tour->preco_infantil, 0, ',', '.')) }}">
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger mb-3 remove-tour">x</button>
                        </div>
                    @endforeach
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
                        <select name="estado_pagamento" id="estado_pagamento" class="form-select" required>
                            <option value="Pendiente" {{ old('estado_pagamento', $venda->estado_pagamento) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Recaudado" {{ old('estado_pagamento', $venda->estado_pagamento) == 'Recaudado' ? 'selected' : '' }}>Recaudado</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="forma_pagamento">Forma de Pagamento:</label>
                        <select name="forma_pagamento" class="form-select" id="forma_pagamento" required>
                            @foreach (['Efectivo en Van', 'Efectivo Oficina', 'Tarjeta de Credito', 'Transferencia'] as $forma)
                                <option value="{{ $forma }}" {{ old('forma_pagamento', $venda->forma_pagamento) == $forma ? 'selected' : '' }}>{{ $forma }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="data_pagamento">Data de Pagamento:</label>
                        <input type="date" name="data_pagamento" class="form-control" value="{{ old('data_pagamento', $venda->data_pagamento) }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor_total">Valor Total:</label>
                        <input type="text" name="valor_total" id="valor_total" class="form-control" value="{{ number_format($venda->valor_total, 0, ',', '.') }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor_pago">Valor Pago (%):</label>
                        <select name="valor_pago" id="percentage" class="form-select" required>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ old('valor_pago', $venda->valor_pago) == $i ? 'selected' : '' }}>{{ $i }}%</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor_a_pagar">Valor a Pagar:</label>
                        <input type="text" name="valor_a_pagar" id="valor_a_pagar" class="form-control" value="{{ old('valor_a_pagar', number_format($venda->valor_a_pagar, 0, ',', '.')) }}" readonly>
                    </div>
                </div>

                <!-- Observações e Comprovante -->
                <div class="form-group">
                    <label for="observacoes">Observações:</label>
                    <textarea name="observacoes" class="form-control">{{ old('observacoes', $venda->observacoes) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="comprovante">Comprovante:</label>
                    <input type="file" name="comprovante">
                </div>

                <input type="hidden" name="status" value="{{ old('status', $venda->status) }}">

                <!-- Botão -->
                <button type="submit" class="btn btn-primary">Atualizar Venda</button>
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

            // Adicionar botão de remoção ao novo bloco
            newTour.append('<button type="button" class="btn btn-danger mb-3 remove-tour">x</button>');

            // Adicionar o novo bloco ao container
            $('#tours-container').append(newTour);
            tourIndex++;
        });

        // Evento para remover o bloco de tour
        $(document).on('click', '.remove-tour', function () {
            $(this).closest('.tour-item').remove();
        });
        $('#telefone').mask('+00 00900000000');
        $('.pax').mask('000');
        $('#percentage, #valor_total').on('input change', function () {
            // Remove possíveis separadores de milhares e converte para número
            let valorTotal = parseFloat($('#valor_total').val().replace(/\./g, '').replace(',', '.')) || 0;
            let percentage = parseInt($('#percentage').val()) || 0;

            if (valorTotal > 0 && percentage > 0) {
                let valorPago = (valorTotal * percentage) / 100;
                let valorAPagar = valorTotal - valorPago;

                // Formata o resultado com separadores de milhares e sem decimais
                $('#valor_a_pagar').val(new Intl.NumberFormat('es-CL', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(valorAPagar));
            } else {
                $('#valor_a_pagar').val('');
            }
        });

        function calcularValorTotal() {
            let total = 0;

            $('.tour-item').each(function () {
                let paxAdulto = parseInt($(this).find('[name^="pax_adulto"]').val()) || 0;
                let precoAdulto = parseFloat($(this).find('[name^="preco_adulto"]').val()) || 0;
                let paxInfantil = parseInt($(this).find('[name^="pax_infantil"]').val()) || 0;
                let precoInfantil = parseFloat($(this).find('[name^="preco_infantil"]').val()) || 0;

                total += (paxAdulto * precoAdulto) + (paxInfantil * precoInfantil);
            });

            $('#valor_total').val(total); // Atualiza o campo com 2 casas decimais
        }

        // Atualizar o valor total quando os inputs forem alterados
        $(document).on('input', '[name^="pax_adulto"], [name^="preco_adulto"], [name^="pax_infantil"], [name^="preco_infantil"]', function () {
            calcularValorTotal();
        });

        // Também calcular ao adicionar ou remover tours
        $('#add-tour').on('click', function () {
            setTimeout(calcularValorTotal, 100); // Pequeno delay para garantir a atualização
        });

        $(document).on('click', '.remove-tour', function () {
            setTimeout(calcularValorTotal, 100);
        });

        calcularValorTotal(); // Chamada inicial
    });
</script>
@endsection