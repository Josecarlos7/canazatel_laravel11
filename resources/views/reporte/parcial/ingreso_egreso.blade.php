<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-striped table-bordered">
            <tr class="bg-blue">
                <th width="50%">INGRESOS</th>
                <th width="50%">EGRESOS</th>
            </tr>
            <tr>
                <td>
                    @php $t_ingresos = 0; $t_egresos = 0; @endphp
                    <div class="panel box box-success" style="margin-bottom: 0px;">
                        <div class="box-header with-border">
                            <h4 class="box-title"><a data-toggle="collapse" data-parent="#accordion" href="#ingresos">DETALLES INGRESOS</a></h4>
                        </div>
                        <div id="ingresos" class="panel-collapse collapse">
                            <div class="box-body">
                                <table class="table table-hover table-bordered table-striped">
                                    @foreach ($ingresos as $ingreso)
                                    <tr>
                                        <td><small>{{ $ingreso->NOM_CLI . ' ' . $ingreso->APE_CLI }}</small></td>
                                        <td><small>{{ $ingreso->MOT_PAG }}</small></td>
                                        @php $subtotal_detalles = 0; $subtotal_otros = 0; @endphp
                                        @if (count($ingreso->detalles) != 0)
                                        @foreach ($ingreso->detalles as $detalle)
                                        @php $subtotal_detalles = $subtotal_detalles + $detalle->MONTO_PD @endphp
                                        @endforeach
                                        @endif
                                        @if (count($ingreso->otros) != 0)
                                        @foreach ($ingreso->otros as $otro)
                                        @php $subtotal_otros = $subtotal_otros + $otro->MONTO_PO @endphp
                                        @endforeach
                                        @endif
                                        @php $t_ingresos = $t_ingresos + $subtotal_detalles + $subtotal_otros @endphp
                                        <td><b>{{ $subtotal_detalles + $subtotal_otros }} Bs.</b></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr class="bg-gray">
                            <td colspan="2" class="text-right">TOTAL INGRESOS</td>
                            <td>{{ $t_ingresos }} Bs.</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <div class="panel box box-danger" style="margin-bottom: 0px;">
                        <div class="box-header with-border">
                            <h4 class="box-title"><a data-toggle="collapse" data-parent="#accordion" href="#egresos">DETALLES EGRESOS</a></h4>
                        </div>
                        <div id="egresos" class="panel-collapse collapse">
                            <div class="box-body">
                                <table class="table table-hover table-bordered table-striped">
                                    @foreach ($egresos as $egreso)
                                    <tr>
                                        <td><small>{{ $egreso->MOT_GAS }}</small></td>
                                        <td><b>{{ $egreso->CANT_GAS }} Bs.</b></td>
                                    </tr>
                                    @php $t_egresos = $t_egresos + $egreso->CANT_GAS @endphp
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr class="bg-gray">
                            <td class="text-right">TOTAL EGRESOS</td>
                            <td>{{ $t_egresos }} Bs.</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="bg-black">
                <td class="text-right">SALDO:</td>
                <td>{{ $t_ingresos - $t_egresos }} Bs.</td>
            </tr>
        </table>
    </div>
    <div class="row col-md-6">
        <div class="col-md-6">
            <a target="_blank" href="{{ url('reporte/pdf/ingreso_egreso_detalle/' . $request->tipo . '/' . $request->id_suc . '/' . $request->fec_ini . '/' . $request->fec_fin . '/' . $request->mes . '/' . $request->anio_m . '/' . $request->anio_a) }}" class="btn btn-success btn-block btn-sm"><i class="fa fa-print"></i> IMPRIMIR DETALLES</a>
        </div>
        <div class="col-md-6">
            <a target="_blank" href="{{ url('reporte/pdf/ingreso_egreso/' . $request->tipo . '/' . $request->id_suc . '/' . $request->fec_ini . '/' . $request->fec_fin . '/' . $request->mes . '/' . $request->anio_m . '/' . $request->anio_a) }}" class="btn btn-success btn-block btn-sm"><i class="fa fa-print"></i> IMPRIMIR TOTALES</a>
        </div>
    </div>
</div>
