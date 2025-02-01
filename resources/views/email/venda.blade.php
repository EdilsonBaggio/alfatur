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
                      <img width="150" class="img-fluid" src="https://alfatur.symbster.com/build/assets/logo-8944cde3.svg" alt="">
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
                                        <a href="#" target="_blank" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                            Comprar mas Tours
                                        </a>
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
                <tr>
                    <td>PAG-{{ $venda->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($venda->data_pagamento)->locale('pt_BR')->translatedFormat('l d/m/Y') }}</td>
                    <td>{{ $venda->vendedor }}</td>
                    <td>{{ $venda->forma_pagamento }}</td>
                    <td style="text-align: center;">
                        @if ($venda->comprovante)
                            <a href="{{ asset($venda->comprovante) }}" target="_blank" style="color: #000; text-decoration: underline; text-align:center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                                </svg>
                            </a>
                        @else
                            N/A
                        @endif
                    </td>                    
                    <td>
                        @php
                            $porcentagem = $venda->valor_pago; 
                            $total = ($venda->valor_total * $porcentagem) / 100;
                        @endphp
                        {{ '$' . number_format($total , 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="padding:0">
                        <table style="width:100%; padding:0; background: #fff;">
                            <tbody>
                                <tr>
                                    <td width="66%" style="background: #fff;">
                                        <a href="#" target="_blank" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                            </svg>
                                            Ingressar pago
                                        </a>
                                    </td>
                                    <td width="33%" style="padding:0">
                                        <p class="totals total-pago">
                                            @php
                                                $porcentagem = $venda->valor_pago; 
                                                $total = ($venda->valor_total * $porcentagem) / 100;
                                            @endphp
                                            TOTAL PAGOS: CLP ${{ number_format($total , 0, ',', '.') }}
                                        </p>
                                        <p class="totals total-pendiente">TOTAL PENDIENTE: CLP ${{ number_format($venda->valor_a_pagar, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
