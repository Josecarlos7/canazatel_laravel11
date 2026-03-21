<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Gasto;
use App\Models\Pago;
use App\Models\PagoDetalle;
use App\Models\Sucursal;
use App\Traits\DeudaTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    use DeudaTrait;

    public function index()
    {
        if (Auth::user()->hasRole('SECRETARIO(A)')) {
            $sucursales = Sucursal::where('ID_SUC', Auth::user()->ID_SUC)->get();
        } else {
            $sucursales = Sucursal::all();
        }

        $deudores = collect([]);
        $puntuales = collect([]);
        foreach ($sucursales as $sucursal) {
            $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
                ->where('contrato.EST_CON', '<>', 'CANCELADO')
                ->where('contrato.ID_SUC', $sucursal->ID_SUC)
                ->get();

            $nroDeudores = count($this->deudoresTrait($clientes));
            $nroPuntuales = count($this->puntualesTrait($clientes));

            $deudores->push([
                'ID_SUC' => $sucursal->ID_SUC,
                'NOM_SUC' => $sucursal->NOM_SUC,
                'NRO_DEUDORES' => $nroDeudores,
            ]);

            $puntuales->push([
                'ID_SUC' => $sucursal->ID_SUC,
                'NOM_SUC' => $sucursal->NOM_SUC,
                'NRO_PUNTUALES' => $nroPuntuales,
            ]);
        }

        return view('reporte.index', compact('sucursales', 'deudores', 'puntuales'));
    }

    public function puntualesDeudoresBody(Request $request)
    {
        $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->where('contrato.EST_CON', '<>', 'CANCELADO')
            ->where('sucursal.NOM_SUC', $request->nom_suc)
            ->get();

        $deudores = $this->deudoresTrait($clientes);
        $puntuales = $this->puntualesTrait($clientes);

        return view('reporte.parcial.puntuales_deudores_body', compact('deudores', 'puntuales'))->render();
    }

    public function ingreso_egreso(Request $request)
    {
        $tipo = $request->tipo;
        $anioM = $request->input('anio_m', $request->input('año_m'));
        $anioA = $request->input('anio_a', $request->input('año_a'));

        if ($tipo == 'FECHAS') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereBetween('FEC_PAG', [$request->fec_ini, $request->fec_fin])
                ->where('contrato.ID_SUC', $request->id_suc)
                ->orderBy('ID_PAG', 'ASC')
                ->with('detalles')
                ->with('otros')
                ->get();

            $egresos = Gasto::where('ID_SUC', $request->id_suc)
                ->whereBetween('FEC_GAS', [$request->fec_ini, $request->fec_fin])
                ->orderBy('ID_GAS', 'ASC')
                ->get();
        }

        if ($tipo == 'MENSUAL') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereMonth('FEC_PAG', $request->mes)
                ->whereYear('FEC_PAG', $anioM)
                ->where('contrato.ID_SUC', $request->id_suc)
                ->orderBy('ID_PAG', 'ASC')
                ->with('detalles')
                ->with('otros')
                ->get();

            $egresos = Gasto::where('ID_SUC', $request->id_suc)
                ->whereMonth('FEC_GAS', $request->mes)
                ->whereYear('FEC_GAS', $anioM)
                ->orderBy('ID_GAS', 'ASC')
                ->get();
        }

        if ($tipo == 'ANUAL') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereYear('FEC_PAG', $anioA)
                ->where('contrato.ID_SUC', $request->id_suc)
                ->orderBy('ID_PAG', 'ASC')
                ->with('detalles')
                ->with('otros')
                ->get();

            $egresos = Gasto::where('ID_SUC', $request->id_suc)
                ->whereYear('FEC_GAS', $anioA)
                ->orderBy('ID_GAS', 'ASC')
                ->get();
        }

        $request->merge(['anio_m' => $anioM, 'anio_a' => $anioA]);

        return view('reporte.parcial.ingreso_egreso', compact('ingresos', 'egresos', 'request'))->render();
    }

    public function pdf_ingreso_egreso($tipo, $id_suc, $fec_ini, $fec_fin, $mes, $anio_m, $anio_a)
    {
        if ($tipo == 'FECHAS') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereBetween('FEC_PAG', [$fec_ini, $fec_fin])
                ->where('contrato.ID_SUC', $id_suc)
                ->orderBy('ID_PAG', 'ASC')
                ->with('detalles')
                ->with('otros')
                ->get();

            $egresos = Gasto::where('ID_SUC', $id_suc)
                ->whereBetween('FEC_GAS', [$fec_ini, $fec_fin])
                ->get();
        }

        if ($tipo == 'MENSUAL') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereMonth('FEC_PAG', $mes)
                ->whereYear('FEC_PAG', $anio_m)
                ->where('contrato.ID_SUC', $id_suc)
                ->orderBy('ID_PAG', 'ASC')
                ->with('detalles')
                ->with('otros')
                ->get();

            $egresos = Gasto::where('ID_SUC', $id_suc)
                ->whereMonth('FEC_GAS', $mes)
                ->whereYear('FEC_GAS', $anio_m)
                ->get();
        }

        if ($tipo == 'ANUAL') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereYear('FEC_PAG', $anio_a)
                ->where('contrato.ID_SUC', $id_suc)
                ->orderBy('ID_PAG', 'ASC')
                ->with('detalles')
                ->with('otros')
                ->get();

            $egresos = Gasto::where('ID_SUC', $id_suc)
                ->whereYear('FEC_GAS', $anio_a)
                ->get();
        }

        $sucursal = Sucursal::findOrFail($id_suc);

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.ingreso_egreso', compact('ingresos', 'egresos', 'sucursal', 'tipo', 'fec_ini', 'fec_fin', 'mes', 'anio_m', 'anio_a'));

        return $pdf->stream('INGRESOS_Y_EGRESOS.pdf');
    }

    public function pdf_ingreso_egreso_detalle($tipo, $id_suc, $fec_ini, $fec_fin, $mes, $anio_m, $anio_a)
    {
        $planes = ['TV', 'WIFI', 'TV_WIFI'];

        if ($tipo == 'FECHAS') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->leftJoin('pago_detalle', 'pago_detalle.ID_PAG', '=', 'pago.ID_PAG')
                ->leftJoin('pago_otro', 'pago_otro.ID_PAG', '=', 'pago.ID_PAG')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
                ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereBetween('FEC_PAG', [$fec_ini, $fec_fin])
                ->where('contrato.ID_SUC', $id_suc)
                ->orderBy('pago.ID_PAG', 'ASC')
                ->get();

            $egresos = Gasto::where('ID_SUC', $id_suc)
                ->whereBetween('FEC_GAS', [$fec_ini, $fec_fin])
                ->get();
        }

        if ($tipo == 'MENSUAL') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->leftJoin('pago_detalle', 'pago_detalle.ID_PAG', '=', 'pago.ID_PAG')
                ->leftJoin('pago_otro', 'pago_otro.ID_PAG', '=', 'pago.ID_PAG')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
                ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereMonth('FEC_PAG', $mes)
                ->whereYear('FEC_PAG', $anio_m)
                ->where('contrato.ID_SUC', $id_suc)
                ->orderBy('pago.ID_PAG', 'ASC')
                ->get();

            $egresos = Gasto::where('ID_SUC', $id_suc)
                ->whereMonth('FEC_GAS', $mes)
                ->whereYear('FEC_GAS', $anio_m)
                ->get();
        }

        if ($tipo == 'ANUAL') {
            $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->leftJoin('pago_detalle', 'pago_detalle.ID_PAG', '=', 'pago.ID_PAG')
                ->leftJoin('pago_otro', 'pago_otro.ID_PAG', '=', 'pago.ID_PAG')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
                ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
                ->where('MOT_PAG', 'NOT LIKE', '%DESCUENTO%')
                ->whereYear('FEC_PAG', $anio_a)
                ->where('contrato.ID_SUC', $id_suc)
                ->orderBy('pago.ID_PAG', 'ASC')
                ->get();

            $egresos = Gasto::where('ID_SUC', $id_suc)
                ->whereYear('FEC_GAS', $anio_a)
                ->get();
        }

        $sucursal = Sucursal::findOrFail($id_suc);

        $pdf = Pdf::setPaper('LETTER', 'landscape')->loadView('pdf.ingreso_egreso_detalle', compact('planes', 'ingresos', 'egresos', 'sucursal', 'tipo', 'fec_ini', 'fec_fin', 'mes', 'anio_m', 'anio_a'));

        return $pdf->stream('INGRESOS_Y_EGRESOS_DETALLE.pdf');
    }

    public function clientes(Request $request)
    {
        $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->where('contrato.ID_SUC', $request->id_suc)
            ->where('contrato.EST_CON', '<>', 'CANCELADO')
            ->get();

        switch ($request->tipo) {
            case 'PUNTUALES':
                $lista = $this->puntualesTrait($clientes);
                break;
            case 'DEUDORES':
                $lista = $this->deudoresTrait($clientes)->sortBy('dias_deuda', SORT_REGULAR, true);
                break;
            case 'EN CORTE':
                $lista = $this->deudoresTrait($clientes)->where('mensaje', 'EN CORTE');
                break;
            default:
                $lista = collect([]);
                break;
        }

        return view('reporte.parcial.clientes', compact('lista', 'request'))->render();
    }

    public function clientes_pdf($id_suc, $tipo)
    {
        @ini_set('memory_limit', '1024M');
        @set_time_limit(300);

        $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->select(
                'cliente.ID_CLI',
                'cliente.NOM_CLI',
                'cliente.APE_CLI',
                'cliente.CI_CLI',
                'cliente.DIR_CLI',
                'cliente.COD_CLI',
                'contrato.ID_CON',
                'contrato.EST_CON',
                'contrato.FEC_BF',
                'contrato.TIPO_PAGO'
            )
            ->where('contrato.ID_SUC', $id_suc)
            ->where('contrato.EST_CON', '<>', 'CANCELADO')
            ->get();

        switch ($tipo) {
            case 'PUNTUALES':
                $lista = $this->puntualesTrait($clientes);
                break;
            case 'DEUDORES':
                $lista = $this->deudoresTrait($clientes)->sortBy('dias_deuda', SORT_REGULAR, true);
                break;
            case 'EN CORTE':
                $lista = $this->deudoresTrait($clientes)->where('mensaje', 'EN CORTE');
                break;
            default:
                $lista = collect([]);
                break;
        }

        $sucursal = Sucursal::findOrFail($id_suc);
        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfClientes', compact('lista', 'sucursal', 'tipo'));

        return $pdf->stream('CLIENTES.pdf');
    }

    public function ingresos_egresos_total(Request $request)
    {
        $sucursales = Sucursal::all();

        $ingresos = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
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
            ->with('detalles')
            ->with('otros')
            ->get();

        $egresos = Gasto::whereBetween('FEC_GAS', [$request->fec_ini, $request->fec_fin])
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'gasto.ID_SUC')
            ->when($request, function ($query, $request) {
                if ($request->id_suc != 'TODOS') {
                    return $query->where('gasto.ID_SUC', $request->id_suc);
                }
            })
            ->orderBy('ID_GAS', 'ASC')
            ->get();

        return view('reporte.parcial.ingresos_egresos_total', compact('ingresos', 'egresos', 'request', 'sucursales'))->render();
    }

    public function mes_ingreso(Request $request)
    {
        return view('reporte.parcial.mes_ingreso', compact('request'));
    }

    public function informacion_pdf($id_cli)
    {
        $cliente = Cliente::where('ID_CLI', $id_cli)
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'cliente.ID_SUC')
            ->first();

        $pagos = 0;
        $deudas = [];
        $alerta = [];

        $ultimo_pago = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
            ->where('ID_CLI', $id_cli)
            ->where('MOT_PAG', 'MENSUALIDAD')
            ->where('EST_CON', '<>', 'CANCELADO')
            ->orderBy('ID_PAG', 'DESC')
            ->first();

        $cliente = Cliente::where('cliente.ID_CLI', $id_cli)
            ->join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->where('EST_CON', '<>', 'CANCELADO')
            ->first();

        $activo = Contrato::join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->with('convenio')
            ->where('ID_CLI', $id_cli)
            ->where('EST_CON', '<>', 'CANCELADO')
            ->first();

        if ($activo) {
            $alerta = $this->deudorTrait($cliente);
            $pagos = Pago::leftJoin('pago_detalle', 'pago_detalle.ID_PAG', '=', 'pago.ID_PAG')
                ->with('detalles')
                ->where('ID_CON', $activo->ID_CON)
                ->select('pago_detalle.ID_PD', 'pago.ID_PAG', 'pago.MOT_PAG', 'pago_detalle.ANIO_PD', 'pago_detalle.MES_PD', 'pago_detalle.ID_PD', 'pago_detalle.FTR_PD')
                ->orderBy('pago.ID_PAG', 'DESC')
                ->get();
            $deudas = $this->calculaDeudas($activo->ID_CON);
        }

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfInformacionActual', compact('cliente', 'activo', 'pagos', 'ultimo_pago', 'deudas', 'alerta'));

        return $pdf->stream('CLIENTE.pdf');
    }

    private function deudoresTrait($clientes)
    {
        $deudores = collect([]);
        foreach ($clientes as $cliente) {
            $deudor = $this->deudorTrait($cliente);
            if (count($deudor) != 0) {
                $deudores = $deudores->merge($deudor);
            }
        }

        return $deudores;
    }

    private function puntualesTrait($clientes)
    {
        $puntuales = collect([]);
        foreach ($clientes as $cliente) {
            $deudor = $this->deudorTrait($cliente);
            if (count($deudor) == 0) {
                $puntuales->push([
                    'id_cli' => $cliente->ID_CLI,
                    'nom_cli' => $cliente->NOM_CLI,
                    'ape_cli' => $cliente->APE_CLI,
                    'ci_cli' => $cliente->CI_CLI,
                    'dir_cli' => $cliente->DIR_CLI,
                    'cod_cli' => $cliente->COD_CLI,
                    'mensaje' => 'PUNTUAL',
                ]);
            }
        }

        return $puntuales;
    }

    public function create()
    {
        return redirect()->route('reporte.index');
    }

    public function show(string $id)
    {
        return redirect()->route('reporte.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('reporte.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('reporte.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('reporte.index');
    }
}
