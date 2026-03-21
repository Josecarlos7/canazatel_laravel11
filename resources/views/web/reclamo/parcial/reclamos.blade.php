
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#pendientes" data-toggle="tab">RECLAMOS PENDIENTES</a></li>
		<li class=""><a href="#atendidos" data-toggle="tab">RECLAMOS ATENDIDOS</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="pendientes">
			<h4 class="text-center text-danger">RECLAMOS PENDIENTES</h4>
			@if (count($pendientes)!=0)
			<table class="table table-bordered table-hover table-striped">
				<tr>
					<th>#</th>
					<th>CLIENTE</th>
					<th>CODIGO</th>
					<th>DIRECCION</th>
					<th>CELULAR</th>
					<th>RECLAMO</th>
					<th>FECHA|HORA</th>
					<th>ACCIONES</th>
				</tr>
				@foreach ($pendientes as $index=>$reclamo)
				<tr>
					<td>{{$index+1}}</td>
					<td>{{$reclamo->NOM_CLI.' '.$reclamo->APE_CLI}}</td>
					<td>{{$reclamo->COD_CLI}}</td>
					<td>{{$reclamo->DIR_CLI}}</td>
					<td>{{$reclamo->CEL_CLI}}</td>
					<td>{{$reclamo->REC_REC}}</td>
					<td>{{$reclamo->FEC_REC.' | '.$reclamo->HOR_REC}}</td>
					<td>
						<button class="btn btn-warning btn-sm" type="button" onclick='atiende_modal(@json($reclamo), {{ $id_suc }})'><i class="fa fa-eye"></i></button>
					</td>
				</tr>
				@endforeach
			</table>
			@else
			<h4 class="text-center text-muted">NO SE REGISTRARON RECLAMOS EN ESTA SUCURSAL</h4>
			@endif
		</div>
		<div class="tab-pane" id="atendidos">
			<h4 class="text-center text-success">RECLAMOS ATENDIDOS</h4>
		@if (count($atendidos)!=0)
			<table class="table table-bordered table-hover table-striped">
				<tr>
					<th>#</th>
					<th>CLIENTE</th>
					<th>CODIGO</th>
					<th>DIRECCION</th>
					<th>CELULAR</th>
					<th>RECLAMO</th>
					<th>FECHA|HORA</th>
				</tr>
				@foreach ($atendidos as $index=>$reclamo)
				<tr>
					<td>{{$index+1}}</td>
					<td>{{$reclamo->NOM_CLI.' '.$reclamo->APE_CLI}}</td>
					<td>{{$reclamo->COD_CLI}}</td>
					<td>{{$reclamo->DIR_CLI}}</td>
					<td>{{$reclamo->CEL_CLI}}</td>
					<td>{{$reclamo->REC_REC}}</td>
					<td>{{$reclamo->FEC_REC.' | '.$reclamo->HOR_REC}}</td>
				</tr>
				@endforeach
			</table>
			@else
			<h4 class="text-center text-muted">NO HAY RECLAMOS ATENDIDOS EN ESTA SUCURSAL</h4>
			@endif
		</div>
	</div>
</div>	




