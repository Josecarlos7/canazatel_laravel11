<!DOCTYPE html>
<html>
<head>
    <title>INGRESO EGRESO DETALLES</title>
    <style type="text/css">
        @page {
            margin: 0cm;
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
        }
        body { font-family: "Helvetica"; font-size: 9.7px; color: black; }
    </style>
</head>
@php
    $nombre_mes = strtoupper(\Carbon\Carbon::parse('2021-' . $mes . '-01')->isoFormat('MMMM'));
@endphp
<body>
@foreach ($planes as $plan)
    <div>
        <h1 style="text-align: center; font-size: 2.5em;">REPORTE INGRESOS Y EGRESOS CON DETALLES</h1>
        <table style="width: 100%" border="1" cellspacing="0">
            <tr>
                <td width="50%" style="padding: 10px; text-align: center;">
                    <b>SUCURSAL: </b> {{ $sucursal->NOM_SUC }}<br>
                    <b>PLAN: </b> {{ $plan }}
                </td>
                <td width="50%" style="padding: 10px;">
                    <b>TIPO DE BUSQUEDA</b>: {{ $tipo }}<br>
                    @if ($tipo == 'FECHAS')
                    <b>FECHA INICIO: </b> {{ $fec_ini }}<br>
                    <b>FECHA FINAL: </b> {{ $fec_fin }}<br>
                    @endif
                    @if ($tipo == 'MENSUAL')
                    <b>MES: </b> {{ $nombre_mes }}<br>
                    <b>AÑO: </b> {{ $anio_m }}<br>
                    @endif
                    @if ($tipo == 'ANUAL')
                    <b>AÑO: </b> {{ $anio_a }}<br>
                    @endif
                    <b>FECHA|HORA DE IMPRESION:</b> {{ now()->format('Y-m-d H:i:s') }}
                </td>
            </tr>
        </table>

        @php $t_ingresos = 0; $t_egresos = 0; @endphp
        <div style="display: table; width:100%;text-align:center;">
            <div style="display: table-cell; padding-right: 5px;">
                <h2>INGRESOS</h2>
                <table style="width: 100%" cellspacing="" cellpadding="" border="1">
                    <tr>
                        <th>#</th>
                        <th>SUBSCRIPTORES</th>
                        <th>COD BOL</th>
                        <th>MES CANCELADO</th>
                        <th>RESPONSABLE DE COBRO</th>
                        <th>FAC.</th>
                        <th>IMPORTE</th>
                    </tr>
                    @php $contador = 1; @endphp
                    @foreach ($ingresos as $index => $ingreso)
                        @if ($ingreso->TIPO_PLAN == $plan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><small>{{ $ingreso->NOM_CLI . ' ' . $ingreso->APE_CLI }}</small></td>
                                <td><small>{{ $ingreso->COD_PD }}</small></td>
                                <td>
                                    <small>
                                        {{ $ingreso->MOT_PAG == 'MENSUALIDAD' ? ($ingreso->ANIO_PD . '/' . $ingreso->MES_PD) : $ingreso->MOT_PAG }}
                                    </small>
                                </td>
                                <td><small>{{ $ingreso->NOM_USU . ' ' . $ingreso->PAT_USU }}</small></td>
                                <td style="text-align: center;">{{ $ingreso->FTR_PD == 1 ? 'F' : '' }}</td>
                                <td><b>{{ $ingreso->MONTO_PD + $ingreso->MONTO_PO }} Bs.</b></td>
                                @php $t_ingresos = $t_ingresos + $ingreso->MONTO_PD + $ingreso->MONTO_PO; @endphp
                            </tr>

                            @php $contador++; @endphp
                            @if ($contador >= 43)
                                </table>
                                <div style="page-break-after:always;"></div>
                                <table style="width: 100%" cellspacing="" cellpadding="" border="1">
                                    <tr>
                                        <th>#</th>
                                        <th>SUBSCRIPTORES</th>
                                        <th>COD BOL</th>
                                        <th>MES CANCELADO</th>
                                        <th>RESPONSABLE DE COBRO</th>
                                        <th>FAC.</th>
                                        <th>IMPORTE</th>
                                    </tr>
                                @php $contador = 1; @endphp
                            @endif
                        @endif
                    @endforeach
                    <tr style="background-color: #DCDCDC;">
                        <td colspan="6">TOTAL INGRESOS</td>
                        <td>{{ $t_ingresos }} Bs.</td>
                    </tr>
                </table>
            </div>
            <div style="display: table-cell; padding-left: 5px;">
                <h2>EGRESOS</h2>
                <table style="width: 100%" cellspacing="" cellpadding="" border="1">
                    @foreach ($egresos as $egreso)
                    <tr>
                        <td><small>{{ $egreso->MOT_GAS }}</small></td>
                        <td><b>{{ $egreso->CANT_GAS }} Bs.</b></td>
                    </tr>
                    @php $t_egresos = $t_egresos + $egreso->CANT_GAS; @endphp
                    @endforeach
                    <tr style="background-color: #DCDCDC;">
                        <td>TOTAL EGRESOS</td>
                        <td>{{ $t_egresos }} Bs.</td>
                    </tr>
                </table>
            </div>
        </div>

        <table style="width: 100%; text-align: center; font-size: 1.5em; background-color: black; color:white;" cellspacing="" cellpadding="" border="1">
            <tr>
                <td class="text-right">SALDO:</td>
                <td>{{ $t_ingresos - $t_egresos }} Bs.</td>
            </tr>
        </table>
    </div>
    <div style="page-break-after:always;"></div>
@endforeach
</body>
</html>
