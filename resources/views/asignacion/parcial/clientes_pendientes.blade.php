<h4 class="text-center text-primary">CLIENTES DE LA SUCURSAL: {{ $sucursal->NOM_SUC }}</h4>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#pendientes_{{ $sucursal->ID_SUC }}" data-toggle="tab">PENDIENTES</a></li>
        <li><a href="#asignados_{{ $sucursal->ID_SUC }}" data-toggle="tab">ASIGNADOS</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="pendientes_{{ $sucursal->ID_SUC }}">
            @if (count($pendientes) != 0)
            <form id="form_asignacion_{{ $sucursal->ID_SUC }}">
                <input type="hidden" name="id_suc" value="{{ $sucursal->ID_SUC }}">
                <table class="table table-bordered table-striped table-hover" id="table-search_{{ $sucursal->ID_SUC }}">
                    <thead>
                        <tr class="bg-gray">
                            <th class="text-center">.</th>
                            <th>DATOS</th>
                            <th>FECHA|HORA SOLICITUD</th>
                            <th>DATOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendientes as $cliente)
                        <tr>
                            <td class="text-center"><input type="checkbox" class="ch" name="ch[]" id="ch_{{ $cliente->ID_CON }}" value="{{ $cliente->ID_CON }}" onchange="cambio(this.value);" style="transform: scale(1.8);"></td>
                            <td>
                                <small>
                                    <b>CLIENTE: </b>{{ $cliente->NOM_CLI.' '.$cliente->APE_CLI }}<br>
                                    <b>DIRECCION: </b>{{ $cliente->DIR_CLI }}<br>
                                    <b>CODIGO: </b>{{ $cliente->COD_CLI }}
                                </small>
                            </td>
                            <td><i class="fa fa-calendar"></i> {{ $cliente->FEC_SOL }} <br> <i class="fa fa-clock-o"></i> {{ $cliente->HOR_SOL }}</td>
                            <td>
                                <textarea class="form-control" name="descripcion[]" id="txt_{{ $cliente->ID_CON }}" disabled>{{ $cliente->TXT_CON }}</textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            <button class="btn btn-danger btn-block" type="button" onclick="modalConfirma({{ $sucursal->ID_SUC }});"><i class="fa fa-check"></i> ASIGNAR CLIENTES SELECCIONADOS A TECNICO</button>
            @else
            <h4 class="text-muted text-center">NO EXISTEN CLIENTES PENDIENTES EN ESTA SUCURSAL</h4>
            @endif
        </div>
        <div class="tab-pane" id="asignados_{{ $sucursal->ID_SUC }}">
            @if (count($asignados) != 0)
            <a target="_blank" href="{{ url('asignaciones/pdf/'.$sucursal->ID_SUC) }}" class="btn btn-warning btn-sm"><i class="fa fa-copy"></i> Imprimir todos los clientes pendientes</a>
            <table class="table table-bordered table-striped table-hover" id="table-search_{{ $sucursal->ID_SUC }}">
                <thead>
                    <tr class="bg-gray">
                        <th class="text-center">#</th>
                        <th>DATOS</th>
                        <th>FECHA|HORA SOLICITUD</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asignados as $index => $cliente)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <small>
                                <b>CLIENTE: </b>{{ $cliente->NOM_CLI.' '.$cliente->APE_CLI }}<br>
                                <b>DIRECCION: </b>{{ $cliente->DIR_CLI }}<br>
                                <b>CODIGO: </b>{{ $cliente->COD_CLI }}
                            </small>
                        </td>
                        <td><i class="fa fa-calendar"></i> {{ $cliente->FEC_SOL }} <br> <i class="fa fa-clock-o"></i> {{ $cliente->HOR_SOL }}</td>
                        <td>
                            <a href="{{ url('asignacion/pdf/'.$cliente->ID_CON) }}" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-file"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4 class="text-muted text-center">NO EXISTEN CLIENTES ASIGNADOS EN ESTA SUCURSAL</h4>
            @endif
        </div>
    </div>
</div>

<script type="text/javascript">
function cambio(id_con){
    if ($('#ch_' + id_con).prop('checked')) {
        $('#txt_' + id_con).attr('disabled', false);
    } else {
        $('#txt_' + id_con).attr('disabled', true);
    }
}
</script>
