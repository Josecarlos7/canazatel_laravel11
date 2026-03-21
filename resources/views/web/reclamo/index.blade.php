@extends('layouts.master')
@section('menu-open','menu-open')
@section('reclamo','active')
@section('tree-web')
style="display: block;"
@endsection
@section('title','RECLAMOS')
@section('content')

<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		@foreach ($sucursales as $index=>$sucursal)
		<li class="{{$index==0?'active':''}}" onclick="clientes({{$sucursal->ID_SUC}})"><a href="#sucursal_{{$sucursal->ID_SUC}}" data-toggle="tab">{{$sucursal->NOM_SUC}}</a></li>
		@endforeach
	</ul>
	<div class="tab-content">
		@foreach ($sucursales as $index=>$sucursal)
		<div class="tab-pane {{$index==0?'active':''}}" id="sucursal_{{$sucursal->ID_SUC}}">
			<div id="div_sucursal_{{$sucursal->ID_SUC}}"></div>
		</div>
		@endforeach
	</div>
</div>
<!-- INICIO MODAL ATENDER -->
<div class="modal fade" id="modalAtiende">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">ATENDER RECLAMO</h4>
			</div>
			<form method="POST" id="atiende" data-parsley-validate>
				@csrf
				<input type="hidden" name="id_rec" id="id_rec" value="">
				<input type="hidden" name="id_suc" id="id_suc" value="">
				<div class="modal-body">
					<div class="row text-center">
						<div class="alert alert-danger"><h3>¿SE ATENDIO EL RECLAMO?</h3></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
					<button type="button" class="btn btn-danger" onclick="atender()"><i class="fa fa-check"></i> Reclamo atendido</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL ATENDER -->
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		var primero={!! json_encode($sucursales->toArray()) !!};
		clientes(primero[0].ID_SUC);
	});

	function clientes(id_suc){
		$.ajax({
			url:"{{url('web/reclamos/')}}"+'/'+id_suc,
			dataType:'HTML',
			beforeSend: function(){$('#div_sucursal_'+id_suc).html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>')},
			success: function(data){
				$('#div_sucursal_'+id_suc).html(data);
			},
			error: function(data){
				console.log(data);
			}
		});
	}
</script>
<script type="text/javascript">
	function atiende_modal(reclamo, id_suc){
		$('#id_rec').val(reclamo.ID_REC);
		$('#id_suc').val(id_suc);
		$('#modalAtiende').modal('show');
	}
	function atender(){
		var id_suc=$('#id_suc').val();
		$.ajax({
			url:"{{route('reclamo.atender')}}",
			type:'POST',
			dataType:'JSON',
			data: $('#atiende').serialize(),
			beforeSend: function(){$('#div_sucursal_'+id_suc).html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>')},
			success: function(data){
				success_message('Reclamo atendido');
				clientes(id_suc);
				$('#modalAtiende').modal('hide');
				console.log(data);
			},
			error: function(data){
				console.log(data);
			}
		});
	}
</script>
@endsection