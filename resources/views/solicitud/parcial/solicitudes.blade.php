<h4 class="text-center text-primary">SOLICITUDES DE LA SUCURSAL: {{ $sucursal->NOM_SUC }}</h4>
<button class="btn btn-success" type="button" onclick='modalSolicitud(@json($sucursal));'><i class="fa fa-plus"></i> NUEVA SOLICITUD</button>
@if (count($solicitudes) != 0)
<table class="table table-bordered table-striped table-hover">
    <tr class="bg-gray">
        <th>#</th>
        <th>FECHA</th>
        <th>DESCRIPCION</th>
        <th>DETALLE</th>
        <th>RESPUESTA</th>
        <th>RESPUESTA RECEPCION</th>
        <th>ESTADO</th>
        <th>ACCIONES</th>
    </tr>
    @foreach ($solicitudes as $index => $solicitud)
    @php
    $usuario = $usuarios[$solicitud->ID_USU] ?? null;
    $usuarioRsp = $solicitud->ID_USU_RSP ? ($usuarios[$solicitud->ID_USU_RSP] ?? null) : null;
    $usuarioRec = $solicitud->ID_USU_REC ? ($usuarios[$solicitud->ID_USU_REC] ?? null) : null;
    @endphp
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $solicitud->FEC_SOL }}<br>{{ $solicitud->HOR_SOL }}</td>
        <td>
            <b>{{ $solicitud->DES_SOL }}</b>
            <br>
            <small class="text-muted">{{ $usuario ? ($usuario->NOM_USU . ' ' . $usuario->PAT_USU) : '' }}</small>
        </td>
        <td>
            <ul>
                @foreach ($solicitud->detalles as $detalle)
                <li>({{ $detalle->CANT_SM }}) {{ $detalle->NOM_MAT }}</li>
                @endforeach
            </ul>
        </td>
        <td class="bg-info">
            <b>{{ $solicitud->RESP_SOL }}</b>
            <small class="text-muted">
                <br>{{ $solicitud->FEC_RESP . ' | ' . $solicitud->HOR_RESP }}
                @if ($usuarioRsp)
                <br>{{ $usuarioRsp->NOM_USU . ' ' . $usuarioRsp->PAT_USU }}
                @endif
            </small>
        </td>
        <td class="bg-success">
            <b>{{ $solicitud->RESP_REC }}</b>
            <small class="text-muted">
                <br>{{ $solicitud->FEC_REC . ' | ' . $solicitud->HOR_REC }}
                @if ($usuarioRec)
                <br>{{ $usuarioRec->NOM_USU . ' ' . $usuarioRec->PAT_USU }}
                @endif
            </small>
        </td>
        <td>
            @switch($solicitud->EST_SOL)
            @case('PENDIENTE')
            <span class="badge bg-yellow">{{ $solicitud->EST_SOL }}</span>
            @break
            @case('ENVIADO')
            <span class="badge bg-blue">{{ $solicitud->EST_SOL }}</span>
            @break
            @case('RECHAZADO')
            <span class="badge bg-red">{{ $solicitud->EST_SOL }}</span>
            @break
            @case('RECIBIDO')
            <span class="badge bg-green">{{ $solicitud->EST_SOL }}</span>
            @break
            @default
            <span class="badge bg-gray">{{ $solicitud->EST_SOL }}</span>
            @endswitch
        </td>
        <td>
            @switch($solicitud->EST_SOL)
            @case('PENDIENTE')
            @hasanyrole('ADMINISTRADOR|SUPER_ADMIN|GERENCIA GENERAL')
            <a href="{{ url('solicitud/atender/' . $solicitud->ID_SOL) }}" class="btn btn-success btn-sm" title="Atender Solicitud"><i class="fa fa-send"></i></a>
            @endhasanyrole
            @if (Auth::user()->ID_USU == $solicitud->ID_USU)
            <button class="btn btn-danger btn-sm" type="button" onclick='modalElimina(@json($solicitud))'><i class="fa fa-trash"></i></button>
            @endif
            @break
            @case('ENVIADO')
            <button class="btn btn-info btn-sm" type="button" onclick="modalRecepcion({{ $solicitud->ID_SOL }})" title="Recepcionar Solicitud"><i class="fa fa-check"></i></button>
            @break
            @case('RECHAZADO')
            @break
            @default
            @endswitch
        </td>
    </tr>
    @endforeach
</table>
@else
<h4 class="text-muted text-center">NO EXISTEN SOLICITUDES REGISTRADAS EN ESTA SUCURSAL</h4>
@endif
