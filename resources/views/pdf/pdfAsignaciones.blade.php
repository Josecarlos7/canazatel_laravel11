<!DOCTYPE html>
<html>
<head>
    <title>ORDENES DE TRABAJO</title>
    <style type="text/css">
        @page { margin: 1cm; }
        body { font-family: Helvetica; font-size: 10px; color: black; }
        table { width: 100%; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">ORDENES DE TRABAJO ASIGNADAS</h2>
    <table border="1" cellspacing="0" cellpadding="4">
        <tr style="background:#e5e5e5; text-align:center;">
            <th>#</th>
            <th>CODIGO ORDEN</th>
            <th>CLIENTE</th>
            <th>DIRECCION</th>
            <th>PLAN</th>
            <th>FECHA</th>
            <th>OBSERVACION</th>
        </tr>
        @foreach ($contratos as $index => $contrato)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $contrato->COD_CON }}</td>
            <td>{{ $contrato->NOM_CLI.' '.$contrato->APE_CLI }}</td>
            <td>{{ $contrato->DIR_CLI }}</td>
            <td>{{ $contrato->NOM_PLAN }}</td>
            <td>{{ $contrato->FEC_SOL }} {{ $contrato->HOR_SOL }}</td>
            <td>{{ $contrato->TXT_CON }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
