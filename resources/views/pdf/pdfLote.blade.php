<!DOCTYPE html>
<html>
<head>
	<title>PAGOS REALIZADOS</title>
	<style type="text/css">
		@page{
			margin: 0cm;
			margin-top: 1cm;
			margin-bottom: 1cm;
			margin-left: 1cm;
			margin-right: 1cm;
		}
		body {
			font-family: "Courier";
			font-size: 14.5px;
			/*color: #676a6c;*/
			color:black;
		}
		.format{
			position: absolute; 
			z-index: 1;
		}
		.principal{
			font-size: 1.8em;
			font-weight: bold;
		}
		.secundario{
			font-size: 1.2em;
			font-weight: bold;
		}
		.text-left{text-align: left}
		.text-right{text-align: right}
		.text-center{text-align: center}
	</style>
</head>
<body>
@php
	$contador=1;
	$numero=count($pagos);
@endphp
	@foreach ($pagos as $pago)
	<table style="width: 100%" cellspacing="" cellpadding="" border="0">
		<tr>
			<th class="text-left">CANAZATEL TELECOMUNICACIONES</th>
			<th class="text-right">TRANSACCIÓN</th>
		</tr>
		<tr>
			<th class="text-left">{{$contrato->NOM_SUC}}</th>
			@if ($pago->MOT_PAG=='MENSUALIDAD')
			<th class="text-right">{{$pago->COD_PD}}-M</th>
			@else
			<th class="text-right">{{$pago->COD_PD}}-OTR</th>
			@endif
		</tr>
		<tr>
			<th class="text-left">USUARIO: {{$pago->NOM_USU.' '.$pago->PAT_USU}}</th>
			<th class="text-right">{{$pago->FEC_PAG}}</th>
		</tr>
	</table>
	<h2 class="text-center">RECIBO DE COBRO DE SERVICIO DE TV CABLE</h2>
	<table style="width: 100%" cellspacing="" cellpadding="" border="0">
		<tr>
			<td width="50%">NOMBRE: {{$pago->NOM_CLI.' '.$pago->APE_CLI}}</td>
			<td width="50%">USUARIO: {{$pago->COD_CLI}}</td>
		</tr>
		<tr>
			<td>DIRECCION: {{$pago->DIR_CLI}}</td>
			<td>CATEGORIA:</td>
		</tr>
		<tr>
			<td>CI/NIT {{$pago->CI_CLI}}</td>
			<td>FECHA DE INSTALACION {{$pago->FEC_SOL}}</td>
		</tr>
	</table>
	<hr style="width: 100%">
	@if ($pago->MOT_PAG=='MENSUALIDAD')
	<table style="width: 100%;" border="1"  cellspacing="4" cellpadding="4">
		<tr>
			<td width="50%">
				POR EL MES DE: {{$pago->MES_PD.'/'.$pago->ANIO_PD}}<br> FECHA DE PROCESO DEL RECIBO {{$pago->FEC_PAG}}
				</td>
			<td width="50%">
				DESDE EL {{$pago->FEC_INI_PD}} HASTA {{$pago->FEC_FIN_PD}}<br>
				FECHA DE PROXIMO VENCIMIENTO {{$pago->FEC_PROX}}
			</td>
		</tr>
	</table>
	<table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
		<tr>
			<td width="50%">FECHA Y HORA DE PAGO: </td>
			<td width="50%">{{$pago->FEC_PAG.' '.$pago->HOR_PAG}}</td>
		</tr>
		<tr>
			<td>Importe por  Mensualidad:</td>
			<td>
			
			{{$pago->PRE_MENS_PD}} Bs. 
			@if ($pago->DIAS_DSC != 0)
			- {{$pago->DIAS_DSC}} Bs. (Descuento por días)
			@endif
			</td>
		</tr>
		<tr>
			<td>Importe por punto extra:</td>
			<td>{{$contrato->PTS_XTR*$pago->PRE_PTS_XTR_PD}} Bs. = ({{$contrato->PTS_XTR}} pts x {{$pago->PRE_PTS_XTR_PD}} Bs.)</td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td><b>{{$pago->MONTO_PD}}</b> Bs.</td>
		</tr>
		<tr>
			<td colspan="2">Son <b>{{ \App\Support\MontoEnLetras::bolivianos($pago->MONTO_PD) }}</b></td>
		</tr>
	</table>
	@else
	<table style="width: 100%;" border="1"  cellspacing="4" cellpadding="4">
		<tr>
			<td width="100%">
				PAGO POR: <b>{{$pago->MOT_PAG}}</b>
			</td>
		</tr>
	</table>
	<table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
		<tr>
			<td width="50%">FECHA Y HORA DE PAGO: </td>
			<td width="50%">{{$pago->FEC_PAG.' '.$pago->HOR_PAG}}</td>
		</tr>
		<tr>
			<td>Importe por  {{$pago->MOT_PAG}}:</td>
			<td>{{$pago->MONTO_PD}} Bs.</td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td><b>{{$pago->MONTO_PD}}</b> Bs.</td>
		</tr>
		<tr>
			<td colspan="2">Son <b>{{ \App\Support\MontoEnLetras::bolivianos($pago->MONTO_PD) }}</b></td>
		</tr>
	</table>
	@endif
	

	<h2>EL MEJOR ENTRETENIMIENTO FAMILIAR</h2>
	@if ($contador!=$numero)
	<div style="page-break-after:always;"></div>
	@php
		$contador++;
	@endphp
	@endif
	@endforeach
</body>
</html>