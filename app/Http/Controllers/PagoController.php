<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Contrato;
use App\Models\DescuentoDias;
use App\Models\Pago;
use App\Models\PagoDetalle;
use App\Traits\DeudaTrait;
use App\Traits\PagoTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    use PagoTrait;
    use DeudaTrait;

    public function calcular($nroMeses, $idCon)
    {
        $contrato = Contrato::where('ID_CON', $idCon)
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->with('convenio')
            ->first();

        $fechaInicioConteo = $this->calculoPago($nroMeses, $idCon, $contrato->FEC_SOL);
        $diasGratis = $this->calculaDiasgratis($nroMeses);
        $mesesTolerancia = $this->meses_tolerancia($contrato->TIPO_PAGO);

        // Legacy partial expects snake_case variable names.
        $nro_meses = $nroMeses;
        $fecha_inicio_conteo = $fechaInicioConteo;
        $id_con = $idCon;
        $dias_gratis = $diasGratis;
        $meses_tolerancia = $mesesTolerancia;

        return view('cliente.parcial.calcular', compact('nro_meses', 'contrato', 'fecha_inicio_conteo', 'id_con', 'dias_gratis', 'meses_tolerancia'));
    }

    public function calcula_dias_cancela($idCon)
    {
        $cliente = Contrato::where('ID_CON', $idCon)
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->first();

        $alerta = $this->deudorTrait($cliente);

        return view('cliente.parcial.calcular_dias_cancela', compact('cliente', 'alerta'));
    }

    public function calcula_dias_descuenta($idCon)
    {
        $cliente = Contrato::where('ID_CON', $idCon)
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->first();

        return view('cliente.parcial.calcular_dias_descuenta', compact('cliente'));
    }

    public function calcula_puntos_extra($idCon)
    {
        $cliente = Contrato::where('ID_CON', $idCon)
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->first();

        return view('cliente.parcial.calcular_puntos_extra', compact('cliente'));
    }

    public function store(Request $request)
    {
        $contrato = Contrato::findOrFail($request->id_con);
        if ($contrato->EST_CON === 'BAJA FORZOSA') {
            return response()->json('El cliente esta en baja FORZOSA, no puede pagar ninguna mensualidad', 500);
        }

        $mesesTolerancia = $this->meses_tolerancia($contrato->TIPO_PAGO);
        $pago = $this->pagoMensualidad($request->id_con, $request->nro_mes, $mesesTolerancia);

        return response()->json($pago->ID_PAG);
    }

    public function otros(Request $request)
    {
        if (! $request->otros) {
            return response()->json('Debe seleccionar un pago', 500);
        }

        $cnf = Configuracion::first();
        $monto = 0;

        switch ($request->otros) {
            case 'RECONEXION':
                $monto = $cnf->PRE_RECONEXION;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'REPARACION':
                $monto = $cnf->PRE_REPARACION;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'TRASLADO INTERNO':
                $monto = $cnf->PRE_TRASLADO_I;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'TRASLADO EXTERNO':
                $monto = $cnf->PRE_TRASLADO_E;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'CAMBIO ONT':
                $monto = $cnf->PRE_CAMBIO_ONT;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'REPOSICION DE CABLE':
                $monto = $cnf->PRE_REPO_CABLE;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'TRASLADO INTERNO DE SERVICIO':
                $monto = $cnf->PRE_TRAS_INT_SERV;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'TRASLADO EXTERNO DE SERVICIO':
                $monto = $cnf->PRE_TRAS_EXT_SERV;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'REPARACION GRATIS':
                $monto = $cnf->PRE_REP_GRTS;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'RECONEXION GRATIS':
                $monto = $cnf->PRE_REC_GRTS;
                $pago = $this->pagoOtros($request->id_con, $request->otros, $monto);
                Contrato::where('ID_CON', $request->id_con)->update(['EST_CON' => 'PENDIENTE', 'TXT_CON' => $request->otros]);
                break;
            case 'DIAS CANCELA':
                $otros = 'PAGO POR: '.$request->dias.' DIAS DE USO DEL SERVICIO';
                $monto = $request->monto;
                $pago = $this->pagoOtros($request->id_con, $otros, $monto);
                $contrato = Contrato::where('ID_CON', $request->id_con)->first();
                $contrato->FEC_FIN = Carbon::now()->format('Y-m-d');
                $contrato->HOR_FIN = Carbon::now()->format('H:i:s');
                $contrato->EST_CON = 'CANCELADO';
                $contrato->save();
                break;
            case 'DESCUENTO DIAS':
                if ($request->dias < 1) {
                    return response()->json('Los dias no pueden ser menor a 1', 500);
                }

                $contrato = Contrato::findOrFail($request->id_con);
                $deudas = $this->calculaDeudas($request->id_con);
                if (count($deudas) === 0) {
                    return response()->json('El cliente no tiene meses con deuda', 500);
                }

                $descuentoExiste = DescuentoDias::where('ID_CON', $request->id_con)
                    ->where('MES_DD', $deudas[0]['mes'])
                    ->where('ANIO_DD', $deudas[0]['año'])
                    ->first();

                if ($descuentoExiste) {
                    return response()->json('Ya existe un registro de "Descuento por Dias", debe pagar al menos una mensualidad para poder registrar otro "Descuento por Dias"', 500);
                }

                $otros = 'DESCUENTO POR '.$request->dias.' DIAS SIN SERVICIO';
                $monto = $request->monto;
                $pago = $this->pagoOtros($request->id_con, $otros, $monto);

                $descuento = new DescuentoDias();
                $descuento->ID_CLI = $contrato->ID_CLI;
                $descuento->ID_CON = $request->id_con;
                $descuento->MES_DD = $deudas[0]['mes'];
                $descuento->ANIO_DD = $deudas[0]['año'];
                $descuento->MONTO_DD = $monto;
                $descuento->DIAS_DD = $request->dias;
                $descuento->FEC_DD = $deudas[0]['fecha'];
                $descuento->save();
                break;
            case 'PUNTOS EXTRA':
                if ($request->puntos == 0 || $request->puntos === null) {
                    return response()->json('Ingrese datos validos', 500);
                }

                $otros = 'INSTALACION DE '.$request->puntos.' PUNTO(S) EXTRA';
                $monto = $request->monto;
                $pago = $this->pagoOtros($request->id_con, $otros, $monto);

                $contrato = Contrato::findOrFail($request->id_con);
                $contrato->EST_CON = 'PENDIENTE';
                $contrato->TXT_CON = $otros;
                $contrato->PTS_XTR = $contrato->PTS_XTR + $request->puntos;
                $contrato->save();
                break;
            case 'VENTA MATERIALES':
                if ($request->input('monto_po') === null) {
                    return response()->json('No ingreso ninguna fila con monto', 500);
                }

                $pago = $this->pagoCompraMateriales($request);
                break;
            default:
                return response()->json('Pago no soportado', 500);
        }

        return response()->json($pago->ID_PAG);
    }

    public function elimina(Request $request)
    {
        PagoDetalle::where('ID_PD', $request->id_pd)->delete();

        return response()->json('Pago eliminado exitosamente');
    }

    public function pdfPago($idPag)
    {
        $pago = Pago::findOrFail($idPag);
        $contrato = Contrato::join('pago', 'pago.ID_CON', '=', 'contrato.ID_CON')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->where('ID_PAG', $idPag)
            ->first();

        if ($pago->MOT_PAG === 'VENTA MATERIALES' || $pago->MOT_PAG === 'COMPRA MATERIALES') {
            $pago = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
                ->where('pago.ID_PAG', $idPag)
                ->with('otros')
                ->first();

            $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfReciboCompraMateriales', compact('pago', 'contrato'));
        } else {
            $pagos = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
                ->join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
                ->where('pago.ID_PAG', $idPag)
                ->get();

            $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfLote', compact('pagos', 'contrato'));
        }

        return $pdf->stream('PAGOS REALIZADOS.pdf');
    }

    public function pdfRecibo($idPag)
    {
        $pago = Pago::findOrFail($idPag);

        $contrato = Contrato::join('pago', 'pago.ID_CON', '=', 'contrato.ID_CON')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->where('contrato.ID_CON', $pago->ID_CON)
            ->first();

        if ($pago->MOT_PAG === 'VENTA MATERIALES' || $pago->MOT_PAG === 'COMPRA MATERIALES') {
            $pago = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
                ->where('pago.ID_PAG', $idPag)
                ->with('otros')
                ->first();

            $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfReciboCompraMateriales', compact('pago', 'contrato'));
        } else {
            $pago = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
                ->join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
                ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
                ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
                ->where('pago.ID_PAG', $idPag)
                ->first();

            $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfRecibo', compact('pago', 'contrato'));
        }

        return $pdf->stream('RECIBO.pdf');
    }

    public function pdfMensualidad($idPd)
    {
        $contrato = Contrato::join('pago', 'pago.ID_CON', '=', 'contrato.ID_CON')
            ->join('pago_detalle', 'pago_detalle.ID_PAG', '=', 'pago.ID_PAG')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->where('pago_detalle.ID_PD', $idPd)
            ->first();

        $pago = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
            ->join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
            ->where('pago_detalle.ID_PD', $idPd)
            ->first();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfRecibo', compact('pago', 'contrato'));

        return $pdf->stream('RECIBO MES.pdf');
    }

    public function pdfReciboInstalacion($idPag)
    {
        $pago = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('users', 'users.ID_USU', '=', 'pago.ID_USU')
            ->where('pago.ID_PAG', $idPag)
            ->with('detalles')
            ->with('otros')
            ->first();

        $contrato = Contrato::join('pago', 'pago.ID_CON', '=', 'contrato.ID_CON')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->where('contrato.ID_CON', $pago->ID_CON)
            ->first();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfReciboInstalacion', compact('pago', 'contrato'));

        return $pdf->stream('RECIBO INSTALACION.pdf');
    }
}
