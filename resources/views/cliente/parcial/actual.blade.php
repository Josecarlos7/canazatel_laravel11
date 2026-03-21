
<div class="row">
	{{\Carbon\Carbon::now()->format('Y-m-d H:i:s')}}
	<div class="col-md-4">
		@if ($activo)
		@switch($activo->EST_CON)
		    @case('ACTIVO')
			<div class="callout callout-success">
		    @break
		    @case('BAJA FORZOSA')
			<div class="callout bg-black">
		    @break
		    @default
			<div class="callout callout-warning">
		@endswitch
				
			<h4>CONTRATO ACTUAL</h4>
			<br>
			<button id="toggle-recoge" type="button" onclick="recoge({{$activo->ID_CON}})" class="btn btn-{{$activo->RCG_CON=='SI'?'success':'danger'}} btn-sm">{{$activo->RCG_CON=='SI'?'RECOGIDO':'NO RECOGIDO'}}</button>
			@if (count($alerta)!=0)
			@if ($alerta[0]['mensaje']!='')
			<br>
			<b>MENSAJE: </b><span class="badge bg-red animated fadeIn infinite">{{$alerta[0]['mensaje']}}</span>
			@endif
			@endif
			<br>
			<b>ESTADO: </b> <span class="badge bg-black {{$activo->EST_CON!='ACTIVO'?'animated fadeIn infinite':''}}">{{$activo->EST_CON}}</span>
			<br>
			<b>TIPO DE PAGO: </b>{{$activo->TIPO_PAGO}}
			<br>
			<b>PUNTOS EXTRA: </b>{{$activo->PTS_XTR}} /Puntos
			<br>
			<b>FECHA SOLICITUD: </b> {{$activo->FEC_SOL}}
			<br>
			<b>FECHA ACTIVACIÓN: </b> {{$activo->FEC_INI}}
			<br>
			<b>PLAN: </b> {{$activo->NOM_PLAN}}
			<br>
			<b>MENSUALIDAD: </b> {{$activo->PRE_MENS}} Bs.
			<br>
			<b>DIA DE COBRO: </b> {{$activo->DIA_CBR}} de cada mes
			@if (count($activo->convenio)!=0)
			<div class="bg-red" style="padding: 7px;">
			<b>CONVENIO: </b><span class="badge bg-black animated fadeIn infinite">TIENE CONVENIO</span>
			<br>
			<b>TIPO CONVENIO:</b> {{$activo->convenio[0]->TIPO_CVN}}
			<br>
			<b>DESCUENTO:</b> {{$activo->convenio[0]->DESC_CVN}} %
			</div>
			@endif
		</div>
		@else
		<div class="callout callout-danger text-center">
			<h5>NO TIENE NINGUN CONTRATO ACTIVO ACTUALMENTE, CREE UN NUEVO CONTRATO EN LA PESTAÑA DE HISTORIAL DE CONTRATOS</h5>
		</div>
		@endif
		@if ($ultimo_pago)
		<div class="callout callout-info">
			<h4>ULTIMO PAGO REALIZADO</h4>
			<b>FECHA: </b> {{$ultimo_pago->FEC_PAG}}
			<br>
			<b>DIAS GRATIS: </b> {{$ultimo_pago->DIAS_GRTS}}
			<br>
			<b>PROXIMA FECHA DE PAGO: </b> {{$ultimo_pago->FEC_PROX}}
		</div>
		
		@endif
	</div>
	<div class="col-md-8 table-responsive">
		@if ($activo)
		<div class="row">
			<div class="col-md-6">
				@if ($activo->EST_CON == 'BAJA FORZOSA')
				<button class="btn btn-success btn-sm btn-block disabled" type="button" disabled=""><i class="fa fa-dollar"></i> PAGO MENSUALIDAD</button>
				@else
				<button class="btn btn-success btn-sm btn-block" type="button" onclick="modalPago({{$activo->ID_CON}});"><i class="fa fa-dollar"></i> PAGO MENSUALIDAD</button>
				@endif
				
			</div>
			<div class="col-md-6">
				<button class="btn btn-success btn-sm btn-block" type="button" onclick="modalOtros({{$activo->ID_CON}});"><i class="fa fa-dollar"></i> OTROS PAGOS</button>
			</div>
		</div>
		{{-- INICIO DEUDAS --}}
		<table class="table table-hover table-bordered table-striped" style="margin-bottom: 0px;">
		@foreach ($deudas->all() as $deuda)
			<tr>
				<td class="bg-danger" colspan="2">DEUDA MENSUALIDAD</td>
				<td class="bg-danger" colspan="2">{{$deuda['año'].'/'.$deuda['mes']}}</td>
			</tr>
		@endforeach
		@if (count($alerta)!=0)
		<tr class="bg-red text-center">
			<td colspan="3">DIAS DEUDA: {{$alerta[0]['dias_deuda']}} /dias</td>
		</tr>
		@endif
		</table>
		{{-- FIN DEUDAS --}}
		@if (count($pagos)!=0)
		<table class="table table-hover table-bordered table-striped">
			<tr class="bg-gray">
				<th>#</th>
				<th>MOTIVO</th>
				<th>AÑO/MES</th>
				<th>ACCIONES</th>
			</tr>
			@foreach ($pagos as $index=>$pago)
			{{-- @if (count($pago->detalles)!=0) --}}
			@if ($pago->ID_PD!=null){{-- Verifica que no sea padre sin hijos --}}
			<tr>
				<td>{{$index+1}}</td>
				<td>{{$pago->MOT_PAG}}</td>
				<td>{{$pago->ANIO_PD.'/'.$pago->MES_PD}}</td>
				<td>
					@if ($pago->FTR_PD==0)
					<button class="btn bg-gray btn-xs" type="button" title="Sin Factura" id="btn_factura_{{$pago->ID_PD}}" onclick="factura({{$pago->ID_PD}})">S/F</button>
					@else
					<button class="btn bg-green btn-xs" type="button" title="Tiene Factura" id="btn_factura_{{$pago->ID_PD}}" onclick="factura({{$pago->ID_PD}})">F</button>
					@endif
					@if ($pago->MOT_PAG=='INSTALACION')
					<a href="{{url('cliente/informacion/pago/instalacion/recibo/'.$pago->ID_PAG)}}" target="_blank" class="btn btn-warning btn-xs" title="Imprimir recibo"><i class="fa fa-file"></i></a>
					@elseif($pago->MOT_PAG=='MENSUALIDAD')
					<a href="{{url('cliente/informacion/pago/mensualidad/'.$pago->ID_PD)}}" target="_blank" class="btn btn-warning btn-xs" title="Imprimir recibo mensual"><i class="fa fa-file"></i></a>
					@else
					<a href="{{url('cliente/informacion/pago/recibo/'.$pago->ID_PAG)}}" target="_blank" class="btn btn-warning btn-xs" title="Imprimir recibo"><i class="fa fa-file"></i></a>
					@endif
					@hasanyrole('ADMINISTRADOR|SUPER_ADMIN|GERENCIA GENERAL')
					@if ($pago->MOT_PAG != 'COMPRA MATERIALES')
					<button class="btn btn-danger btn-xs" type="button" title="Eliminar Pago" onclick="modalEliminaPago({{$pago->ID_PD}})"><i class="fa fa-trash"></i></button>
					@endif
					@endhasanyrole
				</td>
			</tr>
			@endif{{-- Verifica que no sea padre sin hijos --}}
			{{-- @endif --}}
			@endforeach	
		</table>
		@else
		<h4 class="text-center text-muted">NO SE REGISTRO NINGUN PAGO DE MENSUALIDAD TODAVÍA</h4>
		@endif
		@else
		<h4 class="text-center text-muted"><i class="fa fa-info-circle fa-2x"></i><br>NO TIENE NINGUN CONTRATO ACTIVO ACTUALMENTE</h4>
		@endif
	</div>
</div>