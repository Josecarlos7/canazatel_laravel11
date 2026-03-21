<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped">
		<tr>
			<th>#</th>
			<th>MOTIVO</th>
			<th>AÑO/MES</th>
			<th>ACCIONES</th>
		</tr>
		@foreach ($pagos as $index=>$pago)
		<tr>
			<td>{{$index+1}}</td>
			<td>{{$pago->MOT_PAG}}</td>
			<td>{{$pago->ANIO_PD.'/'.$pago->MES_PD}}</td>
			<td>
				
			@if ($pago->MOT_PAG=='INSTALACION')
			<a href="{{url('cliente/informacion/pago/instalacion/recibo/'.$pago->ID_PAG)}}" target="_blank" class="btn btn-warning btn-xs" title="Imprimir recibo"><i class="fa fa-file"></i></a>
			@else
			<a href="{{url('cliente/informacion/pago/recibo/'.$pago->ID_PAG)}}" target="_blank" class="btn btn-warning btn-xs" title="Imprimir recibo"><i class="fa fa-file"></i></a>
			@endif
			</td>
		</tr>
		@endforeach	
	</table>
</div>