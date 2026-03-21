<!DOCTYPE html>
<html>
<head>
    <title>INFORMACION ACTUAL</title>
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
<body>
    <div>
        <h1 style="text-align: center; font-size: 2.5em;">INFORMACION ACTUAL</h1>
        <table style="width: 100%" border="1" cellspacing="0">
            <tr>
                <td width="50%" style="padding: 10px; text-align: center;"><b>SUCURSAL: </b> {{ $sucursal->NOM_SUC }}</td>
                <td width="50%" style="padding: 10px; text-align: center;"><b>FECHA|HORA DE IMPRESION:</b> {{ now()->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 15px;" border="1" cellspacing="0" cellpadding="6">
            <tr>
                <th>CLIENTES TOTALES</th>
                <th>CLIENTES ACTIVOS</th>
                <th>CLIENTES INACTIVOS</th>
                <th>DEUDORES</th>
                <th>PUNTUALES</th>
                <th>EN CORTE</th>
            </tr>
            <tr style="text-align:center;">
                <td>{{ $clientes_totales }}</td>
                <td>{{ $clientes_activos }}</td>
                <td>{{ $clientes_inactivos }}</td>
                <td>{{ count($deudores) }}</td>
                <td>{{ count($puntuales) }}</td>
                <td>{{ count($en_cortes) }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 20px; margin-bottom: 5px;">DETALLE POR PLAN</h3>
        <table style="width: 100%;" border="1" cellspacing="0" cellpadding="6">
            <tr>
                <th>PLAN</th>
                <th>CANTIDAD</th>
            </tr>
            @foreach ($planes as $plan)
            <tr>
                <td>{{ $plan->NOM_PLAN }}</td>
                <td style="text-align:center;">{{ $plan->cantidad }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
