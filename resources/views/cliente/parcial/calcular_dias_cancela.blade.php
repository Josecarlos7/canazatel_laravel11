@php
	if (count($alerta)!=0) {
		$dias=$alerta[0]['dias_deuda'];
	}else{
		$dias=0;
	}

	//dias descuento
	$descuento_dia=0;
	$descuento_dia_query=\App\Models\DescuentoDias::where('ID_CON',$cliente->ID_CON)->orderBy('ID_DD','DESC')->first();
	if ($descuento_dia_query) {
		$pago=\App\Models\PagoDetalle::join('pago','pago.ID_PAG','=','pago_detalle.ID_PAG')
		->where('ID_CON',$cliente->ID_CON)
		->where('MES_PD',$descuento_dia_query->MES_DD)
		->where('ANIO_PD',$descuento_dia_query->ANIO_DD)
		->first();
		if (!$pago) {
			$descuento_dia=$descuento_dia_query->DIAS_DD;
			$dias = $dias-$descuento_dia;
		}
	}
	
	$sub_total=($cliente->PRE_MENS ) + ($cliente->PTS_XTR * $cliente->PRE_PTS_XTR);
	$total = $dias * ( $sub_total / 30 );
	if (is_float($total)) {
		$total=number_format($total,0);
	}


	
@endphp
<input type="hidden" name="dias" value="{{$dias}}">
<input type="hidden" name="monto" value="{{$total-$descuento_dia}}">
<div class="alert alert-danger">
	<ul>
		<li>Al Registrar este pago, se registrará el pago y se dara de Baja el contrato</li>
		<li>Esta opcion de pago solo es si el cliente solicitó la baja del contrato antes de cumplir el mes</li>
		<li>Esta operacion no sera reversible</li>
	</ul>
</div>
<div>
	<table class="table table-bordered text-center">
		<tr class="bg-warning">
			<th>DIAS</th>
			<th>CALCULO</th>
			<th>MONTO A PAGAR</th>
		</tr>
		<tr class="bg-warning">
			<td>
			<h4>{{$dias}} dias</h4>
			</td>
			<td>
				<h4>{{$dias}} dias * ( {{$sub_total}} Bs. / 30 dias )</h4>
			</td>
			<td><h4>{{$total}} Bs.</h4></td>
		</tr>
	</table>
	@if ($descuento_dia!=0)
	<b class="text-danger">* El cliente tiene un descuento de ({{$descuento_dia}}) dias registrado </b>
	@endif
</div>