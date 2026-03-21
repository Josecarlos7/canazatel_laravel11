<!DOCTYPE html>
<html>
<head>
    <title>INGRESO EGRESO</title>
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
    <div>
        <h1 style="text-align: center; font-size: 2.5em;">REPORTE INGRESOS Y EGRESOS</h1>
        <table style="width: 100%" border="1" cellspacing="0">
            <tr>
                <td width="50%" style="padding: 10px; text-align: center;"><b>SUCURSAL: </b> {{ $sucursal->NOM_SUC }}</td>
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
                <table style="width: 100%; font-size: 1.5em;" cellspacing="" cellpadding="" border="1">
                    @foreach ($ingresos as $ingreso)
                    @php
                    $subtotal_detalles = 0;
                    $subtotal_otros = 0;
                    if (count($ingreso->detalles) != 0) {
                        foreach ($ingreso->detalles as $detalle) {
                            $subtotal_detalles = $subtotal_detalles + $detalle->MONTO_PD;
                        }
                    }
                    if (count($ingreso->otros) != 0) {
                        foreach ($ingreso->otros as $otro) {
                            $subtotal_otros = $subtotal_otros + $otro->MONTO_PO;
                        }
                    }
                    $t_ingresos = $t_ingresos + $subtotal_detalles + $subtotal_otros;
                    @endphp
                    @endforeach
                    <tr style="background-color: #DCDCDC;">
                        <td colspan="2">TOTAL INGRESOS</td>
                        <td>{{ $t_ingresos }} Bs.</td>
                    </tr>
                </table>
            </div>
            <div style="display: table-cell; padding-left: 5px;">
                <h2>EGRESOS</h2>
                <table style="width: 100%; font-size: 1.5em;" cellspacing="" cellpadding="" border="1">
                    @foreach ($egresos as $egreso)
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
</body>
</html>
