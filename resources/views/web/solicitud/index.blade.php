@extends('layouts.master')
@section('menu-open','menu-open')
@section('solicitud-web','active')
@section('tree-web')
style="display: block;"
@endsection
@section('title','SOLICITUDES')
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

@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		var primero={!! json_encode($sucursales->toArray()) !!};
		clientes(primero[0].ID_SUC);
	});

	function clientes(id_suc){
		$.ajax({
			url:"{{url('web/solicitudes/')}}"+'/'+id_suc,
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
@endsection