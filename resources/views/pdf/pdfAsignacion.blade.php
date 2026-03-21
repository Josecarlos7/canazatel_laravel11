<!DOCTYPE html>
<html>
<head>
    <title>ORDEN DE TRABAJO</title>
    <style type="text/css">
        @page { margin: 1cm; }
        body { font-family: Helvetica; font-size: 12px; color: black; }
        .linea { margin: 10px 0; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">ORDEN DE TRABAJO DE INSTALACION</h2>

    <table style="width:100%;" border="0">
        <tr>
            <td><b>SUCURSAL:</b> {{ $contrato->NOM_SUC }}</td>
            <td><b>NRO ORDEN:</b> {{ $contrato->COD_CON }}</td>
        </tr>
        <tr>
            <td><b>FECHA CONTRATO:</b> {{ $contrato->FEC_SOL }}</td>
            <td><b>HORA:</b> {{ $contrato->HOR_SOL }}</td>
        </tr>
    </table>

    <p class="linea"><b>CLIENTE:</b> {{ $contrato->NOM_CLI.' '.$contrato->APE_CLI }}</p>
    <p class="linea"><b>CODIGO:</b> {{ $contrato->COD_CLI }} | <b>CI:</b> {{ $contrato->CI_CLI }}</p>
    <p class="linea"><b>DIRECCION:</b> {{ $contrato->DIR_CLI }}</p>
    <p class="linea"><b>PLAN:</b> {{ $contrato->NOM_PLAN }} ({{ $contrato->TIPO_PLAN }})</p>

    <h4>DETALLE DE SOLICITUD</h4>
    <p>{{ $contrato->TXT_CON }}</p>

    <br><br>
    <table style="width:100%; text-align:center;" border="0">
        <tr>
            <td>______________________________</td>
            <td>______________________________</td>
            <td>______________________________</td>
        </tr>
        <tr>
            <td>Firma Tecnico</td>
            <td>Firma Cliente</td>
            <td>Jefe Tecnico</td>
        </tr>
    </table>
</body>
</html>
