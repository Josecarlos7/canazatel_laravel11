<!DOCTYPE html>
<html>
<head>
    <title>CLIENTES PUNTUALES DEUDORES</title>
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
    @php $tipoBusqueda = strtoupper($tipo); @endphp
    <div>
        <h1 style="text-align: center; font-size: 2.5em;">REPORTE CLIENTES {{ $tipoBusqueda }}</h1>
        <table style="width: 100%" border="1" cellspacing="0">
            <tr>
                <td width="50%" style="padding: 10px; text-align: center;"><b>SUCURSAL: </b> {{ $sucursal->NOM_SUC }}</td>
                <td width="50%" style="padding: 10px; text-align: center;"><b>FECHA|HORA DE IMPRESION:</b> {{ now()->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>

        @if ($tipoBusqueda === 'DEUDORES')
        <h2 style="margin-bottom: 0;">SUBSCRIPTORES DEUDORES</h2>
        <table style="width: 100%" border="1" cellspacing="0" cellpadding="4">
            <thead>
            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CODIGO</th>
                <th>C.I.</th>
                <th>DIRECCION</th>
                <th>TIPO PAGO</th>
                <th>DIAS DEUDA</th>
                <th>ALERTA</th>
            </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($lista as $elemento)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ ($elemento['nom_cli'] ?? '') . ' ' . ($elemento['ape_cli'] ?? '') }}</td>
                    <td>{{ $elemento['cod_cli'] ?? '' }}</td>
                    <td>{{ $elemento['ci_cli'] ?? '' }}</td>
                    <td>{{ $elemento['dir_cli'] ?? '' }}</td>
                    <td>{{ $elemento['tipo_pago'] ?? '' }}</td>
                    <td>{{ $elemento['dias_deuda'] ?? '' }}</td>
                    <td>{{ $elemento['mensaje'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if ($tipoBusqueda === 'PUNTUALES')
        <h2 style="margin-bottom: 0;">SUBSCRIPTORES PUNTUALES</h2>
        <table style="width: 100%" border="1" cellspacing="0" cellpadding="4">
            <thead>
            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CODIGO</th>
                <th>C.I.</th>
                <th>DIRECCION</th>
                <th>ALERTA</th>
            </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($lista as $elemento)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ ($elemento['nom_cli'] ?? '') . ' ' . ($elemento['ape_cli'] ?? '') }}</td>
                    <td>{{ $elemento['cod_cli'] ?? '' }}</td>
                    <td>{{ $elemento['ci_cli'] ?? '' }}</td>
                    <td>{{ $elemento['dir_cli'] ?? '' }}</td>
                    <td>{{ $elemento['mensaje'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if ($tipoBusqueda === 'EN CORTE')
        <h2 style="margin-bottom: 0;">SUBSCRIPTORES EN CORTE</h2>
        <table style="width: 100%" border="1" cellspacing="0" cellpadding="4">
            <thead>
            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>CODIGO</th>
                <th>C.I.</th>
                <th>DIRECCION</th>
                <th>TIPO PAGO</th>
                <th>DIAS DEUDA</th>
                <th>ALERTA</th>
            </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($lista as $elemento)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ ($elemento['nom_cli'] ?? '') . ' ' . ($elemento['ape_cli'] ?? '') }}</td>
                    <td>{{ $elemento['cod_cli'] ?? '' }}</td>
                    <td>{{ $elemento['ci_cli'] ?? '' }}</td>
                    <td>{{ $elemento['dir_cli'] ?? '' }}</td>
                    <td>{{ $elemento['tipo_pago'] ?? '' }}</td>
                    <td>{{ $elemento['dias_deuda'] ?? '' }}</td>
                    <td>{{ $elemento['mensaje'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</body>
</html>
