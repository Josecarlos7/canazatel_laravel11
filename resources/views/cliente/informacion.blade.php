@extends('layouts.master')
@section('cliente','active')
@section('title','INFORMACION DEL CLIENTE')
@section('content')
<div class="col-md-12 col-xs-12 bg-blue text-center"><h3><i class="fa fa-user"></i> {{$cliente->NOM_CLI.' '.$cliente->APE_CLI}}</h3></div>
<br>
<br>
<br>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#actual" onclick="actual();" data-toggle="tab">CONTRATO ACTUAL</a></li>
		<li class=""><a href="#historial" onclick="historial();" data-toggle="tab">HISTORIAL DE CONTRATOS</a></li>
		<li class=""><a href="#datos" data-toggle="tab" onclick='datos_cliente(@json($cliente))'>DATOS DEL CLIENTE</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="actual">
			<form id="form_pagos">
				<div id="div_actual">
				</div>
			</form>
		</div>
		<div class="tab-pane" id="historial">
			<div id="div_historial"></div>
		</div>
		<div class="tab-pane" id="datos">
			<div class="row"></div>
			<table class="table table-hover table-bordered text-center">
				<tbody class="bg-success">
					<tr>
						<td><b>NOMBRE CLIENTE:</b> <p id="nom_cli"><p/></td>
						<td><b>CEDULA/NIT:</b> <p id="ci_cli"><p/></td>
					</tr>
					<tr>
						<td><b>CELULAR:</b><p id="cel_cli"></p></td>
						<td><b>TELEFONO:</b><p id="tel_cli"></p></td>
					</tr>
					<tr>
						<td><b>DIRECCIÓN:</b> <p id="dir_cli"></p></td>
						<td><b>DESCRIPCION DE LA DIRECCIÓN:</b> <p id="des_dir"></p></td>
					</tr>
				</tbody>
			</table>
			<div style="width: 100%; height: 300px;" id="map"></div>
		</div>
	</div>
</div>
</div>


<!-- INICIO MODAL ACTIVA -->
<div class="modal fade" id="modalActiva">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">ACTIVAR EL CONTRATO</h4>
			</div>
			<form id="form_activa">
				<input type="hidden" name="id_con" id="id_con" value="">
				<div class="modal-body text-center">
					<h1 class="text-primary">¿Esta seguro que desea activar el contrato?</h1>
				</div>
				<div class="form-group col-md-12">
					<label>FECHA DE ACTIVACIÓN</label>
					<input type="date" class="form-control" name="fec_ini" id="fec_ini" value="">
					<b class="text-danger" id="msj_ini"></b>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
					<button type="button" class="btn btn-primary" id="btn_activa" onclick="activa();"><i class="fa fa-check"></i> Activar contrato</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL ACTIVA -->
