<h4 class="text-center text-white bg-blue" style="padding: 10px;">GASTOS DE LA SUCURSAL: <b>{{ $sucursal->NOM_SUC }}</b> EN FECHA: <b>{{ $fecha }}</b></h4>
<button class="btn btn-success" type="button" onclick='modalNuevoGasto(@json($sucursal));'><i class="fa fa-plus"></i> NUEVO GASTO</button>
@if (count($gastos) != 0)
<table class="table table-hover table-striped table-bordered table-sm">
    <tr class="bg-gray">
        <th>#</th>
        <th>FECHA/HORA</th>
        <th>USUARIO</th>
        <th>DESCRIPCION</th>
        <th>MONTO</th>
        <th>ACCIONES</th>
    </tr>
    @foreach ($gastos as $index => $gasto)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td><i class="fa fa-calendar"></i> {{ $gasto->FEC_GAS }}<br><i class="fa fa-clock-o"></i> {{ $gasto->HOR_GAS }}</td>
        <td>{{ $gasto->NOM_USU . ' ' . $gasto->PAT_USU }}</td>
        <td>{{ $gasto->MOT_GAS }}</td>
        <td>{{ $gasto->CANT_GAS }} Bs.</td>
        <td>
            <a href="{{ url('gasto/pdf/' . $gasto->ID_GAS) }}" class="btn btn-info btn-sm" target="_blank" title="Generar pdf del gasto"><i class="fa fa-file"></i></a>
            @hasanyrole('ADMINISTRADOR|SUPER_ADMIN|GERENCIA GENERAL')
            <button class="btn btn-danger btn-sm" type="button" onclick='modalElimina(@json($gasto));'><i class="fa fa-trash"></i></button>
            @endhasanyrole
        </td>
    </tr>
    @endforeach
</table>
@else
<h4 class="text-center text-muted">NO SE REGISTRO NINGUN GASTO EN <br> LA SUCURSAL: <b>"{{ $sucursal->NOM_SUC }}"</b> EN FECHA: <b>"{{ $fecha }}"</b></h4>
@endif
