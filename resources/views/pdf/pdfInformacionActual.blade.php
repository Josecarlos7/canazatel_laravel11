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
		table td{
			padding: 4px;
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
	<h3 style="text-align: center;">DATOS ACTUALES DEL CLIENTE</h3>
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
		
	</table>
	<h3 style="text-align: center;">DATOS ACTUALES</h3>
	
	
	<div class="col-md-12">
		@if ($activo)
		@switch($activo->EST_CON)
		    @case('ACTIVO')
			<div class="callout callout-success">
		    @break
		    @case('BAJA FORZOSA')
			<div class="callout bg-black">
		    @break
		    @default
			<div class="callout callout-warning">
		@endswitch
			<br>
			<div style="background-color: #DADADA; padding: 5px; text-align: center;" id="toggle-recoge" class="btn btn-{{$activo->RCG_CON=='SI'?'success':'danger'}} btn-sm"><b>{{$activo->RCG_CON=='SI'?'RECOGIDO':'NO RECOGIDO'}}</b></div>
			@if (count($alerta)!=0)
			@if ($alerta[0]['mensaje']!='')
			<br>
			<b>MENSAJE: </b><span class="badge bg-red animated fadeIn infinite">{{$alerta[0]['mensaje']}}</span>
			@endif
			@endif
			<br>
			<table style="width: 100%" cellpadding="" cellspacing="" border="1">
				<tr>
					<td><b>ESTADO: </b></td>
					<td><span class="badge bg-black {{$activo->EST_CON!='ACTIVO'?'animated fadeIn infinite':''}}">{{$activo->EST_CON}}</span></td>
				</tr>
				<tr>
					<td><b>TIPO DE PAGO: </b></td>
					<td>{{$activo->TIPO_PAGO}}</td>
				</tr>
				<tr>
					<td><b>PUNTOS EXTRA: </b></td>
					<td>{{$activo->PTS_XTR}} /Puntos</td>
				</tr>
				<tr>
					<td><b>FECHA SOLICITUD: </b></td>
					<td>{{$activo->FEC_SOL}}</td>
				</tr>
				<tr>
					<td><b>FECHA ACTIVACIÓN: </b></td>
					<td>{{$activo->FEC_INI}}</td>
				</tr>
				<tr>
					<td><b>PLAN: </b></td>
					<td>{{$activo->NOM_PLAN}}</td>
				</tr>
				<tr>
					<td><b>MENSUALIDAD: </b></td>
					<td>{{$activo->PRE_MENS}} Bs.</td>
				</tr>
				<tr>
					<td><b>DIA DE COBRO: </b></td>
					<td>{{$activo->DIA_CBR}} de cada mes</td>
				</tr>
				@if (count($activo->convenio)!=0)
				<tr>
					<td><b>CONVENIO: </b></td>
					<td><span class="badge bg-black animated fadeIn infinite">TIENE CONVENIO</span></td>
				</tr>
				<tr>
					<td><b>TIPO CONVENIO:</b></td>
					<td>{{$activo->convenio[0]->TIPO_CVN}}</td>
				</tr>
				<tr>
					<td><b>DESCUENTO:</b></td>
					<td>{{$activo->convenio[0]->DESC_CVN}} %</td>
				</tr>
				@endif
				
			</table> 

			 			
		</div>
		@else
		<div class="callout callout-danger text-center">
			<h5>NO TIENE NINGUN CONTRATO ACTIVO ACTUALMENTE, CREE UN NUEVO CONTRATO EN LA PESTAÑA DE HISTORIAL DE CONTRATOS</h5>
		</div>
		@endif
		@if ($ultimo_pago)
		<div class="callout callout-info">
			<h3 style="text-align: center;">ULTIMO PAGO REALIZADO</h3>
			<table style="width: 100%" cellpadding="" cellspacing="" border="1">
			<tr>
				<td><b>FECHA: </b></td>
				<td>{{$ultimo_pago->FEC_PAG}}</td>
			</tr>
			<tr>
				<td><b>DIAS GRATIS: </b></td>
				<td>{{$ultimo_pago->DIAS_GRTS}}</td>
			</tr>
			<tr>
				<td><b>PROXIMA FECHA DE PAGO: </b></td>
				<td>{{$ultimo_pago->FEC_PROX}}</td>
			</tr>
			</table>
			 
		</div>
		
		@endif
	</div>
	
	
</body>
</html>