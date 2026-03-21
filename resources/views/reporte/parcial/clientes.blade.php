@if (count($lista) != 0)
<table class="table table-hover table-bordered table-striped text-center">
    <tr class="bg-blue">
        <th>#</th>
        <th>CLIENTE</th>
        <th>CODIGO</th>
        <th>ALERTA</th>
        <th>ACCIONES</th>
    </tr>
    @foreach ($lista as $index => $elemento)
    @if ($elemento['mensaje'] == 'EN CORTE')
    <tr class="bg-danger">
    @else
    <tr class="bg-success">
    @endif
        <td>{{ $index + 1 }}</td>
        <td>{{ $elemento['nom_cli'] . ' ' . $elemento['ape_cli'] }}</td>
        <td><span class="badge bg-black">{{ $elemento['cod_cli'] }}</span></td>
        <td><span class="badge bg-red">{{ $elemento['mensaje'] }}</span></td>
        <td>
            <a href="{{ url('cliente/informacion/' . $elemento['id_cli']) }}" target="_blank" class="btn btn-info btn-sm" title="Ir a informacion del cliente"><i class="fa fa-info-circle"></i></a>
            <a href="{{ url('reporte/pdf/cliente/' . $elemento['id_cli']) }}" target="_blank" class="btn btn-warning btn-sm" title="Imprimir informacion de cliente"><i class="fa fa-print"></i></a>
        </td>
    </tr>
    @endforeach
</table>
<div class="text-center">
    <a href="{{ url('reporte/pdf/clientes/' . $request->id_suc . '/' . $request->tipo) }}" target="_blank" class="btn btn-danger"><i class="fa fa-print"></i> IMPRIMIR</a>
</div>
@else
<h4 class="text-center text-muted">NO SE ENCONTRO NINGUN RESULTADO</h4>
@endif
