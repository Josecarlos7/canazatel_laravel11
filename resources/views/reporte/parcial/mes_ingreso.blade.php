<div id="grafico3" style="min-width: 800px; height: 400px; max-width: 800px; margin: 0 auto"></div>
<script type="text/javascript">
    $(function () {
        $('#grafico3').highcharts({
            chart: { type: 'line' },
            title: { text: 'Reportes segun el mes' },
            subtitle: { text: 'AÑO: ' + {{ $request->anio }} },
            xAxis: { categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'] },
            yAxis: { title: { text: 'Monto en Bs.' } },
            plotOptions: {
                line: {
                    dataLabels: { enabled: true },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'INGRESOS',
                data: [
                    @for ($i = 1; $i < 13; $i++)
                    @php
                    $tIngresos = 0;
                    $ingresos = \App\Models\Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                        ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                        ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                        ->whereMonth('FEC_PAG', $i)
                        ->whereYear('FEC_PAG', $request->anio)
                        ->with('detalles')
                        ->with('otros')
                        ->get();

                    foreach ($ingresos as $ingreso) {
                        $subtotalDetalles = 0;
                        $subtotalOtros = 0;
                        if (count($ingreso->detalles) != 0) {
                            foreach ($ingreso->detalles as $detalle) {
                                $subtotalDetalles = $subtotalDetalles + $detalle->MONTO_PD;
                            }
                        }
                        if (count($ingreso->otros) != 0) {
                            foreach ($ingreso->otros as $otro) {
                                $subtotalOtros = $subtotalOtros + $otro->MONTO_PO;
                            }
                        }
                        $tIngresos = $tIngresos + $subtotalDetalles + $subtotalOtros;
                    }
                    @endphp
                    {{ $tIngresos }},
                    @endfor
                ]
            }, {
                name: 'EGRESOS',
                data: [
                    @for ($i = 1; $i < 13; $i++)
                    @php
                    $tEgresos = 0;
                    $egresos = \App\Models\Gasto::whereMonth('FEC_GAS', $i)
                        ->whereYear('FEC_GAS', $request->anio)
                        ->join('sucursal', 'sucursal.ID_SUC', '=', 'gasto.ID_SUC')
                        ->orderBy('ID_GAS', 'ASC')
                        ->get();

                    foreach ($egresos as $egreso) {
                        $tEgresos = $tEgresos + $egreso->CANT_GAS;
                    }
                    @endphp
                    {{ $tEgresos }},
                    @endfor
                ]
            }]
        });
    });
</script>
