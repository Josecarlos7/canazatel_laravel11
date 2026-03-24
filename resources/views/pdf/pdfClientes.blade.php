<!DOCTYPE html>
<html>
<head>
	<title>REPORTE CLIENTES</title>
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
	<div style="text-align: center"><h1>REPORTE CLIENTES</h1></div>
	<table cellpadding="" cellspacing="" border="1" style="width: 100%; text-align: center;">
		<tr>
			<td><b>TIPO DE BUSQUEDA: </b> {{$tipo}}</td>
			<td><b>SUCURSAL:</b> {{$sucursal->NOM_SUC}}</td>
		</tr>
	</table>
	<br>
	<br>
	<br>
	<table cellpadding="" cellspacing="" border="1" style="width: 100%; text-align: center;">
		<tr style="background-color: #D1D1D1;">
			<th>#</th>
			<th>CLIENTE</th>
			<th>CODIGO</th>
			<th>ALERTA</th>
		</tr>
		@foreach ($lista as $index=>$elemento)
		<tr>
			<td>{{$index+1}}</td>
			<td>{{$elemento['nom_cli'].' '.$elemento['ape_cli']}}</td>
			<td>{{$elemento['cod_cli']}}</td>
			<td>{{$elemento['mensaje']}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>