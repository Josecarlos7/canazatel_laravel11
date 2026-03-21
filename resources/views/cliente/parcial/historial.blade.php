<button class="btn btn-success btn-sm" type="button" onclick="modalNuevoContrato()"><i class="fa fa-plus"></i> CREAR NUEVO CONTRATO</button>
<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered table-sm text-center">
		<tr class="bg-gray">
			<th>#</th>
			<th>FECHA SOLICITUD</th>
			<th>FECHA ACTIVACION</th>
			<th>FECHA FINAL</th>
			<th>TIPO DE PAGO</th>
			<th>ESTADO</th>
			<th>ACCIONES</th>
		</tr>
		@foreach ($contratos as $index=>$contrato)
		@php
			$convenio=0;
			$convenio_query=\App\Models\Convenio::where('ID_CON',$contrato->ID_CON)->first();
			if ($convenio_query) {
				$convenio=$convenio_query;
			}
		@endphp
		<tr>
			<td>{{$index+1}}</td>
			<td>{{$contrato->FEC_SOL}}</td>
			<td>{{$contrato->FEC_INI}}</td>
			<td>{{$contrato->FEC_FIN}}</td>
			<td><span class="badge bg-blue">{{$contrato->TIPO_PAGO}}</span></td>
			<td>
				@switch($contrato->EST_CON)
				@case('PENDIENTE')
				<span class="badge bg-yellow">PENDIENTE</span>
				@break
				@case('ASIGNADO')
				<span class="badge bg-yellow">ASIGNADO</span>
				@break
				@case('ACTIVO')
				<span class="badge bg-green">ACTIVO</span>
				@break
				@case('BAJA FORZOSA')
				<span class="badge bg-black">BAJA FORZOSA</span>
				@break
				@case('CANCELADO')
				<span class="badge bg-default">CANCELADO</span>
				@break
				@endswitch
			</td>
			<td>
			@if ($contrato->EST_CON=='PENDIENTE' OR $contrato->EST_CON=='ASIGNADO')
				
				<button class="btn btn-success btn-sm" type="button" onclick='modalActiva(@json($contrato))'><i class="fa fa-check"></i></button>
				<button target="_blank" class="btn btn-primary btn-sm" type="button" onclick="modalPdf({{$contrato->ID_CON}});" title="Imprimir Contrato"><i class="fa fa-file"></i></button>
				<button class="btn btn-warning btn-sm" type="button" onclick='modalEdita(@json($contrato),@json($convenio))' title="Editar contrato"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-danger btn-sm" type="button" onclick="modalConfirmaBaja({{$contrato->ID_CON}})" title="Dar de baja el contrato"><i class="fa fa-times"></i></button>
				@if (count($alerta)!=0 AND $alerta[0]['mensaje']=='EN CORTE')
				{{-- <button class="btn bg-black btn-sm" type="button" onclick="modalBajaForzosa({{$contrato->ID_CON}})" title="Dar baja forzosa"><i class="fa fa-arrow-down"></i></button> --}}
				@endif
			@elseif($contrato->EST_CON=='BAJA FORZOSA')
				<button target="_blank" class="btn btn-primary btn-sm" type="button" onclick="modalPdf({{$contrato->ID_CON}});" title="Imprimir Contrato"><i class="fa fa-file"></i></button>
				<button class="btn btn-danger btn-sm" type="button" onclick="modalConfirmaBaja({{$contrato->ID_CON}})" title="Dar de baja el contrato"><i class="fa fa-times"></i></button>
				
			@elseif($contrato->EST_CON=='ACTIVO')	
				<button target="_blank" class="btn btn-primary btn-sm" type="button" onclick="modalPdf({{$contrato->ID_CON}});" title="Imprimir Contrato"><i class="fa fa-file"></i></button>
				<button class="btn btn-warning btn-sm" type="button" onclick='modalEdita(@json($contrato),@json($convenio))' title="Editar contrato"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-danger btn-sm" type="button" onclick="modalConfirmaBaja({{$contrato->ID_CON}})" title="Dar de baja el contrato"><i class="fa fa-times"></i></button>
				@if (count($alerta)!=0 AND $alerta[0]['mensaje']=='EN CORTE')
				{{-- <button class="btn bg-black btn-sm" type="button" onclick="modalBajaForzosa({{$contrato->ID_CON}})" title="Dar baja forzosa"><i class="fa fa-arrow-down"></i></button> --}}
				@endif
			@else	
				<button type="button" onclick="ver_pagos({{$contrato->ID_CON}});" class="btn btn-warning btn-sm"><i class="fa fa-copy" title="Ver recibos de pagos"></i></button>
			@endif	
				<button class="btn bg-black btn-sm" type="button" onclick="modalBajaForzosa({{$contrato->ID_CON}})" title="Dar baja forzosa"><i class="fa fa-arrow-down"></i></button>
				
			</td>
		</tr>
		@endforeach
	</table>
	@if (count($contratos)==0)
	<h4 class="text-center text-muted">NO REGISTRO NINGUN CONTRATO</h4>
	@endif
</div>