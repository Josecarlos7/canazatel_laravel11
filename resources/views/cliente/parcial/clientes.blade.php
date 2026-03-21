<h4 class="text-center text-primary">CLIENTES DE LA SUCURSAL: {{ $sucursal->NOM_SUC }}</h4>
<div class="text-center">
    <span class="badge bg-green">CLIENTES ACTIVOS: {{ count($clientes) }}</span>
    <span class="badge bg-red">CLIENTES INACTIVOS: {{ count($clientes_inactivos) }}</span>
</div>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#activos_{{ $sucursal->ID_SUC }}" data-toggle="tab">CLIENTES ACTIVOS</a></li>
        @can('INHABILITA_CLIENTE')
        <li><a href="#inactivos_{{ $sucursal->ID_SUC }}" data-toggle="tab">CLIENTES INACTIVOS</a></li>
        @endcan
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="activos_{{ $sucursal->ID_SUC }}">
            <a href="{{ url('cliente/nuevo/'.$sucursal->ID_SUC.'/0') }}" class="btn btn-success"><i class="fa fa-plus"></i> NUEVO CLIENTE</a>

            @if (count($clientes) !== 0)
            <table class="table table-bordered table-striped table-hover text-center" id="table-search_{{ $sucursal->ID_SUC }}">
                <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>CODIGO</th>
                        <th>CLIENTE</th>
                        <th>CI/NIT</th>
                        <th>DIRECCION</th>
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
                        <td style="text-align: left;">{{ $cliente->DIR_CLI }}</td>
                        <td>
                            <a href="{{ url('cliente/edita/'.$cliente->ID_CLI) }}" class="btn btn-warning btn-sm" title="Editar cliente"><i class="fa fa-pencil"></i></a>
                            <a href="{{ url('cliente/pdf/'.$cliente->ID_CLI) }}" target="_blank" class="btn btn-success btn-sm" title="Pdf del cliente"><i class="fa fa-image"></i></a>
                            <a href="{{ url('cliente/informacion/'.$cliente->ID_CLI) }}" class="btn btn-info btn-sm" title="Datos del cliente"><i class="fa fa-info-circle"></i></a>
                            @can('INHABILITA_CLIENTE')
                            <button class="btn btn-danger btn-sm" type="button" title="Inactivar Cliente" onclick="modalElimina({{ $cliente->ID_CLI }})"><i class="fa fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4 class="text-muted text-center">NO EXISTEN CLIENTES REGISTRADOS EN ESTA SUCURSAL</h4>
            @endif
        </div>

        <div class="tab-pane" id="inactivos_{{ $sucursal->ID_SUC }}">
            @if (count($clientes_inactivos) !== 0)
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>CODIGO</th>
                        <th>CLIENTE</th>
                        <th>CI/NIT</th>
                        <th>DIRECCION</th>
                        <th>CODIGO ANTERIOR</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes_inactivos as $index => $cliente)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-black">{{ $cliente->COD_CLI }}</span></td>
                        <td>{{ $cliente->NOM_CLI.' '.$cliente->APE_CLI }}</td>
                        <td>{{ $cliente->CI_CLI }}</td>
                        <td>{{ $cliente->DIR_CLI }}</td>
                        <td><span class="badge bg-black">{{ $cliente->COD_ATG }}</span></td>
                        <td>
                            <button class="btn btn-success btn-sm" type="button" title="Activar Cliente" onclick="modalActiva({{ $cliente->ID_CLI }})"><i class="fa fa-arrow-up"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4 class="text-muted text-center">NO EXISTEN CLIENTES INACTIVOS EN ESTA SUCURSAL</h4>
            @endif
        </div>
    </div>
</div>

<script>
$(function(){
    $('#table-search_{{ $sucursal->ID_SUC }}').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        language: {
            search: 'Buscar',
            lengthMenu: 'Mostrar _MENU_ registros por pagina',
            zeroRecords: 'No se encontro ningun registro',
            info: 'Mostrando pagina _PAGE_ de _PAGES_',
            infoEmpty: 'No hay registros',
            infoFiltered: '(filtrado de _MAX_ registros)',
            paginate: {
                first: 'Primero',
                last: 'Ultimo',
                next: 'Siguiente',
                previous: 'Anterior'
            }
        }
    });
});
</script>