<!-- INICIO MODAL PAGO MENSUALIDADES -->
<div class="modal fade" id="modalNuevoPago">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">NUEVO PAGO</h4>
			</div>
			<form id="form_pago">
				<input type="hidden" name="id_con" id="id_con" value="">
				<div class="modal-body">
					
					<div class="form-group ">
						<label>SELECCIONE LA CANTIDAD DE MESES A PAGAR</label>
						<select class="form-control" name="nro_mes" id="nro_mes" onchange="limpia();">
							<option value="1" selected="">1 MES</option>
							<option value="2">2 MESES</option>
							<option value="3">3 MESES</option>
							<option value="4">4 MESES</option>
							<option value="5">5 MESES</option>
							<option value="6">6 MESES</option>
							<option value="7">7 MESES</option>
							<option value="8">8 MESES</option>
							<option value="9">9 MESES</option>
							<option value="10">10 MESES</option>
							<option value="11">11 MESES</option>
							<option value="12">12 MESES</option>
						</select>
						<button class="btn btn-warning btn-sm btn-block" type="button" id="btn_calcular" onclick="calcular();"><i class="fa fa-pencil-square-o"></i>Calcular</button>
						<div id="div_datos"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary pull-left" onclick="cancelar()"><i class="fa fa-times"></i> Cancelar</button>
					<div id="div_btn_pagar"></div>
					{{-- <button type="button" class="btn btn-primary" id="btn_pago" onclick="pagar();"><i class="fa fa-check"></i> Registrar Pago</button> --}}
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL PAGO MENSUALIDADES -->
<!-- INICIO MODAL OTROS PAGOS -->
<div class="modal fade" id="modalOtros">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">OTROS PAGOS</h4>
			</div>
			<form id="form_otros">
				<input type="hidden" name="id_con" id="id_con" value="">
				<div class="modal-body">
					<div class="form-group ">
						<label>OTROS PAGOS</label>
						<select class="form-control" name="otros" id="otros" onchange="select_otros(this.value)">
							<option selected="" disabled="">-SELECCIONE EL PAGO QUE REALIZARÁ-</option>
							<optgroup label="INTERNET">
								<option value="CAMBIO ONT">CAMBIO DE LA ONT O ONU | El costo por el servicio es: {{$cnf->PRE_CAMBIO_ONT}} Bs.</option>
								<option value="TRASLADO EXTERNO">TRASLADO EXTERNO | El costo por el servicio es: {{$cnf->PRE_TRASLADO_E}} Bs.</option>
								<option value="TRASLADO INTERNO">TRASLADO INTERNO | El costo por el servicio es: {{$cnf->PRE_TRASLADO_I}} Bs.</option>
							</optgroup>
							<optgroup label="TV CABLE">
								<option value="VENTA MATERIALES">VENTA MATERIALES</option>
								<option value="DIAS CANCELA">PAGAR POR DIAS Y CANCELAR</option>
								<option value="RECONEXION">RECONEXION | El costo por el servicio es: {{$cnf->PRE_RECONEXION}} Bs.</option>
								<option value="RECONEXION GRATIS">RECONEXION GRATIS | El costo por el servicio es: {{$cnf->PRE_REC_GRTS}} Bs.</option>
								<option value="REPARACION">REPARACION | El costo por el servicio es: {{$cnf->PRE_REPARACION}} Bs.</option>
								<option value="REPARACION GRATIS">REPARACION GRATIS | El costo por el servicio es: {{$cnf->PRE_REP_GRTS}} Bs.</option>
								<option value="REPOSICION DE CABLE">REPOSICIÓN DE CABLE | El costo por el servicio es: {{$cnf->PRE_REPO_CABLE}} Bs.</option>
								<option value="TRASLADO EXTERNO DE SERVICIO">TRASLADO EXTERNO DE SERVICIO | El costo por el servicio es: {{$cnf->PRE_TRAS_EXT_SERV}} Bs.</option>
								<option value="TRASLADO INTERNO DE SERVICIO">TRASLADO INTERNO DE SERVICIO | El costo por el servicio es: {{$cnf->PRE_TRAS_INT_SERV}} Bs.</option>
							</optgroup>
							<optgroup label="OTROS">
								<option value="PUNTOS EXTRA">SOLICITUD DE PUNTOS EXTRA</option>
								<option value="DESCUENTO DIAS">DESCUENTO POR DIAS</option>
							</optgroup>
							
						</select>
					</div>
					<div class="alert bg-blue">
						<ul>
							<li>Recuerde que al registrar el Pago el contrato actual volvera a un estado de PENDIENTE</li>
							<li>Se registrara el costo del servicio requerido al historial de Pagos del Cliente</li>
						</ul>
					</div>
					<div id="div_otros"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					<button type="button" class="btn btn-primary" id="btn_otros" onclick="pagarOtros();"><i class="fa fa-check"></i> Registrar Pago</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL OTROS PAGOS -->
<!-- INICIO MODAL CONFIRMA -->
<div class="modal fade modal-danger" id="modalConfirma">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form  data-parsley-validate>
				@csrf
				<div class="modal-body" style="margin-right: 0px; margin-left: 0px;">
					<h3 class="text-center">¿Esta seguro que desea realizar el pago de los meses seleccionados?</h3>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
					<button type="button" class="btn btn-outline" onclick="registraPago();" id="btn_pago"><i class="fa fa-check"></i> Registrar Pago</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL CONFIRMA -->
<!-- INICIO MODAL REPSUESTA -->
<div class="modal fade" id="modalRespuesta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<div class="panel panel-green bg-green">
					<div class="panel-body">
						<i class="fa fa-check-circle fa-4x" style="color:white;"></i><h2 style="color:white;">PAGO REGISTRADO EXITOSAMENTE</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6"><button class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button></div>
					<div class="col-md-6"><a id="btnImprime" href="" target="_blank" class="btn btn-warning btn-block"><i class="fa fa-print"></i> Imprimir Recibos</a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- FIN MODAL REPSUESTA -->
