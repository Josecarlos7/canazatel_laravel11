<!DOCTYPE html>
<html>
<head>
    <title>LISTA DE DEUDORES</title>
    <style type="text/css">
        @page { margin: 1cm; }
        body { font-family: Helvetica; font-size: 10px; color: black; }
    </style>
</head>
<body>
    <h1 style="text-align: center; font-size: 2.5em;">LISTA DE DEUDORES</h1>
    <table style="width: 100%" border="1" cellspacing="0">
        <tr>
            <td style="padding: 10px; text-align: center;">
                <b>SUCURSAL: </b> {{ $sucursal->NOM_SUC }}<br>
                <b>FECHA Y HORA DE IMPRESION: </b> {{ now()->format('Y-m-d H:i:s') }}
            </td>
        </tr>
    </table>
    <br>

    <table style="width: 100%; text-align: center;" border="1" cellspacing="0" cellpadding="4">
        <tr style="background-color: #D8D8D8;">
            <th>#</th>
            <th>CODIGO</th>
            <th>CLIENTE</th>
            <th>CI/NIT</th>
            <th>DIRECCION</th>
            <th>TIPO PAGO</th>
            <th>DIAS DEUDA</th>
        </tr>
        @foreach ($deudores as $index => $deudor)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $deudor['cod_cli'] }}</td>
            <td>{{ $deudor['nom_cli'].' '.$deudor['ape_cli'] }}</td>
            <td>{{ $deudor['ci_cli'] }}</td>
            <td>{{ $deudor['dir_cli'] }}</td>
            <td>{{ $deudor['tipo_pago'] }}</td>
            <td>{{ $deudor['dias_deuda'] }} /dias</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
