@extends('layout.viajesfull')

@section('content')
<div class="container-fluid modal-pagos-full">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" style="padding: 12px!important" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="info-table">
        <tr>
           <td>
              <div style="text-align: center; margin:10px">
                  <img width="150" class="img-fluid" src="https://alfatur.symbster.com/build/assets/logo-8944cde3.svg" alt="">
              </div>
           </td>
           <td>
             <div class="header mb-0">
                  <p>
                      <strong>ALFATUR Chile</strong><br>
                      Luis Thayer Ojeda, Providencia.<br>
                      Santiago, CHILE.<br>
                      +56974909926<br>
                      contacto@alfaturchile.com<br>
                      www.alfaturchile.com
                  </p>
              </div>
           </td>
        </tr>
    </table>

    <!-- Informações do Cliente -->
    <table class="info-table">
        <tr>
            <td style="padding:0;">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="30%" style="background: #d2d3db; text-align: end; text-align: end;"><strong>Nombre:</strong> </td>
                               <td width="70%">{{ $viaje->nome }}</td>
                           </tr>
                     </tbody>
                </table>
            </td>
            <td style="padding:0">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="30%" style="background: #d2d3db; text-align: end; text-align: end;"><strong>Fecha:</strong> </td>
                               <td width="70%">{{ \Carbon\Carbon::parse($viaje->created_at)->locale('pt')->translatedFormat('l, d-m-y') }}</td>
                           </tr>
                     </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:0">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="50%" style="background: #d2d3db; text-align: end; text-align: end;"><strong>WhatsApp:</strong> </td>
                               <td width="50%">{{ $viaje->telefone }}</td>
                           </tr>
                     </tbody>
                </table>
            </td>
            <td style="padding:0">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="50%" style="background: #d2d3db; text-align: end;"><strong>Vendedor:</strong> </td>
                               <td width="50%">{{ $viaje->vendedor }}</td>
                           </tr>
                     </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:0">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="50%" style="background: #d2d3db; text-align: end;"><strong>E-Mail:</strong> </td>
                               <!-- filepath: /home/edilsonsantos/Documentos/Projetos/alfatur/resources/views/voucher_modal_content.blade.php -->
                            <td width="50%">
                                <div class="d-flex">
                                    {{ $viaje->email }}
                                    <a href="{{ route('email.enviar', ['id' => $viaje->id]) }}" class="ms-5">
                                        <i class="bi bi-envelope-arrow-up-fill" title="Enviar e-mail"></i>
                                    </a>
                                </div>
                            </td>
                           </tr>
                     </tbody>
                </table>
            </td>
            <td style="padding:0">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="50%" style="background: #d2d3db; text-align: end;"><strong>Status:</strong> </td>
                               <td width="50%">{{ $viaje->estado_pagamento }}</td>
                           </tr>
                     </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:0">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="50%" style="background: #d2d3db; text-align: end;"><strong>Hotel:</strong> </td>
                               <td width="50%">{{ $viaje->hotel }}</td>
                           </tr>
                     </tbody>
                </table>
            </td>
            <td style="padding:0">
                <table style="width:100%">
                     <tbody>
                           <tr>
                               <td width="50%" style="background: #d2d3db; text-align: end;"><strong>Dirección:</strong> </td>
                               <td width="50%">{{ $viaje->direcao_hotel }}</td>
                           </tr>
                     </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- Informações dos Tours -->
    <div class="content_titulo">
        <h3>Voucher Financiero #VF-{{ $viaje->id }}</h3>
    </div>
    <table class="tour-table">
        <thead>
            <tr>
                <th><i class="bi bi-ticket-detailed"></i></th>
                <th>ID</th>
                <th>Fecha Tour</th>
                <th>Hora</th>
                <th>Tour</th>
                <th>PAX</th>
                <th>CLP $ x PAX</th>
                <th>CLP $ Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tours as $tour)
            <tr>
                <td><i class="bi bi-ticket-detailed"></i></td>
                <td><strong>ALF-{{ $tour->id }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($tour->data_tour)->locale('pt_BR')->translatedFormat('l d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($tour->created_at)->format('H:i') }}</td>
                <td>{{ $tour->tour }}</td>
                <td style="text-align: center">{{ $tour->pax_adulto + ($tour->pax_infantil ?? 0) }}</td>
                <td>${{ number_format($tour->preco_adulto, 0, ',', '.') }} / Adulto <br> ${{ number_format($tour->preco_infantil, 0, ',', '.') }} / Infantil</td>
                <td>{{ number_format(($tour->preco_adulto * $tour->pax_adulto) + ($tour->preco_infantil * $tour->pax_infantil ?? 0), 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="8" style="padding: 0">
                    <table style="width:100%; padding:0">
                        <tbody>
                            <tr style="padding: 0">
                                <td width="66%" style="border: 0;" target>
                                    <a href="{{ route('vendas.editar', $viaje->id) }}" target="_blank" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                        </svg>
                                        Comprar mas Tours
                                    </a>
                                </td>
                                <td width="34%" style="border: 0;">
                                    <p class="totals total_clp">TOTAL: CLP ${{ number_format($viaje->valor_total, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Informações de Pagamento -->
    <div class="content_titulo_pagos">
        <h3>Pagos</h3>
    </div>
    <table class="payment-table">
        <thead>
            <tr>
                <th>ID</th>
                {{-- <th style="text-align: center"><i class="bi bi-pencil-square"></i></th> --}}
                {{-- <th style="text-align: center">Obs</th> --}}
                <th>Fecha</th>
                <th>Operador</th>
                <th>Forma de Pago</th>
                <th style="text-align: center">Comprobante</th>
                <th>Valor CLP $</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagamentos as $pagamento)
                <tr>
                    <td>PAG-{{ $pagamento->id }}</td>
                    {{-- <td style="text-align: center">
                        <a href="{{ route('vendas.editar', $viaje->id) }}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td> --}}
                    {{-- <td style="text-align: center"><a href="#" title="{{ $pagamento->observacoes }}"><i class="bi bi-chat-text-fill"></i></a></td> --}}
                    <td>{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->locale('pt_BR')->translatedFormat('l d/m/Y') }}</td>
                    <td>{{ $viaje->vendedor }}</td>
                    <td>{{ $pagamento->forma_pagamento }}</td>
                    <td style="text-align: center;">
                        @if ($pagamento->comprovante)
                            <a href="{{ asset($pagamento->comprovante) }}" target="_blank" style="color: #000; text-decoration: underline; text-align:center;">
                                <i class="bi bi-cloud-arrow-down-fill"></i>
                            </a>
                        @else
                            N/A
                        @endif
                    </td>                    
                    <td>
                        {{ '$' . $pagamento->valor_recebido  }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="8" style="padding:0">
                    <table style="width:100%; padding:0; background: #fff;">
                        <tbody>
                            <tr>
                                <td width="66%" style="background: #fff;">
                                    <a href="#" id="openModalBtn" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                        </svg>
                                        Ingressar pago
                                    </a>
                                </td>
                                @php
                                    $totalPagos = 0;

                                    foreach ($pagamentos as $pagamento) { 
                                        $valorPago = str_replace(['.', ','], ['', '.'], $pagamento->valor_recebido); // Remove pontos e troca vírgula por ponto
                                        $totalPagos += floatval($valorPago);
                                    }

                                    $valor_total = floatval($viaje->valor_total);
                                    $diferenca = $valor_total - $totalPagos;
                                @endphp
                                    <p class="totals total-pago">TOTAL PAGOS: CLP $<span class="pagos">{{ number_format($totalPagos, 0, ',', '.') }}</span></p>
                                    <p class="totals total-pendiente">TOTAL PENDIENTE: CLP $<span class="pendente">{{ number_format($valor_total - $totalPagos, 0, ',', '.') }}</span></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Informações de Pagamento -->
    <div class="content_titulo_pasajeros">
        <h3>Passajeros</h3>
    </div>
    <form id="passengerForm">
        @csrf
        <table class="pasajeros-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>RUT/PASSAPORTE</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Nacionalidade</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < 2; $i++)
                <tr>
                    <td>PAX {{ $i + 1 }}</td>
                    <td>
                        <input type="text" name="passengers[{{ $i }}][passport]" 
                               value="{{ old('passengers.' . $i . '.passport') }}" />
                    </td>
                    <td>
                        <input type="text" name="passengers[{{ $i }}][name]" 
                               value="{{ old('passengers.' . $i . '.name') }}" required />
                    </td>
                    <td>
                        <input type="text" name="passengers[{{ $i }}][phone]" 
                               value="{{ old('passengers.' . $i . '.phone') }}" />
                    </td>
                    <td>
                        <select name="passengers[{{ $i }}][nationality]">
                            <option value="Brasil" {{ old('passengers.' . $i . '.nationality') == 'Brasil' ? 'selected' : '' }}>Brasil</option>
                            <option value="Argentina" {{ old('passengers.' . $i . '.nationality') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                            <option value="Chile" {{ old('passengers.' . $i . '.nationality') == 'Chile' ? 'selected' : '' }}>Chile</option>
                        </select>
                    </td>
                </tr>
                @endfor
                <tr>
                    <td colspan="5">
                        <!-- Campo 'venda_id' fora do loop -->
                        <input type="hidden" name="venda_id" value="{{ $viaje->id ?? '' }}">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn" type="submit">Guardar Dados</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>      
    <div class="row">
        <div class="border-1 col-md-12 mt-3">
            <h3>Lista de pasajeros</h3>
        </div>
        <div class="col-md-12 mt-3">
            <ul class="passenger-list" id="passengerList">
                <li>Carregando...</li>
            </ul>
        </div>
    </div>

    <div class="container-fluid text-center mt-5 p-0">
        <div class="p-3" style="background-color: #dfede1">
            <strong>“TERMINOS Y CONDICIONES ALFATUR Chile”</strong> <br>
            <a href="{{ Vite::asset('resources/images/TEC.pdf') }}" target="_blank">Haga clic para ver</a>
        </div>
        <div class="p-3" style="background-color: #dee047">
            <span style="color: red">En caso de emergencia, contactar a: +56974909926</span>
        </div>
    </div>
</div>


<!-- Modal de Adicionar Pagamento -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Adicionar Pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pagamentoForm">
                    @csrf
                    <input type="hidden" name="venda_id" value="{{ $viaje->id ?? '' }}">
                
                    <div class="mb-3">
                        <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
                        <select name="forma_pagamento" class="form-select" id="forma_pagamento" required>
                            <option value="" selected="selected">Seleccione...</option>
                            <option value="Efectivo en Van">Efectivo en Van</option>
                            <option value="Efectivo Oficina">Efectivo Oficina</option>
                            <option value="Tarjeta de Credito">Tarjeta de Crédito</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data_pagamento" class="form-label">Data do Pagamento</label>
                        <input type="date" class="form-control" id="data_pagamento" name="data_pagamento" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor_pago" class="form-label">Valor Atual (CLP $)</label>
                        <input type="text" class="form-control" id="valor_atual" required value="" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="valor_pago" class="form-label">Valor Pago (CLP $)</label>
                        <select name="valor_pago" id="percentage" class="form-select" required>
                            <option value="" disabled selected>Selecione um percentual</option>
                            <?php for ($i = 1; $i <= 100; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?>%</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="valor_a_pagar" class="form-label">Valor a Pagar (CLP $)</label>
                        <input type="text" class="form-control" id="valor_a_pagar" name="valor_a_pagar" required>
                    </div>

                    <input type="hidden" id="valor_recebido" name="valor_recebido" value="">

                    <div class="mb-3">
                        <label for="estado_pagamento" class="form-label">Estado do Pagamento</label>
                        <select class="form-control" id="estado_pagamento" name="estado_pagamento" required>
                            <option value="pendente">Pendente</option>
                            <option value="pago">Pago</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comprovante" class="form-label">Comprovante</label>
                        <input type="file" class="form-control" id="comprovante" name="comprovante">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Pagamento</button>
                </form>
                
                <!-- Exibir mensagens -->
                <div id="mensagem" style="margin-top: 10px;"></div>
                
                
                <!-- Exibir mensagens -->
                <div id="mensagem" style="margin-top: 10px;"></div>                
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Ao clicar no botão, abrir o modal
            $('#openModalBtn').click(function() {
                $('#addPaymentModal').modal('show');
                var pendente =  $('.pendente').text();
                console.log(pendente);
                $("#valor_atual").val(pendente);

            });
        });

        $('#percentage, #valor_atual').on('input change', function () {
            // Remove possíveis separadores de milhares e converte para número
            let valorTotal = parseFloat($('#valor_atual').val().replace(/\./g, '').replace(',', '.')) || 0;
            let percentage = parseInt($('#percentage').val()) || 0;

            if (valorTotal > 0 && percentage > 0) {
                let valorRecebido = (valorTotal * percentage) / 100; // Valor retirado (percentual aplicado)
                let valorAPagar = valorTotal - valorRecebido; // Valor restante após retirada

                // Formata os resultados com separadores de milhares e sem decimais
                $('#valor_a_pagar').val(new Intl.NumberFormat('es-CL', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(valorAPagar));

                $('#valor_recebido').val(new Intl.NumberFormat('es-CL', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(valorRecebido));

            } else {
                $('#valor_a_pagar').val('');
                $('#valor_recebido').val('');
            }
        });


        $(document).ready(function() {
            $('#pagamentoForm').submit(function(e) {
                e.preventDefault(); // Impede o envio tradicional

                let formData = new FormData(this); // FormData para permitir envio de arquivos

                $.ajax({
                    url: "{{ route('pagamento.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false, // Necessário para enviar arquivos
                    contentType: false, // Necessário para enviar arquivos
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#mensagem').html('<div class="alert alert-success">' + response.message + '</div>');
                    
                        Swal.fire({
                            title: "Pagamento adicionado.",
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: "Ok",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#pagamentoForm')[0].reset(); 
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        $.each(errors, function(key, value) {
                            errorMessages += '<li>' + value + '</li>';
                        });

                        $('#mensagem').html('<div class="alert alert-danger"><ul>' + errorMessages + '</ul></div>');
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function () {
        // Função para carregar passageiros
        function loadPassengers() {
            let vendaId = $('input[name="venda_id"]').val();

            if (vendaId) {
                $.ajax({
                    url: `/passengers/${vendaId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let passengerList = $('#passengerList');
                        passengerList.empty();

                        if (response.length > 0) {
                            response.forEach((passenger, index) => {
                                passengerList.append(`
                                    <li>
                                        <div><i class="bi bi-person-badge-fill"></i>: ${passenger.name} - ${passenger.passport ?? 'Sem passaporte'} - ${passenger.phone}- ${passenger.nationality}</div>
                                        <button class="removePassenger" data-id="${passenger.id}"><i class="bi bi-trash3"></i></button>
                                    </li>
                                `);
                            });
                        } else {
                            passengerList.append('<li>No se registraron pasajeros.</li>');
                        }
                    },
                    error: function(xhr) {
                        alert("Erro ao carregar passageiros.");
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        loadPassengers();

        // Cadastro de passageiros
        $("#passengerForm").on("submit", function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('passengers.store') }}",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function () {
                    alert("Passageiros cadastrados com sucesso!");
                    Swal.fire({
                        title: "Pasajeros registrados exitosamente",
                        icon: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ok"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $("#passengerForm")[0].reset(); 
                            loadPassengers(); 
                        }
                    });
                },
                error: function (xhr) {
                    alert("Erro ao cadastrar passageiros!");
                    console.log(xhr.responseText);
                }
            });
        });

        // Remover passageiro
        $(document).on("click", ".removePassenger", function () {
            let passengerId = $(this).data("id");

            if (confirm("Deseja remover este passageiro?")) {
                $.ajax({
                    url: `/passengers/${passengerId}`, // Agora a URL contém o ID correto
                    type: 'DELETE',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (response) {
                        alert(response.message);
                        loadPassengers(); // Atualiza a lista após remoção
                    },
                    error: function () {
                        alert("Erro ao remover passageiro.");
                    }
                });
            }
        });
    });
</script>


@endsection
