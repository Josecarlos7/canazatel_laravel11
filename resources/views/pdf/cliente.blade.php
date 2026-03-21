<!DOCTYPE html>
<html>
<head>
	<title>INFORMACION DEL CLIENTE</title>
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
			font-size: 16.5px;
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
		.p-1{
			padding: 8px;
		}
		.medio{
			vertical-align: middle;
		}
		.ch{
			margin-bottom: -9px;
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

	<table style="width: 100%" cellspacing="" cellpadding="" border="0">
		<tr>
			<th class="text-left">CANAZATEL TELECOMUNICACIONES</th>
			<th class="text-right">DATOS DEL CLIENTE</th>
		</tr>
		
	</table>
	<h3 style="text-align: center;">DATOS DE REFERENCIA</h3>
	<br>
	<br>
	<table style="width: 100%" cellspacing="0" cellpadding="0" border="1">
		<tr>
			<td><b>CODIGO:</b> {{$cliente->COD_CLI.'-'.$cliente->ABR_SUC}}</td>
			<td><b>NOMBRES:</b> {{$cliente->NOM_CLI}}</td>
		</tr>
		<tr>
			<td><b>APELLIDOS:</b> {{$cliente->APE_CLI}}</td>
			<td><b>NRO DE CI/NIT:</b> {{$cliente->CI_CLI}}</td>
		</tr>
		<tr>
			<td><b>CELULAR:</b> {{$cliente->CEL_CLI}}</td>
			<td><b>TELEFONO:</b> {{$cliente->TEL_CLI}}</td>
		</tr>
		<tr>
			<td><b>SUCURSAL:</b> {{$cliente->NOM_SUC}}</td>
			<td><b>DIRECCION:</b> {{$cliente->DIR_CLI}}</td>
		</tr>
		<tr>
			<td><b>DESCRIPCION DE LA DIRECCION:</b> {{$cliente->DES_DIR}}</td>
			<td></td>
		</tr>
	</table>
	<h3 style="text-align: center;">PERSONA DE REFERENCIA</h3>
	
	<table style="width: 100%" cellspacing="0" cellpadding="0" border="1">
		<tr>
			<td><b>NOMBRES:</b> {{$cliente->NOM_PR}}</td>
			<td><b>CEDULA DE IDENTIDAD:</b> {{$cliente->CI_PR}}</td>
		</tr>
		<tr>
			<td><b>CELULAR:</b> {{$cliente->CEL_PR}}</td>
			<td></td>
		</tr>
	</table>
	<br>
	<br>
	<br>
	<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<input type="checkbox" class="medio ch {{$cliente->FOT_CI=='SI'?'ok':''}}"> <b>FOTOCOPIA DE CARNET</b>
			</td>
			<td>
				<input type="checkbox" class="medio ch {{$cliente->FOT_LUZ=='SI'?'ok':''}}"> <b>FOTOCOPIA DE LUZ</b>
			</td>
			<td>
				<input type="checkbox" class="medio ch {{$cliente->FOT_AGU=='SI'?'ok':''}}"> <b>FOTOCOPIA DE AGUA</b>
			</td>
		</tr>
	</table>
	
</body>
</html>