<!-- INICIO MODAL NUEVO CONTRATO -->
<div class="modal fade" id="modalNuevoContrato" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">REGISTRAR NUEVO CONTRATO</h4>
			</div>
			<form data-parsley-validate id="form_contrato">
				@csrf 
				<input type="hidden" name="id_cli" value="{{$cliente->ID_CLI}}">
				<div class="modal-body">
					<div class="col-md-12 row">
						<div class="form-group col-md-6">
							<label>SUCURSAL:</label>
							<input type="text" name="" class="form-control" value="{{$sucursal->NOM_SUC}}" disabled="">
						</div>
						<div class="form-group col-md-6">
							<label>PLAN:</label>
							<select class="form-control" name="id_plan" required>
								<option selected="" disabled="">-SELECCIONE UNA PLAN-</option>
								@foreach ($sucursal->planes as $plan)
								<option value="{{$plan->ID_PLAN}}">{{$plan->NOM_PLAN}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>TIPO DE PAGO:</label>
							<select class="form-control" name="tipo_pago" required>
								<option selected="" disabled="">-SELECCIONE UN TIPO DE PAGO-</option>
								<option value="POST-PAGO">POST-PAGO</option>
								<option value="PRE-PAGO">PRE-PAGO</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>FECHA DE SOLICITUD DEL CONTRATO:</label>
							<input type="date" class="form-control" name="fec_sol" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
						</div>
						<div class="form-group col-md-6">
							<label>NUMERO DE PUNTOS EXTRA:</label>
							<input type="number" class="form-control" name="pts_xtr" value="0">
							<small class="text-danger"><b>* Solo debe llenar este campo si el cliente solicita puntos EXTRA</b></small>
						</div>
						<div class="form-group col-md-6">
							<label>CONVENIO:</label>
							<select class="form-control" name="convenio" onchange="mi_convenio(this.value);">
								<option value="NO">SIN CONVENIO</option>
								<option value="SI">CONVENIO</option>
							</select>
						</div>
						<div id="div_convenio" class="col-md-12" style="background-color: #C2FAFD; margin: 10px; padding-top: 5px;"></div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
					<button type="submit" class="btn btn-success" id="btn_registra"><i class="fa fa-check"></i> Registrar Contrato</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL NUEVO CONTRATO -->
<!-- INICIO MODAL EDITA CONTRATO -->
<div class="modal fade" id="modalEditaContrato" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">EDITAR CONTRATO</h4>
			</div>
			<form data-parsley-validate id="update">
				@csrf 
				<input type="hidden" name="id_con" id="id_con" value="">
				<div class="modal-body">
					<div class="col-md-12 row">
						<div class="form-group col-md-6">
							<label>SUCURSAL:</label>
							<input type="text" name="" class="form-control" value="{{$sucursal->NOM_SUC}}" disabled="">
						</div>
						<div class="form-group col-md-6">
							<label>PLAN:</label>
							<select class="form-control" name="id_plan" id="id_plan" required>
								<option selected="" disabled="">-SELECCIONE UNA PLAN-</option>
								@foreach ($sucursal->planes as $plan)
								<option value="{{$plan->ID_PLAN}}">{{$plan->NOM_PLAN}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>TIPO DE PAGO:</label>
							<select class="form-control" name="tipo_pago" id="tipo_pago" required>
								<option selected="" disabled="">-SELECCIONE UN TIPO DE PAGO-</option>
								<option value="POST-PAGO">POST-PAGO</option>
								<option value="PRE-PAGO">PRE-PAGO</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>FECHA DE SOLICITUD DEL CONTRATO:</label>
							<input type="date" class="form-control" name="fec_sol" id="fec_sol" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
						</div>
						<div class="form-group col-md-6">
							<label>FECHA DE ACTIVACION DE CONTRATO:</label>
							<input type="date" class="form-control" name="fec_ini" id="fec_ini" value="">
						</div>
						<div class="form-group col-md-6">
							<label>NUMERO DE PUNTOS EXTRA:</label>
							<input type="number" class="form-control" name="pts_xtr" id="pts_xtr" value="">
							<small class="text-danger"><b>* Solo debe llenar este campo si el cliente solicita puntos EXTRA</b></small>
						</div>
						<div class="form-group col-md-6">
							<label>CONVENIO:</label>
							<select class="form-control" name="convenio" id="convenio" onchange="mi_convenio_e(this.value);">
								<option value="NO">SIN CONVENIO</option>
								<option value="SI">CONVENIO</option>
							</select>
						</div>
						<div id="div_convenio_e" class="col-md-12" style="background-color: #C2FAFD; margin: 10px; padding-top: 5px;"></div>
					</div>

				</div>
				<div class="modal-footer" style="padding-top: 100px;">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
					<button type="submit" class="btn btn-success" id="btn_edita"><i class="fa fa-check"></i> Editar Contrato</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL EDITA CONTRATO -->
<!-- INICIO MODAL RESPUESTA -->
<div class="modal fade" id="modalRespuestaContrato" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">CONTRATO</h4>
			</div>
			<div class="modal-body">
				<div id="div_respuesta">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN MODAL RESPUESTA -->
<!-- INICIO MODAL BAJA -->
<div class="modal fade" id="modalConfirmaBaja" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">CONFIRMAR BAJA DE CONTRATO</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id_con_b" id="id_con_b" value="">
				<div class="alert alert-danger text-center"><h3>¿ESTA SEGURO QUE DESEA DAR DE BAJA EL ACTUAL CONTRATO?</h3></div>
				<div class="alert bg-blue">
					<ul>
						<li>Es necesario NO tener deudas pendientes</li>
						<li>Despues de dar de baja el contrato activo, podra crear uno NUEVO</li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
				<button type="button" class="btn btn-danger" id="btn_baja" onclick="darDeBaja();"><i class="fa fa-check"></i> Dar de baja Contrato</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN MODAL BAJA -->
<!-- INICIO MODAL BAJA FORZOSA -->
<div class="modal fade modal-danger" id="modalBajaForzosa" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">CONFIRMAR BAJA FORZOSA</h4>
			</div>
			<div class="modal-body" style="margin-right: 0px; margin-left: 0px;">
				<input type="hidden" name="id_con_bf" id="id_con_bf" value="">
				<div class="alert alert-danger text-center"><h3>¿ESTA SEGURO QUE DESEA DAR DE BAJA FORZOSA?</h3></div>
				<div class="alert bg-warning text-black">
					<ul>
						<li>Esta baja solo se aplica a clientes EN CORTE</li>
						<li>Las deudas pendientes se mantendran</li>
						<li>Una vez dado de baja forzosa solo se esperara a que el cliente pague sus deudas y de de baja este contrato</li>
						<li>Es necesario NO tener deudas pendientes</li>
						<li>No podra crear un nuevo contrato hasta que se de de baja a este contrato</li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
				<button type="button" class="btn btn-outline" id="btn_bajaforzosa" onclick="darBajaForzosa();"><i class="fa fa-check"></i> Dar baja Forzosa</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN MODAL BAJA FORZOSA -->
<!-- INICIO MODAL RESPUESTA -->
<div class="modal fade" id="modalPdf" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">ESCOJA UN CONTRATO</h4>
			</div>
			<div class="modal-body">
				<div class="row text-center">
					<div class="col-md-6">
						<a href="" id="a_tv" target="_blank"><div class="alert alert-info"><i class="fa fa-file-pdf-o fa-3x"></i> <h3>IMPRIMIR CONTRATO TV</h3></div></a>
					</div>
					<div class="col-md-6">
						<a href="" id="a_wifi" target="_blank"><div class="alert alert-success"><i class="fa fa-file-pdf-o fa-3x"></i> <h3>IMPRIMIR CONTRATO WIFI</h3></div></a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN MODAL RESPUESTA -->

<!-- INICIO MODAL ELIMINA PAGO -->
<div class="modal fade" id="modalEliminaPago" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">ELIMINAR PAGO</h4>
			</div>
			<form id="form_elimina_pago">
			<div class="modal-body">
				<input type="hidden" name="id_pd" id="id_pd" value="">
				<div class="alert alert-danger text-center"><h3>¿ESTA SEGURO QUE DESEA ELIMINAR ESTE PAGO?</h3></div>
				<div class="alert bg-blue">
					<ul>
						<li>La eliminación del pago sera permanente</li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
				<button type="button" class="btn btn-danger" id="btn_elimina_pago" onclick="eliminaPago();"><i class="fa fa-check"></i> Eliminar pago</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- FIN MODAL ELIMINA PAGO -->

@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		historial();
		actual();
	})


	
	function actual(){
		$.ajax({
			url:"{{url('cliente/informacion/actual/')}}"+"/"+{{$cliente->ID_CLI}},
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'GET',
			beforeSend: function(){$('#div_actual').html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> Cargando...</h4>')},
			success: function(data){
				$('#div_actual').html(data);
			},
			error: function(data, text, message){
				console.log(data);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}

	function historial(){
		$.ajax({
			url:"{{url('cliente/informacion/historial/')}}"+"/"+{{$cliente->ID_CLI}},
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'GET',
			beforeSend: function(){$('#div_historial').html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> Cargando...</h4>')},
			success: function(data){
				$('#div_historial').html(data);
			},
			error: function(data, text, message){
				console.log(data);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}

	function modalActiva(contrato){
		$('#form_activa #id_con').val(contrato.ID_CON);
		var fecha="{{Carbon\Carbon::now()->format('Y-m-d')}}";
		var mensaje='*Fecha de hoy';
		if (contrato.FEC_INI != null) {
			fecha=contrato.FEC_INI;
			var mensaje='*Fecha en la que se activó el contrato';
		}
		$('#form_activa #fec_ini').val(fecha);
		$('#form_activa #msj_ini').html(mensaje);
		$('#modalActiva').modal('show');
	}

	function activa(id_con){
		$.ajax({
			url:"{{route('contrato.activa')}}",
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'JSON',
			type:'POST',
			data:$('#form_activa').serialize(),
			beforeSend: function(){$('#btn_activa').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
			success: function(data){
				success_message(data);
				$('#btn_activa').html('<i class="fa fa-check"></i> Activar contrato').attr('disabled',false);
				$('#modalActiva').modal('hide');
				historial();
				actual();

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_activa').html('<i class="fa fa-check"></i> Activar contrato').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function limpia(){
		$('#div_datos').empty();
	} 
	function modalPago(id_con){
		$('#form_pago #id_con').val(id_con);
		$('#modalNuevoPago').modal('show');
	}
	function calcular(){
		var nro_mes=$('#nro_mes').val();
		var id_con=$('#form_pago #id_con').val();
		$.ajax({
			url:"{{url('cliente/informacion/calcular/')}}"+"/"+nro_mes+"/"+id_con,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'GET',
			beforeSend: function(){$('#div_datos').html('<h3 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> Calculando...</h3>')},
			success: function(data){
				$('#div_datos').html(data);
			},
			error: function(data, text, message){
				console.log(data);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function cancelar(){
		$('#nro_mes').val(1);
		$('#div_datos').empty();
		$('#modalNuevoPago').modal('hide');
	}
</script>
<script type="text/javascript">

	function registraPago(){
		$.ajax({
			url:"{{route('pago.store')}}",
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'JSON',
			type:'POST',
			data:$('#form_pago').serialize(),
			beforeSend: function(){$('#btn_pago').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#btn_pago').html('<i class="fa fa-check"></i> Registrar Pago').attr('disabled',false);
				cancelar();
				$('#modalConfirma').modal('hide');
				actual();
				$('#btnImprime').attr('href',"{{url('cliente/informacion/pago/')}}"+"/"+data);
				$('#modalRespuesta').modal('show');

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_pago').html('<i class="fa fa-check"></i> Registrar Pago').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function datos_cliente(cliente){
		$('#nom_cli').html(cliente.NOM_CLI+' '+cliente.APE_CLI);
		$('#ci_cli').html(cliente.CI_CLI);
		$('#tel_cli').html(cliente.TEL_CLI);
		$('#cel_cli').html(cliente.CEL_CLI);
		$('#dir_cli').html(cliente.DIR_CLI);
		$('#des_dir').html(cliente.DES_DIR);
		//$('#modalDatos').modal('show');
		console.log(cliente);
		//inicio marker en ubicacion cliente
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng({{$cliente->LAT_CLI}}, {{$cliente->LNG_CLI}}),
			title: 'Marker',
			map: map,
			draggable: false,
			animation: google.maps.Animation.DROP
		});
		map.setZoom(12);
		map.panTo(marker.position);
		//fin marker en ubicacion cliente
	}

	var map;
	var ubicacionDefecto = { lat: -16.495720314116124, lng: -68.133516089556 };
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 10,
			center: ubicacionDefecto,
		});
		
	}

	$(document).ready(function(e) {
		initMap();
	}); 

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADOvOZ1ysdf-hdsro_vxzKuT4fOR8i9pA&callback=initMap"></script>

<script type="text/javascript">
	function modalNuevoContrato(){
		$('#modalNuevoContrato').modal('show');
	}
	$('#form_contrato').on("submit",function(ev){
		ev.preventDefault();
		if ($(this).parsley().isValid()) {
			$.ajax({
				url:"{{url('/contrato')}}",
				headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				dataType:'HTML',
				type:'POST',
				data:$('#form_contrato').serialize(),
				beforeSend: function(){$('#btn_registra').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
				success: function(data){
					//success_message(data);
					$('#div_respuesta').html(data);
					$('#modalRespuestaContrato').modal('show');

					$('#btn_registra').html('<i class="fa fa-check"></i> Registrar Contrato').attr('disabled',false);
					$('#modalNuevoContrato').modal('hide');
					historial();
				},
				error: function(data, text, message){
					console.log(data);
					$('#btn_registra').html('<i class="fa fa-check"></i> Registrar Contrato').attr('disabled',false);
					if (data.status && data.status==500) {
						error_message(JSON.parse(data.responseText));  
					}else{
						error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
					}
					
				}
			});
		}
		return false;
	});	

</script>
<script type="text/javascript">
	function modalConfirmaBaja(id_con){
		$('#id_con_b').val(id_con);
		$('#modalConfirmaBaja').modal('show');
	}

	function darDeBaja(){
		var id_con = $('#id_con_b').val();
		$.ajax({
			url:"{{route('contrato.baja')}}",
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'POST',
			data:{id_con:id_con},
			beforeSend: function(){$('#btn_baja').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#btn_baja').html('<i class="fa fa-check"></i> Dar de baja Contrato').attr('disabled',false);
				$('#modalConfirmaBaja').modal('hide');
				historial();
				$('#div_respuesta').html(data);
				$('#modalRespuestaContrato').modal('show');

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_baja').html('<i class="fa fa-check"></i> Dar de baja Contrato').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}

</script>
<script type="text/javascript">
	function modalEdita(contrato,convenio){
		$('#update #id_con').val(contrato.ID_CON);
		$('#update #id_plan').val(contrato.ID_PLAN);
		$('#update #id_plan').val(contrato.ID_PLAN);
		$('#update #tipo_pago').val(contrato.TIPO_PAGO);
		$('#update #fec_sol').val(contrato.FEC_SOL);
		$('#update #fec_ini').val(contrato.FEC_INI);
		$('#update #pts_xtr').val(contrato.PTS_XTR);
		var id_cvn=0;
		var tipo_cvn='';
		var desc_cvn='';
		if (convenio!=0) {
			id_cvn=convenio.ID_CVN;
			tipo_cvn=convenio.TIPO_CVN;
			desc_cvn=convenio.DESC_CVN;
			$('#update #convenio').val('SI');
			mi_convenio_e('SI',id_cvn,tipo_cvn,desc_cvn);
		}else{
			$('#update #convenio').val('NO');
			mi_convenio_e('NO',id_cvn,tipo_cvn,desc_cvn);
		}
		$('#modalEditaContrato').modal('show');
	}

	$('#update').on("submit",function(ev){
		ev.preventDefault();
		if ($(this).parsley().isValid()) {
			$.ajax({
				url:"{{route('contrato.actualiza')}}",
				headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				dataType:'HTML',
				type:'POST',
				data:$('#update').serialize(),
				beforeSend: function(){$('#btn_edita').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
				success: function(data){
					success_message(JSON.parse(data));
					$('#btn_edita').html('<i class="fa fa-check"></i> Editar Contrato').attr('disabled',false);
					$('#modalEditaContrato').modal('hide');
					historial();
				},
				error: function(data, text, message){
					console.log(data);
					$('#btn_edita').html('<i class="fa fa-check"></i> Editar Contrato').attr('disabled',false);
					if (data.status && data.status==500) {
						error_message(JSON.parse(data.responseText));  
					}else{
						error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
					}
					
				}
			});
		}
		return false;
	});
</script>
<script type="text/javascript">
	function mi_convenio(convenio){
		console.log(convenio);
		if (convenio == 'SI') {
			$('#div_convenio').html('<div class="col-md-12 text-center"><h4>CONVENIO<h4></div><div class="form-group col-md-6">'
				+'<label>TIPO DE CONVENIO:</label>'
				+'<select class="form-control" name="tipo_cvn">'
				+'<option value="DESCUENTO">DESCUENTO</option>'
				+'<option value="GRATIS">GRATIS</option>'
				+'</select>'
				+'</div>'
				+'<div class="form-group col-md-6">'
				+'<label>DESCUENTO:</label>'
				+'<div class="input-group">'
				+'<input type="number" name="desc_cvn" class="form-control" step="any" placeholder="Ingrese el porcentaje de descuento">'
				+'<span class="input-group-addon">%</span>'
				+'</div>'
				+'</div>');
		}else{
			$('#div_convenio').empty();
		}
	}
</script>

<script type="text/javascript">
	function mi_convenio_e(convenio, id_cvn, tipo_cvn, desc_cvn){
		console.log(convenio);
		if (convenio == 'SI') {
			var compilado='<div class="col-md-12 text-center"><h4>CONVENIO<h4></div><div class="form-group col-md-6">';
				compilado+='<input name="id_cvn" type="hidden" value="'+id_cvn+'">';
				compilado+='<label>TIPO DE CONVENIO:</label>';
				compilado+='<select class="form-control" name="tipo_cvn">';
				if (tipo_cvn=='DESCUENTO') {
				compilado+='<option selected="" value="DESCUENTO">DESCUENTO</option>';
				}else{
				compilado+='<option value="DESCUENTO">DESCUENTO</option>';
				}
				if (tipo_cvn=='GRATIS') {
				compilado+='<option selected="" value="GRATIS">GRATIS</option>';
				}else{
				compilado+='<option value="GRATIS">GRATIS</option>';
				}
				compilado+='</select>';
				compilado+='</div>';
				compilado+='<div class="form-group col-md-6">';
				compilado+='<label>DESCUENTO:</label>';
				compilado+='<div class="input-group">';
				compilado+='<input type="number" name="desc_cvn" class="form-control" step="any" value="'+desc_cvn+'" placeholder="Ingrese el porcentaje de descuento">';
				compilado+='<span class="input-group-addon">%</span>';
				compilado+='</div>';
				compilado+='</div>';
			$('#div_convenio_e').html(compilado);
		}else{
			$('#div_convenio_e').empty();
		}
	}
</script>

<script type="text/javascript">
	function modalOtros(id_con){
		$('#form_otros #id_con').val(id_con);
		$('#modalOtros').modal('show');
	}

	function pagarOtros(){
		$contador=0;
		$('.detalle').each(function(){
			if ($(this).val()=='') {
				error_message('Uno de los campos en material esta vacío');
				contador++;
			}
		});
		$('.monto').each(function(){
			if ($(this).val()=='') {
				error_message('Uno de los campos de monto esta vacío');
				contador++;
			}
		});

		if ($contador!=0) {return false;}

		$.ajax({
			url:"{{route('pago.otros')}}",
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'JSON',
			type:'POST',
			data:$('#form_otros').serialize(),
			beforeSend: function(){$('#btn_otros').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#btn_otros').html('<i class="fa fa-check"></i> Registrar Pago').attr('disabled',false);
				$('#modalOtros').modal('hide');
				actual();
				$('#btnImprime').attr('href',"{{url('cliente/informacion/pago/')}}"+"/"+data);
				$('#modalRespuesta').modal('show');

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_otros').html('<i class="fa fa-check"></i> Registrar Pago').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function modalPdf(id_con){
		var url_tv="{{url('cliente/contrato/pdf/tv/')}}"+"/"+id_con;
		var url_wifi="{{url('cliente/contrato/pdf/wifi/')}}"+"/"+id_con;

		$('#a_tv').attr('href', url_tv);
		$('#a_wifi').attr('href', url_wifi);
		$('#modalPdf').modal('show');
	}
</script>
<script type="text/javascript">
	function recoge(id_con){
		console.log(id_con);
		$.ajax({
			url:"{{route('contrato.recoge')}}",
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'JSON',
			type:'POST',
			data:{"id_con":id_con},
			success: function(data){
				console.log(data);
				if (data=='SI') {
					success_message('RECOGIDO');
				}else{
					success_message('NO RECOGIDO');
					
				}
				actual();

			},
			error: function(data, text, message){
				console.log(data);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function modalEliminaPago(id_pd){
		$('#id_pd').val(id_pd);
		$('#modalEliminaPago').modal('show');
	}

	function eliminaPago(){
		$.ajax({
			url:"{{route('pagoDetalle.elimina')}}",
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'JSON',
			type:'POST',
			data:$('#form_elimina_pago').serialize(),
			beforeSend: function(){$('#btn_elimina_pago').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
			success: function(data){
				console.log(data);
				success_message(data);
				$('#btn_elimina_pago').html('<i class="fa fa-check"></i> Eliminar pago').attr('disabled',false);
				$('#modalEliminaPago').modal('hide');
				actual();

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_elimina_pago').html('<i class="fa fa-check"></i> Eliminar pago').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function modalBajaForzosa(id_con){
		$('#id_con_bf').val(id_con);
		$('#modalBajaForzosa').modal('show');
	}

	function darBajaForzosa(){
		var id_con = $('#id_con_bf').val();
		$.ajax({
			url:"{{route('contrato.bajaForzosa')}}",
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'POST',
			data:{id_con:id_con},
			beforeSend: function(){$('#btn_bajaforzosa').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#btn_bajaforzosa').html('<i class="fa fa-check"></i> Dar baja Forzosa').attr('disabled',false);
				$('#modalBajaForzosa').modal('hide');
				historial();
				$('#div_respuesta').html(data);
				$('#modalRespuestaContrato').modal('show');

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_bajaforzosa').html('<i class="fa fa-check"></i> Dar baja Forzosa').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function select_otros(valor){
		if(valor=='VENTA MATERIALES'){
		$('#div_otros').html('<div class="col-md-12" style="background-color: #F3FFA2; margin: 10px; padding-top: 5px;">'
			+'<div class="col-md-12 text-center"><h4>MATERIALES</h4></div>'
			+'<button class="btn btn-success btn-sm" type="button" id="btn_agrega_material" onclick="agregaMaterial()"><i class="fa fa-plus"></i> AGREGAR MATERIAL</button>'
			+'<table class="table table-bordered table-sm">'
			+'<thead>'
			+'<tr class="bg bg-black">'
			+'<th>MATERIAL</th>'
			+'<th>CANTIDAD</th>'
			+'<th>MONTO</th>'
			+'<th>ACCIONES</th>'
			+'</tr>'
			+'</thead>'
			+'<tbody id="tbody_materiales">'
			+'</tbody>'
			+'</table>'
			+'</div>');
		}else if(valor == 'DIAS CANCELA'){
			calcula_dias_cancela();
		}else if(valor == 'DESCUENTO DIAS'){
			descuenta_dias();
		}else if(valor == 'PUNTOS EXTRA'){
			puntos_extra();
		}
		else{
			$('#div_otros').empty();
		}
	}
</script>
<script type="text/javascript">
	function agregaMaterial(){
		$('#tbody_materiales').append('<tr><td><input type="text" class="form-control may detalle" name="det_po[]" required/></td><td><input type="text" class="form-control num" name="cant_po[]" required></td><td><input type="text" class="form-control num monto" name="monto_po[]" required></td><td><button type="button" class="btn btn-danger btn-sm borrar"><i class="fa fa-minus"></i></button><td></tr>');
		$('#tbody_materiales').on('keyup','.may',function(){
			this.value = this.value.toUpperCase();
		});
		$('#tbody_materiales').on('keypress','.num',function(){
			var regex = new RegExp("^[0-9]+$");
			  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			  if (!regex.test(key)) {
			    event.preventDefault();
			    return false;
			  }
		});
	}
	$(document).on('click', '.borrar', function (event) {
	    event.preventDefault();
	    $(this).closest('tr').remove();
	});
</script>
<script type="text/javascript">
	function calcula_dias_cancela(){
		var id_con = $('#form_otros #id_con').val();
		$.ajax({
			url:"{{url('cliente/informacion/calcula_dias_cancela/')}}"+"/"+id_con,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'GET',
			beforeSend: function(){$('#div_otros').html('<h4><i class="fa fa-spinner fa-pulse"></i> Calculando...</h4>').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#div_otros').html(data);

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_bajaforzosa').html('<i class="fa fa-check"></i> Dar baja Forzosa').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function descuenta_dias(){
		var id_con = $('#form_otros #id_con').val();
		$.ajax({
			url:"{{url('cliente/informacion/calcula_dias_descuenta/')}}"+"/"+id_con,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'GET',
			beforeSend: function(){$('#div_otros').html('<h4><i class="fa fa-spinner fa-pulse"></i> Calculando...</h4>').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#div_otros').html(data);

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_bajaforzosa').html('<i class="fa fa-check"></i> Dar baja Forzosa').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function puntos_extra(){
		var id_con = $('#form_otros #id_con').val();
		$.ajax({
			url:"{{url('cliente/informacion/calcula_puntos_extra/')}}"+"/"+id_con,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'GET',
			beforeSend: function(){$('#div_otros').html('<h4><i class="fa fa-spinner fa-pulse"></i> Calculando...</h4>').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#div_otros').html(data);

			},
			error: function(data, text, message){
				console.log(data);
				$('#btn_bajaforzosa').html('<i class="fa fa-check"></i> Dar baja Forzosa').attr('disabled',false);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function ver_pagos(id_con){
		console.log(id_con)
		$('#modalRespuestaContrato').modal('show');
		$.ajax({
			url:"{{url('cliente/informacion/pagos/')}}"+"/"+id_con,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'HTML',
			type:'GET',
			beforeSend: function(){$('#div_respuesta').html('<h4><i class="fa fa-spinner fa-pulse"></i> Cargando...</h4>').attr('disabled',true)},
			success: function(data){
				console.log(data);
				$('#div_respuesta').html(data);

			},
			error: function(data, text, message){
				console.log(data);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
	function factura(id_pd){
		console.log(id_pd);
		$.ajax({
			url:"{{url('cliente/informacion/factura/')}}"+"/"+id_pd,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			dataType:'JSON',
			type:'GET',
			beforeSend: function(){$('#btn_factura_'+id_pd).html('<i class="fa fa-spinner fa-pulse"></i>').attr('disabled',true)},
			success: function(data){
				console.log(data);
				actual()
			},
			error: function(data, text, message){
				console.log(data);
				if (data.status && data.status==500) {
					error_message(JSON.parse(data.responseText));  
				}else{
					error_message('Algo salio mal, Refresque el navegador e intentelo nuevamente');
				}
				
			}
		});
	}
</script>
<script type="text/javascript">
$('#modalOtros').on('hidden.bs.modal', function () {
  $('#div_otros').html('');
});
</script>	
@endsection
