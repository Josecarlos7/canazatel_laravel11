<!DOCTYPE html>
<html>
<head>
	<title>CONTRATO REGISTRO</title>
	<style type="text/css">
		@page{
			margin: 0cm;
			margin-top: 2cm;
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
		<!--_________________________________  INICIO PRIMERA PAGINA ______________________________________________-->
		<table style="width: 100%" cellspacing="" cellpadding="" border="0">
			<tr>
				<td width="50%" style="padding-right: 5px;">
					<div style="text-align: center;">
						<label class="secundario">CONTRATO DE ADHESIÓN PARA LA PROVISIÓN DE SERVICIOS DE TELECOMUNICACIONES</label>
						<br>
						<br>
						<label class="principal">SERVICIO DE DISTRIBUCIÓN DE SEÑALES</label>
						<br>
						<label class="principal">{{$contrato->NOM_SUC}}</label>
						<br>
						<br>
						<label class="secundario">Contrato Nª {{$contrato->COD_CON}}</label>
						<br>
					</div>
					<div style="text-align: justify;">
						Conste por el tenor del presente Documento Privado, que los suscribientes acuerdan celebrar un Contrato de <b>PROVISIÓN DEL SERVICIO DE DISTRIBUCIÓN DE SEÑALES</b> (Televisión por Cable), que con el reconocimiento de firmas y rubricas surtirá los mismos efectos de documento público, sujeto a las siguientes clausulas:
					</div>
					<br>
					<div style="text-align: justify;">
						<b>PRIMERO. (PARTES CONTRATANTES).-</b> intervienen en la suscripción del presente Contrato:<br>
						<br>
						<b>1.1. CANAZATEL TELECOMUNICACIONES S.R.L.</b> 
						<br>
						con domicilio en la  localidad: {{$contrato->NOM_LOC}} {{$contrato->DIR_CLI}}, legalmente representado por el señor Nat Rolly Canaza Chino en virtud al Poder Especial Nº 0203/2008 de fecha 22 de julio del 2008 otorgado mediante Notaria de Fe Publica Nº 40 a cargo del Dr. Omar Vicente Terrazas Herrera, que para efectos de este Contrato se denominará CANAZATEL.
						<br>
						<br>
						<b>(LLENAR EN CASO DE PERSONA NATURAL)</b>
						<br>
						<br>
						<b>La/el</b>
						<b>Empresa/Proveedor:</b>
						<br>
						.............................................................................................................................
						<br>
						legalmente representado(a) por el/la Señor/a/ita
						<br>
						.............................................................................................................................
						<br>
						en virtud al Poder Especial Nº….../.……… de fecha ……… de ........................... del 	
						<br>		
						.............................................................................................................................
						<br>
						otorgado mediante Notarla de Fe Publica Nº
						<br> 
						.............................................................................................................................
						<br>
						a cargo del Dr.(a) 
						<br> 
						.............................................................................................................................
						<br> 
						con C.I. .................................. con Matricula Nº 
						<br> 
						.............................................................................................................................
						<br> 
						con NIT Nº.............................. con Domicilio legal 
						<br> 
						.............................................................................................................................
						<br> 
						que en lo sucesivo se denominará USUARIO(A), cuyos datos se detallan en el Anexo de Solicitud de Provisión de Servicios mismo que forma parte integrante e inseparable del presente Contrato para todos los efectos legales.
						<br> 
						<br> 
						<b>SEGUNDO. (ANTECEDENTES).-</b> CANAZATEL TELECOMUNICACIONES S.R.L. obtuvo de la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes – ATT, su autorización para operar una Red Pública, con el propósito de prestar el SERVICIO DE DISTRIBUCIÓN DE SEÑALES (Televisión por Cable) como un servicio al público, que en adelante se denominará SERVICIO, que es un sistema de servicios de televisión (señales audiovisuales) que se proporciona únicamente por suscripción a través de estaciones cuyas emisiones se distribuyen para ser recibidas en los televisores de usuarias y usuarios determinados, mediante redes de fibra óptica y/o cable coaxial distribuidos a lo largo de la ciudad o localidad, compartiendo el tendido con los cables de electricidad y/o telefonía. Este servicio incluye la instalación en el domicilio señalado, así como la posibilidad de incluir puntos adicionales.
						<br> 
						<br> 
						<b>TERCERO. (OBJETO DEL CONTRATO).-</b> En virtud a las condiciones establecidas en el presente Contrato, y los Términos y Condiciones del Servicio, se establece como objeto del presente contrato la provisión por parte CANAZATEL y la utilización por parte del USUARIO(A) del SERVICIO, a cambio de una tarifa a ser pagada por el USUARIO(A).
						
					</div>
				</td>
				<td width="50%" style="padding-left: 5px;">
					<div style="text-align: justify;">
						<b>CUARTO. (TÉRMINOS Y CONDICIONES).-</b> El SERVICIO contratado por el USUARIO(A) solo podrá ser utilizado en sujeción estricta a las condiciones establecidas en los TÉRMINOS Y CONDICIONES DEL SERVICIO que forma parte integrante, indivisible, e inseparable del presente Contrato para todos los efectos legales.
						<br>
						<b>QUINTO. (PLAZO DEL CONTRATO, VIGENCIA Y PRORROGA).-</b> El presente CONTRATO tendrá un plazo de un (1) año, mismo que entrará en vigencia a partir de la de suscripción del mismo y admite renovaciones tácitas por periodos similares o indeterminados de tiempo, siempre y cuando no existiere el aviso por cualquiera de las partes, comunicando a la otra por escrito la decisión de rescindir el contrato, dicho aviso deberá ser realizado con anticipación de treinta (30) días calendarlo a la fecha de finalización del plazo, manteniendo las obligaciones económicas que estuvieren pendientes de pago por el servicio efectivamente recibido.
						<br>
						<b>SEXTO. (PLAZOS PARA INSTALACIÓN, HABILITACIÓN, DESHABILITACIÓN Y REHABILITACIÓN DEL SERVICIO).-</b> CANAZATEL, instalará y habilitará el SERVICIO al USUARIO(A) en un plazo no mayor a los dos (2) días hábiles siguientes a la firma del Contrato, previa verificación de cumplimiento de los requerimientos técnicos, comerciales y administrativos establecidos en el Punto 3. HABILITACIÓN Y PLAZO PARA LA PROVISIÓN DEL SERVICIO de los TÉRMINOS Y CONDICIONES DEL SERVICIO, y de acuerdo a la disponibilidad técnica de CANAZATEL, siendo responsabilidad del USUARIO(A) contar con los medios necesarios y adecuados para acceder al servicio.
						<br>
						CANAZATEL procederá a la deshabilitación o corte del SERVICIO por el incumplimiento de pago, por fraude o por suspensión temporal de acuerdo a los plazos y condiciones señaladas en el Punto 8. CORTE y Punto 15. SUSPENSIÓN TEMPORAL DEL SERVICIO de los TÉRMINOS Y CONDICIONES DEL SERVICIO.
						<br>
						La rehabilitación o reconexión del SERVICIO será posible previo pago de lo adeudado, de acuerdo al plazo y condiciones señalados en el Punto 9. REHABILITACIÓN DEL SERVICIO o Punto 15. SUSPENSIÓN TEMPORAL DEL SERVICIO (si corresponde) de los TÉRMINOS Y CONDICIONES DEL SERVICIO.
						<br>
						<b>SÉPTIMO. (TITULARIDAD).-</b> La titularidad del uso del SERVICIO es intransferible, constituyéndose el USUARIO(A) en el único y exclusivo responsable por el uso del servicio y de todos los actos de terceros relacionados al uso del mismo.
						<br>
						<b>OCTAVO. (ESTRUCTURA TARIFARIA).-</b> La Tarifa es el precio que se cancela por la prestación del SERVICIO; el USUARIO(A) pagará a favor de CANAZATEL por el SERVICIO al que se adhiere más los recargos emergentes de este, de acuerdo al Tarifario vigente del SERVICIO, fijado de acuerdo lo establecido en el Régimen Tarifario de la Ley 164 - Ley  General  de  Telecomunicaciones, Tecnologías  de  Información  y  Comunicación. Los conceptos de las tarifas se encuentran descritos en el Punto 4. TARIFAS de los TÉRMINOS Y CONDICIONES DEL SERVICIO. 
						<br>
						Las tarifas podrán ser modificadas temporalmente por CANAZATEL mediante promociones y beneficios en favor del USUARIO(A), por el lapso de vigencia de las mismas.
						<br>
						Cualquier cambio o ajuste relacionado con las tarifas para el SERVICIO, será publicado con una anterioridad de treinta (30) días calendario a la fecha efectiva de aplicación de las nuevas tarifas. 
						<br>
						El USUARIO(A) a partir de la fecha de suscripción del CONTRATO deberá pagar una tarifa en moneda nacional establecida de la siguiente manera: 
						<br>
						<br>
						<table style="width: 100%" cellspacing="" cellpadding="" border="0">
							<tr>
								<td>Plan de Pago:</td>
								<td><div><input type="checkbox" class="medio ch"><label class="medio"> Pre-Pago</label></div></td>
								<td><div><input type="checkbox" class="medio ch"><label class="medio"> Post-Pago</label></div></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Periodo de Pago:</td>
								<td><div><input type="checkbox" class="medio ch"><label class="medio"> Mensual</label></div></td>
								<td><div><input type="checkbox" class="medio ch"><label class="medio"> Trimestral</label></div></td>
								<td><div><input type="checkbox" class="medio ch"><label class="medio"> Semestral</label></div></td>
								<td><div><input type="checkbox" class="medio ch"><label class="medio"> Anual</label></div></td>
							</tr>
						</table>
						<br>
						<table style="width: 100%" cellspacing="" cellpadding="" border="0">
							<tr>
								<td>Paquete:</td>
								<td>Cantidad de canales:</td>
							</tr>
							<tr>
								<td>Tarifa mensual:</td>
								<td>Cantidad puntos adicionales:</td>
							</tr>
							<tr>
								<td>Costo de instalacion:</td>
								<td>Codto por punto adicional:</td>
							</tr>
							<tr>
								<td>Costo de rehabilitacion:</td>
								<td>Otros:</td>
							</tr>
						</table>
						<br>
						<br>
						<b>NOVENO. (FACTURACIÓN, COBRANZA, CORTE).- </b>
						<br>
						CANAZATEL, pondrá a disposición del USUARIO(A) la factura correspondiente por el SERVICIO contratado de acuerdo a la normativa tributaria aplicable y consignando los datos del USUARIO(A), en periodos de treinta (30) días, 
					</div>
				</td>
			</tr>
		</table>
		<!--_________________________________  FIN PRIMERA PAGINA ______________________________________________-->
		<div style="page-break-after:always;"></div>
		<!--_________________________________  INICIO SEGUNDA PAGINA ______________________________________________-->
		<table style="width: 100%" cellspacing="" cellpadding="" border="0">
			<tr>
				<td width="50%" style="padding-right: 5px;">
					<div style="text-align: justify;">
						computables a partir del momento en que se habilite el servicio, salvo cuando no exista consumo por el servicio durante uno o más ciclos de facturación.
						<br>
						<b>Plan Post-Pago:</b> El periodo de facturación será bajo la modalidad de mes vencido
						<br>
						<br>
						<b>Plan Pre-Pago:</b> El periodo de facturación será bajo la modalidad mes adelantado.
						<br>
						<br>
						La cobranza se lo realizará en cajas ubicadas en las instalaciones de CANAZATEL en la siguiente dirección:
						<br>
						<b>CANAZATEL TELECOMUNICACIONES S.R.L.</b>
						<br>
						<b>Dirección:</b> ……………………………………………………….
						<br>
						<b>Teléfono:</b> ……………………
						<br>
						<b>Horarios de atención:</b> De 08:30 a 12:30 y de 14:30 a 18:30 horas los días hábiles, y los días sábados de 08:00 a 13:00 horas
						<br>
						y/o en lugares de cobranza autorizados o por cualquier otro medio legalmente válido que se disponga.
						<br>
						El plazo para el pago de la factura será de treinta (30) días calendario para el Plan Post-Pago y siete (7) días calendario para el Plan Pre-Pago.
						<br>
						Si el USUARIO(A), pasados los treinta (30) días de la fecha límite de pago, no paga su factura, esta se constituirá en mora CANAZATEL podrá proceder al corte parcial o total del servicio previa comunicación al USUARIO(A) mínimamente con cuarenta y ocho (48) horas de anticipación. En el caso del Plan Pre-Pago, a la conclusión del periodo pre-pagado se continuará brindando el servicio con facturación por mensualidad vencida (Plan Post-Pago). El procedimiento de corte del SERVICIO se encuentra descrito en el Punto 8. CORTE de los TÉRMINOS Y CONDICIONES DEL SERVICIO.
						<br>
						<br>
						<b>DÉCIMO. (CALIDAD DEL SERVICIO).-</b> CANAZATEL brindará al USUARIO(A) el SERVICIO DE DISTRIBUCIÓN DE SEÑALES (Televisión por Cable) con calidad y nitidez en imagen y audio cuyos Parámetros de Calidad se regirán de acuerdo a los estándares técnicos de calidad para el SERVICIO, señalados en el Punto 10. PARÁMETROS DE CALIDAD de los TÉRMINOS Y CONDICIONES DEL SERVICIO, misma que podrá ser susceptible de modificación y/o actualización por la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes - ATT.
						<br>
						<br>
						<b>UNDÉCIMO. DERECHOS Y OBLIGACIONES DEL USUARIO(A). </b>
						<br>
						<b>Derechos:</b>
						<br>
						<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
							<tr>
								<td>a)</td>
								<td>
									Acceder en condiciones de igualdad, equidad, asequibilidad, calidad, de forma ininterrumpida al SERVICIO.
								</td>
							</tr>
							<tr>
								<td>b)</td>
								<td>
									Elegir y cambiar libremente de operador o proveedor de los servicios y de los planes de acceso a los mismos, salvo las condiciones pactadas libremente en el contrato.
								</td>
							</tr>
							<tr>
								<td>c)</td>
								<td>
									Acceder a información clara, precisa, cierta, completa, oportuna y gratuita acerca del SERVICIO.
								</td>
							</tr>
							<tr>
								<td>d)</td>
								<td>
									Acceder gratuitamente al SERVICIO en casos de emergencia, que determine la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes.
								</td>
							</tr>
							<tr>
								<td>e)</td>
								<td>
									Recibir de forma oportuna, comprensible y veraz la factura mensual desglosada del SERVICIO y todos los cargos, en la forma y por el medio en que se garantice su privacidad.
								</td>
							</tr>
							<tr>
								<td>f)</td>
								<td>
									Privacidad e inviolabilidad de sus comunicaciones, salvo aquellos casos expresamente señalados por la Constitución Política del Estado y la Ley.
								</td>
							</tr>
							<tr>
								<td>g)</td>
								<td>
									Conocer los indicadores de calidad de prestación del SERVICIO.
								</td>
							</tr>
							<tr>
								<td>h)</td>
								<td>
									Suscribir contrato del SERVICIO de acuerdo al modelo de contrato, términos y condiciones, previamente aprobados por la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes.
								</td>
							</tr>
							<tr>
								<td>i)</td>
								<td>
									Ser informado oportunamente, cuando se produzca un cambio de los precios, las tarifas o los planes contratados previamente.
								</td>
							</tr>
							<tr>
								<td>j)</td>
								<td>
									Recibir el reintegro o devolución de montos que resulten a su favor por errores de facturación, deficiencias o corte del servicio.
								</td>
							</tr>
							<tr>
								<td>k)</td>
								<td>
									Ser informado sobre los plazos de vigencia de las ofertas y promociones del SERVICIO.
								</td>
							</tr>
							<tr>
								<td>l)</td>
								<td>
									Obtener respuesta efectiva a las solicitudes realizadas.
								</td>
							</tr>
							<tr>
								<td>m)</td>
								<td>
									Ser informado oportunamente de la desconexión o corte programado del SERVICIO.
								</td>
							</tr>
							<tr>
								<td>n)</td>
								<td>
									Reclamar por inconvenientes en el SERVICIO de manera escrita o verbal conforme a la normativa vigente.
								</td>
							</tr>
							<tr>
								<td>o)</td>
								<td>
									Recibir protección sobre los datos personales contra la publicidad no autorizada, en el marco de la normativa aplicable.
								</td>
							</tr>
							<tr>
								<td>p)</td>
								<td>
									Disponer, como USUARIO(A) en situación de discapacidad y persona de la tercera edad a facilidades de acceso al SERVICIO, determinados en reglamento.
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td width="50%" style="padding-left: 5px;">
					<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
						<tr>
							<td>q)</td>
							<td>
								Protección de la niñez, adolescencia y juventud en la prestación del SERVICIO.
							</td>
						</tr>
						<tr>
							<td>r)</td>
							<td>
								Recibir el SERVICIO sin causar daño a la salud y al medio ambiente, conforme a normas establecidas.
							</td>
						</tr>
						<tr>
							<td>s)</td>
							<td>
								Continuidad del servicio cuando la ATT tramite reclamaciones, respecto al SERVICIO; y previo análisis ordene a mantener el servicio o que, en el plazo que le indique, proceda a su reconexión, según corresponda, mientras resuelva el reclamo presentado.
							</td>
						</tr>
					</table>
					<b>Obligaciones: </b>
					<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
						<tr>
							<td>a)</td>
							<td>
								Pagar sus facturas por el SERVICIO recibido, de conformidad con los precios o tarifas establecidas
							</td>
						</tr>
						<tr>
							<td>b)</td>
							<td>
								Responder por la utilización del servicio por parte de todas las personas que tienen acceso al mismo, en sus instalaciones o que hacen uso del servicio bajo su supervisión o control.
							</td>
						</tr>
						<tr>
							<td>c)</td>
							<td>
								No causar daño a las instalaciones, redes, equipos y dispositivos de CANAZATEL.
							</td>
						</tr>
						<tr>
							<td>d)</td>
							<td>
								Cumplir con las instrucciones y planes que emita la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes en casos de emergencia y seguridad del Estado.
							</td>
						</tr>
						<tr>
							<td>e)</td>
							<td>
								No causar interferencias perjudiciales a operaciones debidamente autorizadas.
							</td>
						</tr>
						<tr>
							<td>f)</td>
							<td>
								Utilizar el SERVICIO sólo para los fines contratados, no pudiendo darle ningún uso distinto, y asumir plena responsabilidad por los actos relacionados al uso que se realice al SERVICIO contratado.
							</td>
						</tr>
						<tr>
							<td>g)</td>
							<td>
								A informarse completamente sobre el Contrato y los Términos y Condiciones de la prestación del SERVICIO.
							</td>
						</tr>
					</table>
					<b>DUODÉCIMO. PROHIBICIONES DEL USUARIO(A). </b>
					<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
						<tr>
							<td>a)</td>
							<td>
								El USUARIO(A) no podrá comercializar o revender bajo ninguna modalidad el SERVICIO contratado.
							</td>
						</tr>
						<tr>
							<td>b)</td>
							<td>
								El USUARIO(A) no podrá efectuar por cuenta propia traslado o modificaciones en la instalación.
							</td>
						</tr>
						<tr>
							<td>c)</td>
							<td>
								El USUARIO(A) no podrá transferir a ningún título, a terceras personas individuales o jurídicas, los derechos y obligaciones estipuladas en el Contrato y los Términos y Condiciones, sin previo consentimiento escrito de CANAZATEL, caso contrario será responsable de todos los daños y perjuicios ocasionados a CANAZATEL, además de la inmediata suspensión del SERVICIO.
							</td>
						</tr>
						<tr>
							<td>d)</td>
							<td>
								El USUARIO(A) no podrá conectar a la red de CANAZATEL equipos terminales que pudieran impedir o interrumpir el servicio, realizar el desvío de comunicaciones de manera ilegal, fraudulenta o causar daño a la red.
							</td>
						</tr>
						<tr>
							<td>e)</td>
							<td>
								El USUARIO(A) no podrá alterar los equipos terminales, aunque sean de su propiedad, que puedan causar daños o interferencias que degraden la calidad de servicio o con el objeto de producir la evasión o alteración del pago de las tarifas o cargos que correspondan.
							</td>
						</tr>
					</table>
					<b>DECIMOTERCERO. DERECHOS Y OBLIGACIONES DE CANAZATEL. </b>
					<b>Derechos:</b>
					<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
						<tr>
							<td>a)</td>
							<td>
								Recibir oportunamente el pago por el servicio provisto, de conformidad con los precios o tarifas establecidas.
							</td>
						</tr>
						<tr>
							<td>b)</td>
							<td>
								Cortar el servicio provisto por falta de pago por parte del USUARIO(A), previa comunicación, conforme a lo establecido por reglamento.
							</td>
						</tr>
						<tr>
							<td>c)</td>
							<td>
								Recibir protección frente a interferencias perjudiciales a operaciones debidamente autorizadas.
							</td>
						</tr>
						<tr>
							<td>d)</td>
							<td>
								Someterse a la jurisdicción y competencia de la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes - ATT.
							</td>
						</tr>
						<tr>
							<td>e)</td>
							<td>
								Proveer en condiciones de igualdad, equidad, asequibilidad, calidad, de forma ininterrumpida el SERVICIO.
							</td>
						</tr>
						<tr>
							<td>f)</td>
							<td>
								Proporcionar información clara, precisa, cierta, completa, oportuna y gratuita acerca del SERVICIO al USUARIO(A).
							</td>
						</tr>
						<tr>
							<td>g)</td>
							<td>
								Proporcionar información clara, precisa, cierta, completa y oportuna a la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes.
							</td>
						</tr>
						<tr>
							<td>h)</td>
							<td>
								Proveer gratuitamente el SERVICIO en casos de emergencia, que determine la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes.
							</td>
						</tr>
						<tr>
							<td>i)</td>
							<td>
								Entregar en servicio de modalidad Post-Pago de forma oportuna, comprensible y veraz, la factura mensual desglosada del SERVICIO y todos los cargos, en la forma y por el medio en que se garantice la privacidad del USUARIO(A) y facilitar los medios de pago por el SERVICIO prestado. En servicios de modalidad Pre-Pago o al contado, entregar la factura según corresponda.
							</td>
						</tr>
						<tr>
							<td>j)</td>
							<td>
								Suscribir contratos de acuerdo a los modelos de contratos, términos y condiciones, previamente aprobados por la Autoridad de Regulación y Fiscalización de Telecomunicaciones y Transportes.
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>		
		<!--_________________________________  FIN SEGUNDA PAGINA ______________________________________________-->
		<div style="page-break-after:always;"></div>
		<!--_________________________________  INICIO TERCER PAGINA ______________________________________________-->
		<table style="width: 100%" cellspacing="" cellpadding="" border="0">
			<tr>
				<td width="50%" style="padding-right: 5px;">
					<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
						<tr>
							<td>k)</td>
							<td>
								Efectuar el reintegro o devolución de montos que resulten a favor del USUARIO(A) por errores de facturación, deficiencias o corte del servicio, con los respectivos intereses legales.
							</td>
						</tr>
						<tr>
							<td>l)</td>
							<td>
								Informar oportunamente sobre los plazos de vigencia de las ofertas y promociones de los servicios.
							</td>
						</tr>
						<tr>
							<td>m)</td>
							<td>
								Atender las solicitudes y las reclamaciones realizadas por el USUARIO(A)
							</td>
						</tr>
						<tr>
							<td>n)</td>
							<td>
								Informar oportunamente la desconexión o cortes programados del SERVICIO.
							</td>
						</tr>
						<tr>
							<td>o)</td>
							<td>
								Brindar protección sobre los datos personales evitando la divulgación no autorizada por el USUARIO(A), en el marco de la normativa aplicable
							</td>
						</tr>
						<tr>
							<td>p)</td>
							<td>
								Facilitar al USUARIO(A) en situación de discapacidad y personas de la tercera edad, el acceso al SERVICIO, determinados en reglamento.
							</td>
						</tr>
						<tr>
							<td>q)</td>
							<td>
								Proveer el SERVICIO sin causar daños a la salud y al medio ambiente.
							</td>
						</tr>
						<tr>
							<td>r)</td>
							<td>
								Cumplir las instrucciones y planes que se emitan en casos de emergencia y seguridad del Estado.
							</td>
						</tr>
						<tr>
							<td>s)</td>
							<td>
								Actualizar periódicamente su plataforma tecnológica y los procesos de atención al USUARIO(A).
							</td>
						</tr>
					</table>
					<b>Obligaciones:</b>
					<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
						<tr>
							<td>a)</td>
							<td>
								Ofrecer al USUARIO(A) un número telefónico para acceder a servicios de reporte de averías, de consulta de facturación y de interposición de reclamaciones por violación de derechos del USUARIO(A).
							</td>
						</tr>
						<tr>
							<td>b)</td>
							<td>
								Informar al USUARIO(A) el área de cobertura autorizadas para el SERVICIO en formato y contenido definidos por la ATT.
							</td>
						</tr>
						<tr>
							<td>c)</td>
							<td>
								Disponer de medios de información que informen al USUARIO(A) sobre el consumo realizado durante un período de facturación.
							</td>
						</tr>
						<tr>
							<td>d)</td>
							<td>
								Respetar el derecho del USUARIO(A) de desconexión del SERVICIO. Además de respetar la voluntad del mismo a la resolución del contrato. En caso de desconexión o resolución del contrato, permanecerán vigentes aquellas obligaciones del USUARIO(A) pendientes de cumplimiento.
							</td>
						</tr>
						<tr>
							<td>e)</td>
							<td>
								Presentar a la ATT información estadística, técnica y económica financiera, conforme a principios, criterios y condiciones aprobados por el regulador para el Sistema de Información Sectorial.
							</td>
						</tr>
						<tr>
							<td>f)</td>
							<td>
								Publicar los modelos de contratos, términos y condiciones aprobados por la ATT y poner a disposición del público en todas sus oficinas.
							</td>
						</tr>
						<tr>
							<td>g)</td>
							<td>
								Controlar todos los elementos contaminantes que se originen en las instalaciones de infraestructura, así como en sus actividades, en conformidad con las normas legales aplicables, de manera que no dañen la salud y el medio ambiente.
							</td>
						</tr>
					</table>
					<b>DECIMOCUARTO. (EXENCIONES DE RESPONSABILIDAD).- </b>	CANAZATEL no asumirá ninguna responsabilidad por las circunstancias que sucedan en los siguientes casos:
					<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
						<tr>
							<td>a)</td>
							<td>
								Por daños en los equipos terminales instalados en la red, provocados por descargas eléctricas o atmosféricas, elevaciones de voltaje, sobre tensiones, etc.
							</td>
						</tr>
						<tr>
							<td>b)</td>
							<td>
								Por las consecuencias que pueda generar el corte parcial o total del SERVICIO en forma temporal.
							</td>
						</tr>
						<tr>
							<td>c)</td>
							<td>
								Por la falta de cuidado, mal uso y/o conservación de dispositivos, terminales, accesorios y otros provistos en calidad de comodato por CANAZATEL al USUARIO(A), en cuyo caso el USUARIO(A) se compromete a pagar el precio correspondiente al costo de reposición.
							</td>
						</tr>
						<tr>
							<td>d)</td>
							<td>
								Por instalación incorrecta por parte del USUARIO(A) o terceros
							</td>
						</tr>
						<tr>
							<td>e)</td>
							<td>
								Por instalaciones de derivados clandestinos.
							</td>
						</tr>
						<tr>
							<td>f)</td>
							<td>
								Por el contenido de los programas difundidos por los diferentes canales de televisión.
							</td>
						</tr>
						<tr>
							<td>g)</td>
							<td>
								Por problemas originados por el estado o manejo inadecuado de la instalación física (cables).
							</td>
						</tr>
						<tr>
							<td>h)</td>
							<td>
								Por fallas de origen de las señales internacionales, nacionales o locales.
							</td>
						</tr>
						<tr>
							<td>i)</td>
							<td>
							Por fenómenos naturales que interfieran la emisión normal de la programación.
							</td>
						</tr>
						<tr>
							<td>j)</td>
							<td>
								Por la alteración de la programación desde origen.
							</td>
						</tr>
						<tr>
							<td>k)</td>
							<td>
								Por accidentes de terceros que puedan ocasionar daños a la red de distribución.
							</td>
						</tr>
						<tr>
							<td>l)</td>
							<td>
								Por imposibilidad técnica o causas ajenas a CANAZATEL, que impidan se efectúe un traslado.
							</td>
						</tr>
						<tr>
							<td>m)</td>
							<td>
								Por mal funcionamiento del televisor o equipo receptor del USUARIO(A), mismo que deberá ajustarse a normas técnicas.
							</td>
						</tr>
						<tr>
							<td>n)</td>
							<td>
								Por interrupciones en el servicio provenientes de casos fortuitos o fuerza mayor.
							</td>
						</tr>
						<tr>
							<td>o)</td>
							<td>
								Por el uso ilegal del SERVICIO.
							</td>
						</tr>
						<tr>
							<td>p)</td>
							<td>
								Por cualquier otro factor no atribuible a CANAZATEL, debido a las características técnicas del servicio provisto. 
							</td>
						</tr>
					</table>	
					<div style="text-align: justify;">	
					<b>DECIMOQUINTO. (ATENCIÓN DE RECLAMOS).- </b> El USUARIO(A) o un tercero por él, previa identificación, podrá presentar su reclamación, emergente de la prestación del SERVICIO, problemas de facturación, problema legal, cortes, emergencias u otros en la Oficina de Atención al Consumidor – ODECO 
					</div>
				</td>
				<td width="50%" style="padding-left: 5px;">
					<div style="text-align: justify;">
						emplazada en la instalaciones de CANAZATEL, ubicada en la siguiente dirección:
						<br>
						<br>
						<b>CANAZATEL TELECOMUNICACIONES S.R.L.</b>
						<br>
						<b>Dirección: ……………………………………………………….</b>
						<br>
						<b>Teléfono: ……………………</b>
						<br>
						<br>
						<b>Horarios de atención: </b>De 08:30 a 12:30 y de 14:30 a 18:30 horas los días hábiles, y los días sábados de 08:00 a 13:00 horas
						<br>
						<br>
						El USUARIO(A) podrá presentar su reclamación sobre el monto consignado en una factura: sin embargo, a objeto de evitar el corte del SERVICIO, debe pagar oportunamente el promedio del monto de las tres (3) últimas facturas pagadas.
						<br>
						<br>
						El reclamo podrá realizarse en forma verbal o escrita dentro de los veinte (20) días del conocimiento del hecho, acto u omisión que la motiva. En casos de urgencia el USUARIO(A) podrá efectuar inicialmente su reclamo a través de la línea telefónica con el N° …………………... CANAZATEL registrará la reclamación asignándole un número correlativo que será puesto en conocimiento del USUARIO(A).
						<br>
						<br>
						CANAZATEL resolverá la reclamación dentro de los siguientes plazos:
						<br>
						<table style="border-spacing: 0 !important; border-collapse: collapse !important; text-align: justify;">
							<tr>
								<td>a)</td>
								<td>
									A los tres (3) días de su recepción, en casos de interrupción del servicio o de alteraciones graves derivadas de su prestación; o
								</td>
							</tr>
							<tr>
								<td>b)</td>
								<td>
									A los quince (15) días en los demás casos.
								</td>
							</tr>
						</table>
						Si CANAZATEL decide la procedencia de la reclamación adoptará todas las medidas necesarias para, devolver los importes indebidamente cobrados, reparar o reponer, cuando corresponda y en general toda medida destinada a evitar perjuicios al USUARIO(A).
						<br>
						<br>
						En caso de rechazo o no resolución del reclamo, el USUARIO(A) podrá acudir en vía de reclamación administrativa ante la oficina de ODECO de la Autoridad de Regulación y Fiscalización en Transportes y Telecomunicaciones, mediante el llenado del formulario de segunda instancia disponible por CANAZATEL.
						<br>
						<br>
						<b>DECIMOSEXTO. (SERVICIOS DE INFORMACIÓN Y ASISTENCIA</b> Los servicios de información, asistencia, consultas y solicitudes del SERVICIO, serán atendidos en las instalaciones de CANAZATEL, ubicada en calle …………………………………………… de la localidad de ……………………. Los horarios de atención establecidos para esta oficina son de 08:30 a 12:30 y de 14:30 a 18:30 horas los días hábiles, y los días sábados de 08:00 a 13:00 horas; o mediante la línea telefónica con el N° …………….........
						<br>
						<br>
						<b>DECIMOSÉPTIMO.  (CAMBIO DE DOMICILIO O DE RAZÓN SOCIAL). </b> El USUARIO(A) puede solicitar por escrito el traslado del servicio, a este efecto CANAZATEL podrá aceptar o rechazar la solicitud, según las posibilidades técnicas de instalación del SERVICIO en el nuevo domicilio, que se realizará en un plazo no mayor a cinco (5) días hábiles siguientes de recibida la solicitud, previa cancelación del monto establecido para la instalación del servicio.
						<br>
						Todo cambio o modificación en la Razón Social, dirección, número de NIT, o cualquier cambio de los datos consignados en el Contrato, deberán ser notificados por el USUARIO(A) de forma escrita a CANAZATEL, para ser considerado en la próxima facturación.
						<br>
						<br>
						<b>DECIMOCTAVO. (DECLARACIÓN EXPRESA).- </b> Las partes declaran que no existe dolo ni ningún tipo de presión para la firma del presente Contrato de PROVISIÓN DEL SERVICIO DE DISTRIBUCIÓN DE SEÑALES. 
						<br>
						<br>
						El USUARIO(A) declara que todos los datos consignados en este contrato y en los formularios que han sido suscritos por él, son exactos, fidedignos y correctos. Asimismo, el USUARIO(A) declara expresamente lo siguiente:
						<br>
						<br>
						<table style=" text-align: justify;">
							<tr>
								<td>a)</td>
								<td>
									Que previa la firma de este contrato se ha informado por sus propios medios de las características técnicas del SERVICIO, condiciones de calidad, alcance, fiabilidad y de las limitaciones propias del servicio, habiendo CANAZATEL proporcionado toda la Información suficiente al respecto.
								</td>
							</tr>
							<tr>
								<td>b)</td>
								<td>
									Que conoce y acepta los TÉRMINOS Y CONDICIONES DE LA PRESTACIÓN DEL SERVICIO, mismos que forman parte integrante e inseparable del presente contrato para todos los efectos legales.
								</td>
							</tr>
							<tr>
								<td>c)</td>
								<td>
									Que está en conocimiento y acepta los términos, condiciones y posibles modificaciones de las tarifas establecidas por CANAZATEL de acuerdo al régimen tarifario vigente.
								</td>
							</tr>
							<tr>
								<td>d)</td>
								<td>
									Que está en conocimiento y acepta que el SERVICIO al que se adhiere, puede verse afectado o sufrir interferencias, cortes o interrupciones intempestivas, problemas técnicos o haber interrupción por mantenimiento programado u otros casos extraordinarios en los que CANAZATEL no se hará responsable de daños económicos o de otra índole que pudieran 
								</td>
							</tr>
						</table>
						<br>
						<br>
					</div>
				</td>
			</tr>
		</table>		
		
		<!--_________________________________  FIN TERCER PAGINA ______________________________________________-->
		<div style="page-break-after:always;"></div>
		<!--_________________________________  INICIO CUARTA PAGINA ______________________________________________-->
		<table style="width: 100%" cellspacing="" cellpadding="" border="0">
			<tr>
				<td width="50%" style="padding-right: 5px;">
					<table style=" text-align: justify;">
							<tr>
								<td></td>
								<td>
									suceder durante estos eventos, más allá de lo establecido dentro de la normativa vigente.
								</td>
							</tr>
							<tr>
								<td>e)</td>
								<td>
									Que CANAZATEL no será responsable  por  deficiencias del servicio resultantes del mal funcionamiento e inadecuado uso de los equipos del USUARIO(A).
								</td>
							</tr>
					</table>	
					<div style="text-align: justify;">
					<br>
					<b>DECIMONOVENO. (INVIOLABILIDAD Y PROTECCIÓN DE LA INFORMACIÓN DE LA USUARIA O USUARIO).- </b>	CANAZATEL adoptó las medidas más idóneas para salvaguardar la inviolabilidad de las telecomunicaciones, así como para preservar y mantener la confidencialidad de la información personal relativa al USUARIO(A) salvo en los casos establecidos por el artículo 58 de la Ley Nº 164 - Ley General de Telecomunicaciones, Tecnologías de Información y Comunicación.
					<br>
					<br>
					<b>VIGÉSIMO. (RESOLUCIÓN Y RESCISIÓN DEL CONTRATO).- </b> Cualquiera de las partes podrá solicitar la resolución del contrato: 
					<br>
					<br>
					<b>Resolución por parte del USUARIO(A)</b>
					<br>
					<br>
					</div>
					<table style=" text-align: justify;">
							<tr>
								<td>a)</td>
								<td>
								En el caso que el USUARIO(A) decida rescindir el CONTRATO antes de transcurrido el plazo mínimo establecido en la cláusula Quinto del presente contrato el USUARIO(A) deberá pagar el valor de los beneficios y/o de los descuentos a los cuales accedió por efecto de promociones al momento de contratar el SERVICIO. 
								</td>
							</tr>
							<tr>
								<td>b)</td>
								<td>
								Comunicar por escrito a CANAZATEL con treinta (30) días calendario de anticipación a la fecha efectiva de terminación para dicha rescisión.
								</td>
							</tr>
							<tr>
								<td>c)</td>
								<td>
								Estén canceladas todas las cuentas pendientes a la fecha de solicitud de suspensión definitiva del SERVICIO.
								</td>
							</tr>
							<tr>
								<td>d)</td>
								<td>
								Proceda a la devolución de dispositivos, terminales, accesorios y otros provistos por  CANAZATEL en un plazo de 48 horas desde la conclusión del servicio.
								</td>
							</tr>
							<tr>
								<td>e)</td>
								<td>
								Si el USUARIO(A) no devolviese los dispositivos, terminales, accesorios y otros, este deberá pagar a CANAZATEL la suma correspondiente al precio completo sin descuento ni subsidio alguno, caso contrario se considerara apropiación dé dichos dispositivos, terminales, accesorios y otros de propiedad de CANAZATEL en perjuicio de CANAZATEL y en provecho del USUARIO(A) por la no devolución oportuna y retención indebida de los mismos, reservándose el CANAZATEL iniciar los procesos judiciales pertinentes. 
								</td>
							</tr>
					</table>	
					<br>
					<b>Resolución por decisión de CANAZATEL</b>
					<table style=" text-align: justify;">
							<tr>
								<td>a)</td>
								<td>
								Por voluntad unilateral con preaviso de treinta (30) días calendario de anticipación.
								</td>
							</tr>
							<tr>
								<td>b)</td>
								<td>
								Ante el eventual incumplimiento por parte del USUARIO(A) en el pago de la tarifa consignada en el presente contrato.
								</td>
							</tr>
							<tr>
								<td>c)</td>
								<td>
								Ante el eventual incumplimiento de lo establecido en la cláusula Duodécimo del presente contrato.
								</td>
							</tr>
							<tr>
								<td>d)</td>
								<td>
								En caso de fraude de telecomunicaciones que haya sido detectado por CANAZATEL. CANAZATEL se reserva el derecho de iniciar las acciones correspondientes para el resarcimiento de daños y perjuicios ocasionados por el USUARIO(A).
								</td>
							</tr>
							<tr>
								<td>e)</td>
								<td>
								En caso de que el USUARIO(A) no comunicara cualquier cambio en la información proporcionada en el presente contrato y CANAZATEL verifique, error inexactitud o falsedad de la información provista por el USUARIO(A), CANAZATEL podrá resolver el contrato y cortar la provisión del SERVICIO.
								</td>
							</tr>
							<tr>
								<td>f)</td>
								<td>
								En caso fortuito o fuerza mayor.
								</td>
							</tr>
					</table>	
					<div style="text-align: justify;">
						La Resolución del CONTRATO no implicara extinción de las obligaciones del USUARIO que se encontrasen pendientes de cumplimiento al momento de la resolución ni la renuncia de CANAZATEL a sus derechos, ya sea a través de facturas ya emitidas o en su defecto por consumos realizados antes de la fecha efectiva de la terminación y que serán facturados de acuerdo a la normativa vigente.
						<br>
						<br>
						<b>VIGÉSIMO PRIMERO. (INTEGRIDAD DEL CONTRATO).- </b> Todo Anexo adjunto al presente Contrato, así como cualquier enmienda, modificación, apéndice o adenda que se añada en cualquier Anexo mediante anuncio, notificación o publicación en virtud de modificación normativa o comercial de CANAZATEL, formará parte plenamente integrante, inseparable e indivisible del presente Contrato, previa comunicación debida al USUARIO(A), mediante publicación en prensa o alternativamente utilizando otro medio, de acuerdo a la normativa vigente. En consecuencia, toda enmienda, modificación, apéndice o adenda que se añada al presente contrato quedara tácitamente aceptado por el USUARIO(A), de acuerdo a la normativa entonces vigente, salvo que el USUARIO(A), de forma expresa manifieste su no aceptación a estos cambios, en cuyo caso se podrá terminar la
					</div>	
				</td>
				<td width="50%" style="padding-left: 5px;">
				<div style="text-align: justify;">
					provisión del SERVICIO. Cuando así corresponda de acuerdo a la normativa vigente, CANAZATEL solicitará la autorización previa de la ATT.
					<br>
					Las clausulas contenidas en el presente Contrato están enmarcadas en la Ley Nº 164 - Ley General de Telecomunicaciones, Tecnologías de Información y Comunicación y sus Reglamentos vigentes a la fecha. Cualquier cambio en la normativa, que afecte a una o varias cláusulas del presente contrato modificará el mismo de acuerdo a la normatividad que este en vigencia, previa aprobación de la ATT, sin perjuicio de las modificaciones que puedan o deban ser aplicadas de forma inmediata,
					<br>
					<b>VIGÉSIMO SEGUNDO. (CLAUSULA DE INTERPRETACIÓN).- </b> En caso de duda sobre la interpretación del presente Contrato, se aplicara lo más favorable al USUARIO(A).
					<br>
					<b>VIGÉSIMO TERCERO. (ACEPTACIÓN).- </b> El USUARIO(A) y CANAZATEL expresamos nuestra libre, plena y absoluta conformidad con todas y cada una de las clausulas contenidas en el presente Contrato y sus Anexos, comprometiéndose a su fiel y estricto cumplimiento, en fe de lo cual suscribimos el presente contrato en doble ejemplar de un mismo tenor y para un solo efecto legal.
					<br>
					<br>
					<br>
					<br>Localidad: {{$contrato->NOM_LOC}}, (día) {{Carbon\Carbon::parse($contrato->FEC_SOL)->format('d')}} de (mes) {{strtoupper(Carbon\Carbon::parse($contrato->FEC_SOL)->isoFormat('MMMM'))}} de (año) {{Carbon\Carbon::parse($contrato->FEC_SOL)->format('Y')}}
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<table style="text-align: center; width: 100%">
						<tr>
							<td width="50%">
							<hr width="100%" style="margin:10px;">
							<br>
							<b>Firma del USUARIO(A)</b>
							<br>
							<br>
							<br>
							</td>
							<td width="50%">
							<hr width="100%" style="margin:10px;">
							<br>
							<b>Firma del representante de CANAZATELTELECOMUNICACIONES S.R.L.</b>
							</td>
						</tr>
					</table>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
				</div>
				</td>
			</tr>
		</table>		
		<!--_________________________________  FIN CUARTA PAGINA ______________________________________________-->

	</div>
</body>
</html>