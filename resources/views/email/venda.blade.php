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
                                   <td width="30%" style="background: #d2d3db;"><strong>Nombre:</strong> </td>
                                   <td width="70%">{{ $venda->nome }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="30%" style="background: #d2d3db;"><strong>Fecha:</strong> </td>
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
                                   <td width="50%" style="background: #d2d3db;"><strong>WhatsApp:</strong> </td>
                                   <td width="50%">{{ $venda->telefone }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="50%" style="background: #d2d3db;"><strong>Vendedor:</strong> </td>
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
                                   <td width="50%" style="background: #d2d3db;"><strong>E-Mail:</strong> </td>
                                   <td width="50%">{{ $venda->email }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="50%" style="background: #d2d3db;"><strong>Status:</strong> </td>
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
                                   <td width="50%" style="background: #d2d3db;"><strong>Hotel:</strong> </td>
                                   <td width="50%">{{ $venda->hotel }}</td>
                               </tr>
                         </tbody>
                    </table>
                </td>
                <td style="padding:0">
                    <table style="width:100%">
                         <tbody>
                               <tr>
                                   <td width="50%" style="background: #d2d3db;"><strong>Dirección:</strong> </td>
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
                    <td>ALF-{{ $tour->id }}</td>
                    <td>{{ $tour->data_tour }}</td>
                    <td>{{ \Carbon\Carbon::parse($tour->created_at)->format('H:i') }}</td>
                    <td>{{ $tour->tour }}</td>
                    <td>{{ $tour->pax_adulto + ($tour->pax_infantil ?? 0) }}</td>
                    <td>{{ number_format($tour->preco_adulto, 0, ',', '.') }}</td>
                    <td>{{ number_format(($tour->preco_adulto * $tour->pax_adulto) + ($tour->preco_infantil * $tour->pax_infantil ?? 0), 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="7">
                        <table style="width:100%; padding:0">
                            <tbody>
                                <tr>
                                    <td width="66%">
                                        Comprar mas Tours
                                    </td>
                                    <td width="34%">
                                        <p class="totals">TOTAL: CLP $ {{ number_format($venda->valor_total, 0, ',', '.') }}</p>
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
                    <th>Comprobante</th>
                    <th>Valor CLP $</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PAG-{{ $venda->id }}</td>
                    <td>{{ $venda->data_pagamento }}</td>
                    <td>{{ $venda->vendedor }}</td>
                    <td>{{ $venda->forma_pagamento }}</td>
                    <td>
                        @if ($venda->comprovante)
                            <a href="{{ asset($venda->comprovante) }}" target="_blank" style="color: blue; text-decoration: underline;">
                                Descargar Comprobante
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
            </tbody>
        </table>
        <p class="totals">TOTAL PAGOS: CLP $ 
            @php
                $porcentagem = $venda->valor_pago; 
                $total = ($venda->valor_total * $porcentagem) / 100;
            @endphp
            {{ number_format($total , 0, ',', '.') }}
        </p>
        <p class="totals total-pendiente">TOTAL PENDIENTE: CLP $ {{ number_format($venda->valor_a_pagar, 0, ',', '.') }}</p>
    </div>
</body>
</html>
