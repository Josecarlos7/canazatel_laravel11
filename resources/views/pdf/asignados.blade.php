<!DOCTYPE html>
<html>
<head>
    <title>LISTA DE ASIGNADOS</title>
    <style type="text/css">
        @page { margin: 1cm; }
        body { font-family: Helvetica; font-size: 10px; color: black; }
    </style>
</head>
<body>
    <h1 style="text-align: center; font-size: 2.5em;">LISTA DE CLIENTES ASIGNADOS</h1>
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
            <th>FECHA SOLICITUD</th>
        </tr>
        @foreach ($clientes as $index => $cliente)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $cliente->COD_CLI }}</td>
            <td>{{ $cliente->NOM_CLI.' '.$cliente->APE_CLI }}</td>
            <td>{{ $cliente->CI_CLI }}</td>
            <td>{{ $cliente->DIR_CLI }}</td>
            <td>{{ $cliente->FEC_SOL }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
