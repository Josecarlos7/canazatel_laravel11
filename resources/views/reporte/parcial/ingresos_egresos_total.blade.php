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
                                        <td><small>{{ $ingreso->NOM_SUC }}</small></td>
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
                                        <td><small>{{ $egreso->NOM_SUC }}</small></td>
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

    <div id="grafico2" style="min-width: 800px; height: 500px; max-width: 800px; margin: 0 auto"></div>
    <script type="text/javascript">
        var colors = ['#4DCF4A', '#DA7A6A'];
        $(function () {
            $('#grafico2').highcharts({
                chart: { type: 'bar' },
                title: { text: 'INGRESOS Y EGRESOS SUCURSALES' },
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
                    title: { text: 'Monto en Bs', align: 'high' },
                    labels: { overflow: 'justify' }
                },
                tooltip: { valueSuffix: ' Bs.' },
                plotOptions: { bar: { dataLabels: { enabled: true } } },
                credits: { enabled: false },
                colors: colors,
                series: [{
                    name: 'INGRESOS',
                    data: [
                        @foreach ($sucursales as $sucursal)
                        @php
                        $tIngresos = 0;
                        $ingresosSucursal = \App\Models\Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
                            ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                            ->whereBetween('FEC_PAG', [$request->fec_ini, $request->fec_fin])
                            ->when($request, function ($query, $request) {
                                if ($request->id_suc != 'TODOS') {
                                    return $query->where('contrato.ID_SUC', $request->id_suc);
                                }
                            })
                            ->orderBy('ID_PAG', 'ASC')
                            ->where('contrato.ID_SUC', $sucursal->ID_SUC)
                            ->with('detalles')
                            ->with('otros')
                            ->get();

                        foreach ($ingresosSucursal as $ingresoSucursal) {
                            $subtotalDetalles = 0;
                            $subtotalOtros = 0;
                            if (count($ingresoSucursal->detalles) != 0) {
                                foreach ($ingresoSucursal->detalles as $detalleSucursal) {
                                    $subtotalDetalles = $subtotalDetalles + $detalleSucursal->MONTO_PD;
                                }
                            }
                            if (count($ingresoSucursal->otros) != 0) {
                                foreach ($ingresoSucursal->otros as $otroSucursal) {
                                    $subtotalOtros = $subtotalOtros + $otroSucursal->MONTO_PO;
                                }
                            }
                            $tIngresos = $tIngresos + $subtotalDetalles + $subtotalOtros;
                        }
                        @endphp
                        {{ $tIngresos }},
                        @endforeach
                    ]
                }, {
                    name: 'EGRESOS',
                    data: [
                        @foreach ($sucursales as $sucursal)
                        @php
                        $tEgresos = 0;
                        $egresosSucursal = \App\Models\Gasto::whereBetween('FEC_GAS', [$request->fec_ini, $request->fec_fin])
                            ->join('sucursal', 'sucursal.ID_SUC', '=', 'gasto.ID_SUC')
                            ->when($request, function ($query, $request) {
                                if ($request->id_suc != 'TODOS') {
                                    return $query->where('gasto.ID_SUC', $request->id_suc);
                                }
                            })
                            ->where('gasto.ID_SUC', $sucursal->ID_SUC)
                            ->orderBy('ID_GAS', 'ASC')
                            ->get();

                        foreach ($egresosSucursal as $egresoSucursal) {
                            $tEgresos = $tEgresos + $egresoSucursal->CANT_GAS;
                        }
                        @endphp
                        {{ $tEgresos }},
                        @endforeach
                    ]
                }]
            });
        });
    </script>
</div>
