<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Financiero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 90%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-left: 150px;
            text-align:left;
            line-height:22px;
        }
        .header img {
            max-width: 150px;
        }
        .info-table, .tour-table, .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td, .tour-table th, .tour-table td, .payment-table th, .payment-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .info-table td {
            width: 50%;
        }
        .tour-table th {
            background-color: #000000;
            color:#ffffff;
        }
        .tour-table tr td {
          color: #f15a76;
        }
        .payment-table th {
            background: #7abda4;
        }
        .payment-table tr td {
            background: #b9eedb;
        }
        .totals {
            text-align: right;
            font-weight: bold;
            margin: 0px;
        }
        .totals .total-pendiente {
            color: red;
        }
        .content_titulo{
            padding: 20px;
            background: #f15a76;
            text-align:center
        }
        .content_titulo_pagos{
            padding: 5px;
            background: #fdf16373;
            text-align:center
        }

        .total_clp{
            padding: 15px;
            background-color: #9eadff;
            color: #fff
        }

        .total-pago{
            padding: 15px;
            background-color: #7abda4
        }

        .total-pendiente{
            padding: 15px;
            background-color: #eaee16
        }
        
        .btn {
            color: #000;
            font-size: 16px;
            font-weight: bold;
            background: #fff;
            border: 1px solid #cdcdcd;
            padding: 15px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="info-table">
            <tr>
               <td>
                  <div style="text-align: center; margin:10px">
                    <img width="150" class="img-fluid" src="{{ Vite::asset('resources/images/logo-8944cde3.jpg') }}" alt="">
                  </div>
               </td>
               <td>
                 <div class="header">
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
                                   <td width="70%">{{ $venda->nome }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="30%" style="background: #d2d3db; text-align: end; text-align: end;"><strong>Fecha:</strong> </td>
                                   <td width="70%">{{ $venda->created_at->format('d-m-Y') }}</td>
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
                                   <td width="50%">{{ $venda->telefone }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="50%" style="background: #d2d3db; text-align: end;"><strong>Vendedor:</strong> </td>
                                   <td width="50%">{{ $venda->vendedor }}</td>
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
                                   <td width="50%">{{ $venda->email }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="50%" style="background: #d2d3db; text-align: end;"><strong>Status:</strong> </td>
                                   <td width="50%">{{ $venda->estado_pagamento }}</td>
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
                                   <td width="50%">{{ $venda->hotel }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="50%" style="background: #d2d3db; text-align: end;"><strong>Dirección:</strong> </td>
                                   <td width="50%">{{ $venda->direcao_hotel }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Informações dos Tours -->
        <div class="content_titulo">
            <h3>Voucher Financiero #VF-{{ $venda->id }}</h3>
        </div>
        <table class="tour-table">
            <thead>
                <tr>
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
                    <td colspan="7" style="padding: 0">
                        <table style="width:100%; padding:0">
                            <tbody>
                                <tr style="padding: 0">
                                    <td width="66%" style="border: 0;">
                                    </td>
                                    <td width="34%" style="border: 0;">
                                        <p class="totals total_clp">TOTAL: CLP ${{ number_format($venda->valor_total, 0, ',', '.') }}</p>
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
                        <td>{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->locale('pt_BR')->translatedFormat('l d/m/Y') }}</td>
                        <td>{{ $viaje->vendedor }}</td>
                        <td>{{ $pagamento->forma_pagamento }}</td>
                        <td style="text-align: center;">
                            @if ($pagamento->comprovante)
                                <a href="{{ asset($pagamento->comprovante) }}" target="_blank" style="color: #000; text-decoration: underline; text-align:center;">
                                    Ver comprobante
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
                    <td colspan="6" style="padding:0">
                        <table style="width:100%; padding:0; background: #fff;">
                            <tbody>
                                <tr>
                                    <td width="66%" style="background: #fff;">
                                    </td>
                                    <td width="33%" style="padding:0">
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
                        <table style="width: 100%; background: #fff;">
                            <tr>
                                <td style="padding: 0; background: #fff;">
                                    <div style="text-align: center;">
                                        <div style="background-color: #dfede1; padding: 10px;">
                                            <strong>“TERMINOS Y CONDICIONES ALFATUR Chile”</strong> <br>
                                            <a href="{{ Vite::asset('resources/images/TEC.pdf') }}" target="_blank">Haga clic para ver</a>
                                        </div>
                                        <div style="background-color: #dee047; padding: 10px;">
                                            <span style="color: red">En caso de emergencia, contactar a: +56974909926</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
