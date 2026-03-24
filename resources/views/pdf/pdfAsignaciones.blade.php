<!DOCTYPE html>
<html>

<head>
    <title>PAGOS REALIZADOS</title>
    <style type="text/css">
        @page {
            margin: 0cm;
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
        }

        body {
            font-family: "Helvetica";
            font-size: 14.5px;
            /*color: #676a6c;*/
            color: black;
        }

        .format {
            position: absolute;
            z-index: 1;
        }

        .principal {
            font-size: 1.8em;
            font-weight: bold;
        }

        .secundario {
            font-size: 1.2em;
            font-weight: bold;
        }

        .medio {
            vertical-align: middle;
        }

        .ch {
            margin-bottom: 0px;
        }

        .text-left {
            text-align: left
        }

        .text-right {
            text-align: right
        }

        .text-center {
            text-align: center
        }
    </style>
</head>

<body>
    <div class="format">
        @php
            $contador = 0;
        @endphp
        @foreach ($contratos as $contrato)
            @if ($contrato->TIPO_PLAN == 'TV')
                <table style="width: 100%" cellspacing="" cellpadding="" border="0">
                    <tr>
                        <td width="33%">{{ $contrato->NOM_SUC }} <br>FECHA CONTRATO: {{ $contrato->FEC_SOL }}
                            <br>FECHA ACTUAL: {{ Carbon\Carbon::now()->format('Y-m-d') }}</td>
                        <td width="33%"></td>
                        <td width="33%">HORA: {{ $contrato->HOR_SOL }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Nº ORDEN {{ $contrato->COD_CON }}</td>
                    </tr>
                </table>
                <br>
                <br>
                <br>
                <br>
                <b>Señores:</b>
                <br>
                CANAZATEL_TELECOMUNICACIONES_ S_R_L
                <br>
                <br>
                Presente.-
                <br>
                <b>Ref.: SOLICITUD DE SERVICIO</b>
                <br>
                De mi mayor consideración:
                <br>
                Me permito solicitar el servicio que Ustedes brindan por el siguiente motivo
                <br>
                {{ $contrato->TXT_CON }}
                <br>
                <br>
                Esperando ser atendido con mi solicitud lo antes posible, saludo a usted muy atentamente.
                <br>
                <br>
                <br>
                <div style="text-align: center;">
                    {{ $contrato->NOM_CLI . ' ' . $contrato->APE_CLI }}
                    <br>
                    {{ $contrato->DIR_CLI }}
                    <br>
                    Código usuario: {{ $contrato->COD_CLI }}
                </div>
                <br>
                INFORME DEL TRABAJO REALIZADO:
                <br>
                Nombre:………………………………………………………… Cargo:…………………………………………………...
                Fecha y Hora de inicio:……………………………………………… y Finalización:…………………………………....
                Obs:……………………………………………………………………………………………………………......................
                ……………………………………………………………………………………………………………………………….....
                <br>
                <br>
                <table style="width: 100%" cellspacing="" cellpadding="" border="0">
                    <tr>
                        <td width="33%">
                            <b style="text-align: center;">INFORMACION TECNICA</b>
                            <table style="width: 100%" border="0">
                                <tr>
                                    <td width="50%">MALO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">DEFICIENCIA</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">SATISFACTORIO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">REGULAR</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">BUEN</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">MUY BUENO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">EXCELENTE</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                            </table>
                        </td>
                        <td width="33%">
                            <b style="text-align: center;">MATERIALES UTILIZADOS</b>
                            <table style="width: 100%" border="0">
                                <tr>
                                    <td width="50%">AMPLIFICADOR</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">SPLITER</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">CONECTORES</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">ACOPLES</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">GRAMPAS</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">CINTA RECAUCHICANTE</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">CINTA ENLANTE</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                            </table>
                        </td>
                        <td width="33%">
                            <b style="text-align: center;">TRABAJO REALIZADO</b>
                            <table style="width: 100%" border="0">
                                <tr>
                                    <td width="50%">INSTALACION</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">REPARACION</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">RETIROS DE EQUIPOS</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">RECONEXION</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">ALTA TRASLADO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">BAJO TRASLADO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">SERVICIOS ADICIONALES</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <table style="width: 100%; text-align: center;">
                    <tr>
                        <td width="33%">Firma Técnico</td>
                        <td width="33%">Firma Cliente</td>
                        <td width="33%">Jefe Técnico</td>
                    </tr>
                </table>
            @endif <!--viene desde arriba preguntando si es TV-->
            @if ($contrato->TIPO_PLAN == 'WIFI' or $contrato->TIPO_PLAN == 'TV_WIFI')
                <table style="width: 100%" cellspacing="" cellpadding="" border="0">
                    <tr>
                        <td width="33%">{{ $contrato->NOM_SUC }} <br>FECHA CONTRATO: {{ $contrato->FEC_SOL }}
                            <br>FECHA ACTUAL: {{ Carbon\Carbon::now()->format('Y-m-d') }}</td>
                        <td width="33%"></td>
                        <td width="33%">HORA: {{ $contrato->HOR_SOL }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>NRO: {{ $contrato->COD_CON }}</td>
                    </tr>
                </table>
                <br>
                <br>
                <br>
                <br>
                CANAZATEL_TELECOMUNICACIONES_ S_R_L
                <br>
                <br>
                Presente.-
                <br>
                <b>Ref.: SOLICITUD DE SERVICIO</b>
                <br>
                Me permito solicitar el servicio que usted brinda por el siguiente motivo
                <br>
                {{ $contrato->TXT_CON }}
                <br>
                <br>
                De mi mayor consideracion:
                <br>
                <br>
                Esperando ser atendido con mi solicitud lo antes posible, saludo a usted muy atentamente.
                <br>
                <br>
                <br>
                <div style="text-align: center;">
                    {{ $contrato->NOM_CLI . ' ' . $contrato->APE_CLI }}
                    <br>
                    {{ $contrato->DIR_CLI }}
                    <br>
                    Código
                    <br>
                    {{ $contrato->COD_CLI }}
                    <br>
                    CI: {{ $contrato->CI_CLI }}
                    <br>
                    CEL: {{ $contrato->CEL_CLI }}
                </div>
                <br>
                <b>INFORME DEL TRABAJO REALIZADO:</b>
                <br>
                Nombre:………………………………………………………… Cargo:…………………………………………………...
                Fecha y Hora de inicio:……………………………………………… y Finalización:…………………………………....
                Obs:……………………………………………………………………………………………………………......................
                ……………………………………………………………………………………………………………………………….....
                <br>
                <br>
                <table style="width: 100%" cellspacing="" cellpadding="" border="0">
                    <tr>
                        <td width="33%">
                            <b style="text-align: center;">INFORMACION TECNICA</b>
                            <table style="width: 100%" border="0">
                                <tr>
                                    <td width="50%">MALO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">DEFICIENCIA</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">SATISFACTORIO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">REGULAR</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">BUEN</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">MUY BUENO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">EXCELENTE</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                            </table>
                        </td>
                        <td width="33%">
                            <b style="text-align: center;">MATERIALES UTILIZADOS</b>
                            <table style="width: 100%" border="0">
                                <tr>
                                    <td width="50%">AMPLIFICADOR</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">SPLITER</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">CONECTORES</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">ACOPLES</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">GRAMPAS</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">CINTA RECAUCHICANTE</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">CINTA ENLANTE</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                            </table>
                        </td>
                        <td width="33%">
                            <b style="text-align: center;">TRABAJO REALIZADO</b>
                            <table style="width: 100%" border="0">
                                <tr>
                                    <td width="50%">INSTALACION</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">REPARACION</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">RETIROS DE EQUIPOS</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">RECONEXION</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">ALTA TRASLADO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">BAJO TRASLADO</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                                <tr>
                                    <td width="50%">SERVICIOS ADICIONALES</td>
                                    <td width="50%"><input type="checkbox" class="medio ch"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <table style="width: 100%; text-align: center;">
                    <tr>
                        <td width="33%">Firma Técnico</td>
                        <td width="33%">Firma Cliente</td>
                        <td width="33%">Jefe Técnico</td>
                    </tr>
                </table>
            @endif <!--if pregunta si es WIFI o TV_WIFI-->


            @php
                $contador++;
            @endphp
            @if ($contador != count($contratos))
                <div style="page-break-after:always;"></div>
            @endif
        @endforeach
    </div>
</body>

</html>
