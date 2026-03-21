<input type="hidden" name="id_con" value="{{$id_con}}">
<div class="table-responsive">
@if ($contrato->EST_CON == 'BAJA FORZOSA')
	<div class="alert alert-danger text-center">
		<i class="fa fa-warning"></i><br>
		Debido a que el contrato esta con <b>BAJA FORZOSA</b> debera pagar los meses de deuda, y luego de pagar la deuda podra <b>DAR DE BAJA</b> este contrato para poder crear un <b>NUEVO CONTRATO</b>
	</div>
@endif
<table class="table table-hover table-bordered table-striped table-sm text-center">
	<tr class="bg-gray">
		{{-- <th>FECHA</th>  --}}
		{{-- <th>VENCIMIENTO</th> --}} 
		<th>MES</th>
		<th>AÑO</th>
		<th>PLAN</th>
		<th>CONVENIO</th>
		<th>PUNTOS EXTRA</th>
		<th>MONTO NORMAL</th>
		<th>SUBTOTAL</th>
	</tr>
	@php 
	$total=0; $sub_total=0; $normal=0; 
	if ($contrato->EST_CON == 'BAJA FORZOSA') {
		$nro_meses=$meses_tolerancia;
	}
	//calculo cuando ya no hay deudas, buscanos con este comentario
	if ($contrato->EST_CON=='BAJA FORZOSA' AND $contrato->DEU_BF=='NO') {
        $nro_meses=0;
    }
	@endphp
	@for ($i = 0; $i < $nro_meses ; $i++)
	@php
	$convenio=false;
	$tipo_convenio='';
	$descuento=0;
	$descuento_total=0;

	$fecha_inicio_conteo=$fecha_inicio_conteo->addMonth();
	$mes=$fecha_inicio_conteo->isoFormat('MMMM');
	$año=$fecha_inicio_conteo->format('Y');
	if (count($contrato->convenio)!=0) {
		$convenio=true;
		$tipo_convenio=$contrato->convenio[0]->TIPO_CVN;
		$descuento_convenio=$contrato->convenio[0]->DESC_CVN;
		if ($tipo_convenio == 'DESCUENTO') {
			$descuento_total = $contrato->PRE_MENS*($descuento_convenio/100);
		}else{
			$descuento_total = $contrato->PRE_MENS;
		}
	}

	

	$normal=$contrato->PRE_MENS;
	$sub_total=($contrato->PRE_MENS - $descuento_total) + ($contrato->PTS_XTR * $contrato->PRE_PTS_XTR);

	//INICIO DESCUENTO DIAS
	$descuento_dias=\App\Models\DescuentoDias::where('ID_CON',$contrato->ID_CON)->where('MES_DD',strtoupper($mes))->where('ANIO_DD',$año)->first();
	$descuento=0;
	if ($descuento_dias) {
		$descuento=$sub_total-$descuento_dias->MONTO_DD;
	}
	//FIN DESCUENTO DIAS

	$total=($total+$sub_total)-$descuento;

	

	@endphp
	<tr>
		{{-- <td>{{$fecha_inicio_conteo->format('Y-m-d')}}</td> --}} 
		{{-- <td>{{dia_pago($fecha_inicio_conteo->format('Y-m-d'), $id_con)}}</td> --}}
		{{-- <td>{{proxima_fecha($fecha_inicio_conteo->format('Y-m-d'), $contrato->DIA_CBR)}}</td> --}}
		<td>{{ strtoupper($mes)}}</td>
		<td>{{$año}}</td>
		<td><span class="badge badge-default">{{$contrato->NOM_PLAN}}</span></td>
		<td>
		@if ($convenio)
		<span class="badge bg-red">CONVENIO | {{$tipo_convenio}} {{$tipo_convenio=='DESCUENTO'?' | '.$descuento_convenio.' %':''}}</span>
		@else
		<span class="badge bg-gray">SIN CONVENIO</span>
		@endif
		</td>
		<td>
			{{$contrato->PTS_XTR}} pts x {{$contrato->PRE_PTS_XTR}} Bs = {{$contrato->PTS_XTR * $contrato->PRE_PTS_XTR}} Bs.
		</td>
		<td>{{$normal}} Bs.</td>
		<td>
		{{$sub_total}} 
		@if ($descuento!=0)
		<b class="text-danger"> - {{$descuento}} = {{$sub_total - $descuento}} Bs.</b>
		@endif
		</td>
	</tr>
	@endfor
	<tr class="bg-blue">
		<td colspan="7" class="text-center">
			GRATIS: <b>{{$dias_gratis}} / dias</b>
		</td>
	</tr>
	<tr class="bg-black text-center">
		<td colspan="6">TOTAL A PAGAR: </td>
		<td> {{$total}} Bs.</td>
	</tr>    	
</table>
</div>
<button class="btn btn-success btn-block" data-toggle="modal" data-target="#modalConfirma" type="button"><i class="fa fa-check"></i> REGISTRAR PAGO</button>