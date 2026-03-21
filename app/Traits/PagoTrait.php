<?php

namespace App\Traits;

use App\Models\Contrato;
use App\Models\DescuentoDias;
use App\Models\DiasGratis;
use App\Models\Pago;
use App\Models\PagoDetalle;
use App\Models\PagoOtro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait PagoTrait
{
    protected function fechaPrimeroMes(string $fecha): string
    {
        $mes = Carbon::parse($fecha)->format('m');
        $anio = Carbon::parse($fecha)->format('Y');

        return $anio.'-'.$mes.'-01';
    }

    protected function formatoFecha(string $fecha, int $diaCbr): string
    {
        $mes = Carbon::parse($fecha)->format('m');
        $anio = Carbon::parse($fecha)->format('Y');
        $diaPago = $anio.'-'.$mes.'-'.$diaCbr;

        $nuevaFecha = Carbon::parse($diaPago)->format('Y-m-d');
        if (Carbon::createFromFormat('Y-m-d', $nuevaFecha)->format('Y-m-d') !== $nuevaFecha) {
            $nuevaFecha = Carbon::parse($fecha)->addMonth()->startOfMonth()->format('Y-m-d');
        }

        return $nuevaFecha;
    }

    public function calculoPago($nroMeses, $idCon, $fechaSolicitud)
    {
        $ultimo = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
            ->where('ID_CON', $idCon)
            ->where('MOT_PAG', 'MENSUALIDAD')
            ->orderBy('pago_detalle.ID_PD', 'DESC')
            ->first();

        if ($ultimo) {
            $nuevaFecha = $this->fechaPrimeroMes($ultimo->ANIO_PD.'-'.$ultimo->NRO_MES.'-01');
            $fechaInicioConteo = Carbon::parse($nuevaFecha);
        } else {
            $nuevaFecha = $this->fechaPrimeroMes($fechaSolicitud);
            $fechaInicioConteo = Carbon::parse($nuevaFecha)->subMonth();
        }

        return $fechaInicioConteo;
    }

    public function pagoMensualidad($idCon, $numeroMeses, $mesesTolerancia)
    {
        $codigo = 1;
        $contrato = Contrato::where('ID_CON', $idCon)
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->first();

        $existe = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
            ->join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->where('sucursal.ID_SUC', $contrato->ID_SUC)
            ->orderBy('pago_detalle.COD_PD', 'DESC')
            ->first();
        if ($existe) {
            $codigo = $existe->COD_PD + 1;
        }

        $ultimo = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
            ->where('ID_CON', $idCon)
            ->where('MOT_PAG', 'MENSUALIDAD')
            ->orderBy('pago_detalle.ID_PD', 'DESC')
            ->first();

        if ($ultimo) {
            $nuevaFecha = $this->fechaPrimeroMes($ultimo->ANIO_PD.'-'.$ultimo->NRO_MES.'-01');
            $fechaInicioConteo = Carbon::parse($nuevaFecha);
        } else {
            $contrato = Contrato::where('ID_CON', $idCon)->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')->first();
            $nuevaFecha = $this->fechaPrimeroMes($contrato->FEC_SOL);
            $fechaInicioConteo = Carbon::parse($nuevaFecha)->subMonth();
        }

        $diasGratis = $this->calculaDiasgratis($numeroMeses);

        if ($contrato->EST_CON === 'BAJA FORZOSA') {
            $numeroMeses = $mesesTolerancia;
            $contrato->DEU_BF = 'NO';
            $contrato->save();
        }

        $pago = new Pago();
        $pago->ID_CON = $idCon;
        $pago->ID_USU = Auth::user()->ID_USU;
        $pago->ID_PLAN = $contrato->ID_PLAN;
        $pago->MOT_PAG = 'MENSUALIDAD';
        $pago->NRO_MESES = $numeroMeses;
        $pago->FEC_PAG = Carbon::now()->format('Y-m-d');
        $pago->HOR_PAG = Carbon::now()->format('H:i:s');
        $pago->DIAS_GRTS = $diasGratis;
        $pago->save();

        $proximaFecha = Carbon::now()->format('Y-m-d');

        for ($i = 0; $i < $numeroMeses; $i++) {
            $fechaInicioConteo = $fechaInicioConteo->addMonth();

            $detalle = new PagoDetalle();
            $detalle->ID_PAG = $pago->ID_PAG;
            $detalle->COD_PD = $codigo;
            $detalle->NRO_MES = $fechaInicioConteo->isoFormat('M');
            $detalle->MES_PD = strtoupper($fechaInicioConteo->isoFormat('MMMM'));
            $detalle->ANIO_PD = $fechaInicioConteo->format('Y');
            $detalle->PTS_XTR_PD = $contrato->PTS_XTR;
            $detalle->PRE_PTS_XTR_PD = $contrato->PRE_PTS_XTR;
            $detalle->PRE_MENS_PD = $contrato->PRE_MENS;

            $descuento = $this->descuento($idCon, $contrato->PRE_MENS);
            $totalPagar = ($contrato->PRE_MENS - $descuento) + ($contrato->PTS_XTR * $contrato->PRE_PTS_XTR);

            $descuentoDias = DescuentoDias::where('ID_CON', $contrato->ID_CON)
                ->where('MES_DD', $detalle->MES_PD)
                ->where('ANIO_DD', $detalle->ANIO_PD)
                ->first();
            $descuentoDiasTotal = 0;
            if ($descuentoDias) {
                $descuentoDiasTotal = $totalPagar - $descuentoDias->MONTO_DD;
            }

            $detalle->MONTO_DESC = $descuento;
            $detalle->DIAS_DSC = $descuentoDiasTotal;
            $detalle->MONTO_PD = $totalPagar - $descuentoDiasTotal;
            $detalle->FEC_PD = Carbon::now()->format('Y-m-d');
            $detalle->HOR_PD = Carbon::now()->format('H:i:s');

            if ($i === 0) {
                $pago->MES_INI = $this->formatoFecha($fechaInicioConteo->format('Y-m-d'), (int) $contrato->DIA_CBR);
                $pago->MES_FIN = Carbon::parse($this->formatoFecha($fechaInicioConteo->format('Y-m-d'), (int) $contrato->DIA_CBR))
                    ->addMonth()
                    ->format('Y-m-d');
            } elseif ($i === $numeroMeses - 1) {
                $pago->MES_FIN = Carbon::parse($this->formatoFecha($fechaInicioConteo->format('Y-m-d'), (int) $contrato->DIA_CBR))
                    ->addMonth()
                    ->format('Y-m-d');
            }

            $inicioFecha = Carbon::parse($this->formatoFecha($fechaInicioConteo->format('Y-m-d'), (int) $contrato->DIA_CBR))->format('Y-m-d');
            $proximaFecha = Carbon::parse($this->formatoFecha($fechaInicioConteo->format('Y-m-d'), (int) $contrato->DIA_CBR))->addMonth()->format('Y-m-d');

            $detalle->FEC_INI_PD = $inicioFecha;
            $detalle->FEC_FIN_PD = Carbon::parse($proximaFecha)->addDays($diasGratis)->format('Y-m-d');
            $detalle->save();
        }

        $pago->FEC_PROX = Carbon::parse($proximaFecha)->addDays($diasGratis)->format('Y-m-d');
        $pago->save();

        $contrato->DIA_CBR = Carbon::parse($proximaFecha)->addDays($diasGratis)->isoFormat('D');
        $contrato->save();

        return $pago;
    }

    public function descuento($idCon, $mensualidad)
    {
        $descuento = 0;
        $contrato = Contrato::where('ID_CON', $idCon)->with('convenio')->first();
        if ($contrato && count($contrato->convenio) !== 0) {
            $tipoConvenio = $contrato->convenio[0]->TIPO_CVN;
            $descuentoConvenio = $contrato->convenio[0]->DESC_CVN;
            if ($tipoConvenio === 'DESCUENTO') {
                $descuento = $mensualidad * ($descuentoConvenio / 100);
            } else {
                $descuento = $mensualidad;
            }
        }

        return $descuento;
    }

    public function calculaDiasgratis($nroMes)
    {
        $rangos = DiasGratis::orderBy('NRO_MESES', 'asc')->get();
        $diasGratis = 0;
        foreach ($rangos as $rango) {
            if ($nroMes >= $rango->NRO_MESES) {
                $diasGratis = $rango->NRO_DIAS;
            }
        }

        return $diasGratis;
    }

    public function pagoOtros($idCon, $otros, $monto)
    {
        $codigo = 1;

        $pago = new Pago();
        $pago->ID_CON = $idCon;
        $pago->ID_USU = Auth::user()->ID_USU;
        $pago->MOT_PAG = $otros;
        $pago->FEC_PAG = Carbon::now()->format('Y-m-d');
        $pago->HOR_PAG = Carbon::now()->format('H:i:s');
        $pago->save();

        $contrato = Contrato::where('ID_CON', $idCon)
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->first();

        $existe = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
            ->join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->orderBy('pago_detalle.COD_PD', 'DESC')
            ->where('sucursal.ID_SUC', $contrato->ID_SUC)
            ->first();

        if ($existe) {
            $codigo = $existe->COD_PD + 1;
        }

        $detalle = new PagoDetalle();
        $detalle->ID_PAG = $pago->ID_PAG;
        $detalle->COD_PD = $codigo;
        $detalle->MONTO_PD = $monto;
        $detalle->FEC_PD = Carbon::now()->format('Y-m-d');
        $detalle->HOR_PD = Carbon::now()->format('H:i:s');
        $detalle->save();

        return $pago;
    }

    public function pagoCompraMateriales($request)
    {
        $pago = new Pago();
        $pago->ID_CON = $request->id_con;
        $pago->ID_USU = Auth::user()->ID_USU;
        $pago->MOT_PAG = 'VENTA MATERIALES';
        $pago->FEC_PAG = Carbon::now()->format('Y-m-d');
        $pago->HOR_PAG = Carbon::now()->format('H:i:s');
        $pago->save();

        for ($i = 0; $i < count($request->input('monto_po')); $i++) {
            $otro = new PagoOtro();
            $otro->ID_PAG = $pago->ID_PAG;
            $otro->DET_PO = $request->input('det_po.'.$i);
            $otro->CANT_PO = $request->input('cant_po.'.$i);
            $otro->MONTO_PO = $request->input('monto_po.'.$i);
            $otro->save();
        }

        return $pago;
    }
}
