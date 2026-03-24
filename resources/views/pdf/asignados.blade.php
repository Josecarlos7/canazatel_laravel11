<!DOCTYPE html>
<html>
<head>
	<title>LISTA DE ASIGNADOS</title>
	<style type="text/css">
		@page{
			margin: 0cm;
			margin-top: 1cm;
			margin-bottom: 1cm;
			margin-left: 1cm;
			margin-right: 1cm;
		}
		body {
			font-family: "Helvetica";
			font-size: 9.7px;
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
		.medio{
			vertical-align: middle;
		}
		.ch{
			margin-bottom: -8px;
		}
		.ok{
			background-color: black !important; 
			width: 20px;
			margin-left: -2px;
			transform: scale(0.60);
		}
	</style>
</head>
<body>
	<div class="format">
		<h1 style="text-align: center; font-size: 2.5em;">LISTA DE CLIENTES ASIGNADOS</h1>
		<table style="width: 100%" border="1" cellspacing="0">
			<tr>
				<td style="padding: 10px; text-align: center;">
					<b>SUCURSAL: </b> {{$sucursal->NOM_SUC}}<br>
					<b>FECHA Y HORA DE IMPRESIÓN: </b> {{\Carbon\Carbon::now()->format('Y-m-d').' '.\Carbon\Carbon::now()->format('H:i:s')}}
				</td>
			</tr>
		</table>
		<br>
		
		<table style="width: 100%; text-align: center; " cellspacing="" cellpadding="" border="1">
			<tr style="background-color: #D8D8D8;">
				<th>#</th>
				<th>CODIGO</th>
				<th>CLIENTE</th>
				<th>CI/NIT</th>
				<th>DIRECCION</th>
				<th>FECHA SOLICITUD</th>
			</tr>
			@foreach ($clientes as $index=>$cliente)
			<tr>
				<td>{{$index+1}}</td>
				<td>{{$cliente->COD_CLI}}</td>
				<td>{{$cliente->NOM_CLI.' '.$cliente->APE_CLI}}</td>
				<td>{{$cliente->CI_CLI}}</td>
				<td>{{$cliente->DIR_CLI}}</td>
				<td>{{$cliente->FEC_SOL}}</td>
			</tr>
			@endforeach
		</table>

		
	</div>
</body>
</html>
