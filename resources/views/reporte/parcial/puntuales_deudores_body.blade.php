<div class="row text-center">
    <div class="col-md-6">
        <h4 class="text-primary">PUNTUALES</h4>
        <table class="table table-hover table-striped table-bordered table-sm text-center">
            <tr class="bg-gray">
                <th>#</th>
                <th>CLIENTE</th>
                <th>CI</th>
                <th>CODIGO</th>
                <th>DIRECCION</th>
            </tr>
            @foreach ($puntuales as $index => $puntual)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $puntual['nom_cli'] . ' ' . $puntual['ape_cli'] }}</td>
                <td>{{ $puntual['ci_cli'] }}</td>
                <td>{{ $puntual['cod_cli'] }}</td>
                <td>{{ $puntual['dir_cli'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-6">
        <h4 class="text-danger">DEUDORES</h4>
        <table class="table table-hover table-striped table-bordered table-sm text-center">
            <tr class="bg-gray">
                <th>#</th>
                <th>CLIENTE</th>
                <th>CI</th>
                <th>CODIGO</th>
                <th>DIRECCION</th>
            </tr>
            @foreach ($deudores as $index => $deudor)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $deudor['nom_cli'] . ' ' . $deudor['ape_cli'] }}</td>
                <td>{{ $deudor['ci_cli'] }}</td>
                <td>{{ $deudor['cod_cli'] }}</td>
                <td>{{ $deudor['dir_cli'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
