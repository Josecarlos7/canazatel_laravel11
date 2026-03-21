<?php

namespace App\Traits;

use App\Models\Contrato;
use App\Models\Pago;
use App\Models\PagoDetalle;
use App\Models\PagoOtro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait PagoInstalacionTrait
{
    public function pagoInstalacion($idCon, $request)
    {
        $codigo = 1;

        $contratoSucursal = Contrato::where('ID_CON', $idCon)
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->first();

        $existe = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
            ->join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->orderBy('pago_detalle.COD_PD', 'DESC')
            ->where('sucursal.ID_SUC', $contratoSucursal->ID_SUC)
            ->first();

        if ($existe) {
            $codigo = $existe->COD_PD + 1;
        }

        $contrato = Contrato::where('ID_CON', $idCon)->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')->first();

        if ($contrato->TIPO_PAGO === 'POST-PAGO') {
            $pago = new Pago();
            $pago->ID_CON = $idCon;
            $pago->ID_USU = Auth::user()->ID_USU;
            $pago->MOT_PAG = 'INSTALACION';
            $pago->FEC_PAG = Carbon::now()->format('Y-m-d');
            $pago->HOR_PAG = Carbon::now()->format('H:i:s');
            $pago->save();

            $detalle = new PagoDetalle();
            $detalle->ID_PAG = $pago->ID_PAG;
            $detalle->COD_PD = $codigo;
            $detalle->MONTO_PD = $contrato->PRE_INST;
            $detalle->FEC_PD = Carbon::now()->format('Y-m-d');
            $detalle->HOR_PD = Carbon::now()->format('H:i:s');
            $detalle->save();

            if ((int) $request->pts_xtr > 0) {
                $otro = new PagoOtro();
                $otro->ID_PAG = $pago->ID_PAG;
                $otro->DET_PO = 'PAGO '.$request->pts_xtr.' PUNTOS EXTRA EN INSTALACION';
                $otro->MONTO_PO = $request->pts_xtr * $contrato->PRE_PTS_INST_XTR;
                $otro->save();
            }
        }

        if ($contrato->TIPO_PAGO === 'PRE-PAGO' && (int) $request->pts_xtr > 0) {
            $pago = new Pago();
            $pago->ID_CON = $idCon;
            $pago->ID_USU = Auth::user()->ID_USU;
            $pago->MOT_PAG = 'INSTALACION';
            $pago->FEC_PAG = Carbon::now()->format('Y-m-d');
            $pago->HOR_PAG = Carbon::now()->format('H:i:s');
            $pago->save();

            $detalle = new PagoDetalle();
            $detalle->ID_PAG = $pago->ID_PAG;
            $detalle->COD_PD = $codigo;
            $detalle->MONTO_PD = 0;
            $detalle->FEC_PD = Carbon::now()->format('Y-m-d');
            $detalle->HOR_PD = Carbon::now()->format('H:i:s');
            $detalle->save();

            $otro = new PagoOtro();
            $otro->ID_PAG = $pago->ID_PAG;
            $otro->DET_PO = 'PAGO '.$request->pts_xtr.' PUNTOS EXTRA EN INSTALACION';
            $otro->MONTO_PO = $request->pts_xtr * $contrato->PRE_PTS_INST_XTR;
            $otro->save();
        }
    }
}
