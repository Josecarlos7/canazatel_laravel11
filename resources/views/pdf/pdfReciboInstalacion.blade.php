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

		.table td{padding: 7px;}
	</style>
</head>
<body>
@php
	$total=0;
@endphp

	<table style="width: 100%" cellspacing="" cellpadding="" border="0">
		<tr>
			<th class="text-left">CANAZATEL TELECOMUNICACIONES</th>
			<th class="text-right">TRANSACCIÓN</th>
		</tr>
		<tr>
			<th class="text-left">{{$contrato->NOM_SUC}}</th>
			@php
			//El codigo lo capturo asi, porque al parecer el pago de instalacion solo tiene un detalle, por lo tanto sera el primero
			$codigo=$pago->detalles[0]->COD_PD;
			@endphp
			<th class="text-right">{{$codigo}}-I</th>
		</tr>
		<tr>
			<th class="text-left">USUARIO: {{$pago->NOM_USU.' '.$pago->PAT_USU}}</th>
			<th class="text-right">{{$pago->FEC_PAG}}</th>
		</tr>
	</table>
	<h2 class="text-center">RECIBO DE COBRO DE {{$contrato->NOM_PLAN}}</h2>
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

	
	<table style="width: 100%;" border="1" class="table"  cellspacing="" cellpadding="">
		<tr style="background-color: #D9D9D9;">
			<th>MOTIVO</th>
			<th>IMPORTE</th>
		</tr>
		@if (count($pago->detalles)!=0)
		@foreach ($pago->detalles as $detalle)
		<tr>
			<td>INSTALACION</td>
			<td>{{$detalle->MONTO_PD}} Bs.</td>
		</tr>
		@php $total=$total + $detalle->MONTO_PD @endphp
		@endforeach
		@endif
		@if (count($pago->otros)!=0)
		@foreach ($pago->otros as $otro)
		<tr>
			<td>{{$otro->DET_PO}} {{$otro->CANT_PO!=''? ' CANTIDAD '.$otro->CANT_PO:'' }}</td>
			<td>{{$otro->MONTO_PO}} Bs.</td>
		</tr>
		@php $total=$total + $otro->MONTO_PO @endphp
		@endforeach
		@endif
	</table>
	<table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
		<tr>
			<td width="50%">FECHA Y HORA DE PAGO: </td>
			<td width="50%">{{$pago->FEC_PAG.' '.$pago->HOR_PAG}}</td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td><b>{{$total}}</b> Bs.</td>
		</tr>
		<tr>
			<td colspan="2">Son <b>{{ \App\Support\MontoEnLetras::bolivianos($total) }}</b></td>
		</tr>
	</table>


	<h2>EL MEJOR ENTRETENIMIENTO FAMILIAR</h2>
	
</body>
</html>