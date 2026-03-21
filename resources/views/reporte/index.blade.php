@extends('layouts.master')
@section('reporte','active')
@section('title','REPORTES DEL SISTEMA')
@section('content')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#ingresos_egresos" data-toggle="tab">INGRESOS Y EGRESOS</a></li>
        @role('ADMINISTRADOR|GERENCIA GENERAL|SUPER_ADMIN')
        <li><a href="#clientes" data-toggle="tab">CLIENTES</a></li>
        <li><a href="#gdeudores" data-toggle="tab">DEUDORES Y PUNTUALES</a></li>
        <li><a href="#ingresos_egresos_total" data-toggle="tab">INGRESOS Y EGRESOS TOTAL</a></li>
        <li><a href="#mes_ingreso" data-toggle="tab">INGRESOS POR MES</a></li>
        @endrole
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="ingresos_egresos">
            <form id="form_ingreso_egreso">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SUCURSAL:</label>
                            <select class="form-control" name="id_suc" onchange="limpiar_ie()">
                                <option disabled selected>-ESCOJA UNA SUCURSAL-</option>
                                @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->ID_SUC }}">{{ $sucursal->NOM_SUC }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>TIPO DE BUSQUEDA:</label>
                            <select class="form-control" name="tipo" onchange="tipoBusqueda(this.value); limpiar_ie();">
                                <option value="FECHAS">POR FECHAS</option>
                                <option value="MENSUAL">MENSUAL</option>
                                <option value="ANUAL">ANUAL</option>
                            </select>
                        </div>
                    </div>
                    <div id="div_fechas">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>FECHA DE INICIO:</label>
                                <input type="date" class="form-control" name="fec_ini" value="{{ now()->format('Y-m-d') }}" onchange="limpiar_ie();">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>FECHA FINAL:</label>
                                <input type="date" class="form-control" name="fec_fin" value="{{ now()->format('Y-m-d') }}" onchange="limpiar_ie();">
                            </div>
                        </div>
                    </div>
                    <div id="div_mensual" style="display: none;" onchange="limpiar_ie();">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>MES:</label>
                                <select class="form-control" name="mes">
                                    <option value="1">ENERO</option>
                                    <option value="2">FEBRERO</option>
                                    <option value="3">MARZO</option>
                                    <option value="4">ABRIL</option>
                                    <option value="5">MAYO</option>
                                    <option value="6">JUNIO</option>
                                    <option value="7">JULIO</option>
                                    <option value="8">AGOSTO</option>
                                    <option value="9">SEPTIEMBRE</option>
                                    <option value="10">OCTUBRE</option>
                                    <option value="11">NOVIEMBRE</option>
                                    <option value="12">DICIEMBRE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>AÑO:</label>
                                <input type="number" class="form-control" name="anio_m" value="{{ now()->format('Y') }}" onchange="limpiar_ie();">
                            </div>
                        </div>
                    </div>
                    <div id="div_anual" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>AÑO:</label>
                                <input type="number" class="form-control" name="anio_a" value="{{ now()->format('Y') }}" onchange="limpiar_ie();">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-warning btn-sm btn-block" type="button" onclick="ingreso_egreso();"><i class="fa fa-search"></i> GENERAR REPORTE</button>
                <div id="div_ingreso_egreso"></div>
            </form>
        </div>

        <div class="tab-pane" id="clientes">
            <form id="form_clientes">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>SUCURSAL:</label>
                            <select class="form-control" name="id_suc" onchange="limpiar_ie()">
                                <option disabled selected>-ESCOJA UNA SUCURSAL-</option>
                                @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->ID_SUC }}">{{ $sucursal->NOM_SUC }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>TIPO BUSQUEDA:</label>
                            <select class="form-control" name="tipo">
                                <option value="PUNTUALES">PUNTUALES</option>
                                <option value="DEUDORES">DEUDORES</option>
                                <option value="EN CORTE">EN CORTE</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-warning btn-sm btn-block" type="button" onclick="clientes();"><i class="fa fa-search"></i> GENERAR REPORTE</button>
                    <div id="div_clientes"></div>
                </div>
            </form>
        </div>

        <div class="tab-pane" id="gdeudores">
            <div id="grafico1" style="min-width: 800px; height: 400px; max-width: 800px; margin: 0 auto"></div>
        </div>

        <div class="tab-pane" id="ingresos_egresos_total">
            <form id="form_ingreso_egreso_total">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>FECHA DE INICIO:</label>
                        <input type="date" class="form-control" name="fec_ini" value="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>FECHA FINAL:</label>
                        <input type="date" class="form-control" name="fec_fin" value="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>SUCURSAL:</label>
                        <select class="form-control" name="id_suc" onchange="limpiar_ie()">
                            <option selected value="TODOS">-TODAS LAS SUCURSALES-</option>
                            @foreach ($sucursales as $sucursal)
                            <option value="{{ $sucursal->ID_SUC }}">{{ $sucursal->NOM_SUC }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button class="btn btn-warning btn-sm btn-block" type="button" onclick="ingresos_egresos_total();"><i class="fa fa-search"></i> GENERAR REPORTE</button>
            </form>
            <div id="div_ingreso_egresos_total"></div>
        </div>

        <div class="tab-pane" id="mes_ingreso">
            <form id="form_mes_ingreso">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>SELECCIONE AÑO:</label>
                        <select class="form-control" name="anio">
                            <option selected value="{{ now()->format('Y') }}">{{ now()->format('Y') }}</option>
                            <option value="{{ now()->subYear()->format('Y') }}">{{ now()->subYear()->format('Y') }}</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-warning btn-sm btn-block" type="button" onclick="mes_ingreso();"><i class="fa fa-search"></i> GENERAR REPORTE</button>
            </form>
            <div id="div_mes_ingreso"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPuntualesDeudores">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Puntuales y deudores</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="div_puntuales_deudores"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('template/highcharts/js/highcharts.js') }}"></script>
<script src="{{ asset('template/highcharts/js/modules/exporting.js') }}"></script>
<script type="text/javascript">
    function ingreso_egreso() {
        $.ajax({
            url: "{{ route('reporte.ingreso_egreso') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            type: 'POST',
            dataType: 'HTML',
            data: $('#form_ingreso_egreso').serialize(),
            beforeSend: function() { $('#div_ingreso_egreso').html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>'); },
            success: function(data) { $('#div_ingreso_egreso').html(data); },
            error: function(data) { console.log(data); }
        });
    }

    function limpiar_ie() {
        $('#div_ingreso_egreso').empty();
    }

    function tipoBusqueda(tipo) {
        if (tipo == 'FECHAS') {
            $('#div_mensual').fadeOut();
            $('#div_anual').fadeOut();
            $('#div_fechas').fadeIn();
        }
        if (tipo == 'MENSUAL') {
            $('#div_fechas').fadeOut();
            $('#div_anual').fadeOut();
            $('#div_mensual').fadeIn();
        }
        if (tipo == 'ANUAL') {
            $('#div_fechas').fadeOut();
            $('#div_mensual').fadeOut();
            $('#div_anual').fadeIn();
        }
    }

    function clientes() {
        $.ajax({
            url: "{{ route('reporte.clientes') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            type: 'POST',
            dataType: 'HTML',
            data: $('#form_clientes').serialize(),
            beforeSend: function() { $('#div_clientes').html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>'); },
            success: function(data) { $('#div_clientes').html(data); },
            error: function(data) { console.log(data); }
        });
    }

    $(function() {
        $('#grafico1').highcharts({
            chart: { type: 'bar' },
            title: { text: 'CLIENTES PUNTUALES Y DEUDORES POR SUCURSAL' },
            subtitle: { text: '' },
            xAxis: {
                categories: [
                    @foreach ($sucursales as $sucursal)
                    '{{ $sucursal->NOM_SUC }}',
                    @endforeach
                ],
                title: { text: null }
            },
            yAxis: {
                min: 0,
                title: { text: 'Nro. de clientes', align: 'high' },
                labels: { overflow: 'justify' }
            },
            tooltip: { valueSuffix: ' cliente(s)' },
            plotOptions: {
                bar: { dataLabels: { enabled: true } },
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                puntuales_deudores_body(this.category);
                            }
                        }
                    }
                }
            },
            credits: { enabled: false },
            series: [{
                name: 'CLIENTES DEUDORES',
                data: [
                    @foreach ($deudores as $deudor)
                    {{ $deudor['NRO_DEUDORES'] }},
                    @endforeach
                ]
            }, {
                name: 'CLIENTES PUNTUALES',
                data: [
                    @foreach ($puntuales as $puntual)
                    {{ $puntual['NRO_PUNTUALES'] }},
                    @endforeach
                ]
            }]
        });
    });

    function ingresos_egresos_total() {
        $.ajax({
            url: "{{ route('reporte.ingresos_egresos_total') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            type: 'POST',
            dataType: 'HTML',
            data: $('#form_ingreso_egreso_total').serialize(),
            beforeSend: function() { $('#div_ingreso_egresos_total').html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>'); },
            success: function(data) { $('#div_ingreso_egresos_total').html(data); },
            error: function(data) { console.log(data); }
        });
    }

    function mes_ingreso() {
        $.ajax({
            url: "{{ route('reporte.mes_ingreso') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            type: 'POST',
            dataType: 'HTML',
            data: $('#form_mes_ingreso').serialize(),
            beforeSend: function() { $('#div_mes_ingreso').html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>'); },
            success: function(data) { $('#div_mes_ingreso').html(data); },
            error: function(data) { console.log(data); }
        });
    }

    function puntuales_deudores_body(nom_suc) {
        $('#modalPuntualesDeudores').modal('show');
        $.ajax({
            url: "{{ route('reporte.puntualesDeudoresBody') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            type: 'POST',
            dataType: 'HTML',
            data: { nom_suc: nom_suc },
            beforeSend: function() { $('#div_puntuales_deudores').html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>'); },
            success: function(data) { $('#div_puntuales_deudores').html(data); },
            error: function(data) { console.log(data); }
        });
    }
</script>
@endsection
