<!DOCTYPE html>
<html>
<head>
    <title>GASTO</title>
    <style type="text/css">
        @page {
            margin: 0cm;
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
        }
        body {
            font-family: "Courier";
            font-size: 14.5px;
            color: black;
        }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .p-1 { padding: 8px; }
    </style>
</head>
<body>
    <table style="width: 100%" cellspacing="" cellpadding="" border="0">
        <tr>
            <th class="text-left">CANAZATEL TELECOMUNICACIONES</th>
            <th class="text-right">TRANSACCION</th>
        </tr>
        <tr>
            <th class="text-left">{{ $gasto->NOM_SUC }}</th>
            <th class="text-right">{{ $gasto->ID_GAS }}</th>
        </tr>
        <tr>
            <th class="text-left">USUARIO: {{ $gasto->NOM_USU . ' ' . $gasto->PAT_USU }}</th>
            <th class="text-right">FECHA: {{ $gasto->FEC_GAS }} HORA: {{ $gasto->HOR_GAS }}</th>
        </tr>
    </table>

    <h3 style="text-align: center;">EGRESOS POR EFECTIVO</h3>
    DETALLE: {{ $gasto->MOT_GAS }}
    <br>
    <br>

    <table style="width: 100%" cellspacing="0" cellpadding="0" border="1">
        <tr>
            <td class="p-1">{{ $gasto->MOT_GAS }}</td>
            <td class="p-1">{{ $gasto->CANT_GAS }} Bs.</td>
        </tr>
        <tr>
            <td class="p-1">COBRO TOTAL:</td>
            <td class="p-1">{{ $gasto->CANT_GAS }} Bs.</td>
        </tr>
    </table>

    <br>
    <br>
    SON <b>{{ \App\Support\MontoEnLetras::bolivianos($gasto->CANT_GAS) }}</b>.

    <br>
    <br>
    <br>
    <br>
    <br>
    <table style="width: 100%;" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td><hr style="margin-left: 50px; margin-right: 50px;" width="100%"></td>
            <td><hr style="margin-left: 50px; margin-right: 50px;" width="100%"></td>
        </tr>
        <tr style="text-align: center;">
            <td><b>RECIBI CONFORME</b></td>
            <td><b>ENTREGUE CONFORME</b></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td></td>
        </tr>
        <tr>
            <td>CI:</td>
            <td></td>
        </tr>
    </table>
</body>
</html>
