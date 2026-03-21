<h4 class="text-center text-primary">CLIENTES DE LA SUCURSAL: {{ $sucursal->NOM_SUC }}</h4>
@if (count($clientes) != 0)
<a class="btn btn-warning btn-sm" href="{{ url('alerta/asignados/'.$sucursal->ID_SUC) }}" target="_blank"><i class="fa fa-print"></i> IMPRIMIR LISTA DE CLIENTES ASIGNADOS</a>
<div class="input-group col-md-6 pull-right">
    <input type="text" id="input_search_{{ $sucursal->ID_SUC }}" class="form-control" onkeyup="table_search(this.value, {{ $sucursal->ID_SUC }});" placeholder="Ingrese el NOMBRE, CI/NIT o CODIGO del cliente">
    <span class="input-group-addon bg-red"><i class="fa fa-search"></i></span>
</div>
<table class="table table-bordered table-striped table-hover text-center" id="table-search_{{ $sucursal->ID_SUC }}">
    <thead>
        <tr class="bg-gray">
            <th>#</th>
            <th>CODIGO</th>
            <th>CLIENTE</th>
            <th>CI/NIT</th>
            <th>DIRECCION</th>
            <th>FECHA SOLICITUD</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $index => $cliente)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><span class="badge bg-black">{{ $cliente->COD_CLI }}</span></td>
            <td>{{ $cliente->NOM_CLI.' '.$cliente->APE_CLI }}</td>
            <td>{{ $cliente->CI_CLI }}</td>
            <td>{{ $cliente->DIR_CLI }}</td>
            <td>{{ $cliente->FEC_SOL }}</td>
            <td>
                <a href="{{ url('cliente/informacion/'.$cliente->ID_CLI) }}" class="btn btn-info btn-sm" title="Datos del cliente"><i class="fa fa-info-circle"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h4 class="text-muted text-center">NO SE ENCONTRARON COINCIDENCIAS</h4>
@endif

<script type="text/javascript">
function table_search(value, id_suc){
    var filtro = $('#input_search_' + id_suc).val().toUpperCase();
    $('#table-search_' + id_suc + ' tr').find('td:eq(1), td:eq(2)').each(function () {
        var textoEnTd = $(this).text().toUpperCase();
        if (textoEnTd.indexOf(filtro) >= 0) {
            $(this).addClass('existe');
        } else {
            $(this).removeClass('existe');
        }
    });
    $('#table-search_' + id_suc + ' tbody tr').each(function(){
        if($(this).children('.existe').length > 0){
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}
</script>
