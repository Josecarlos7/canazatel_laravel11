<?php

namespace App\Traits;

use App\Models\Contrato;
use App\Models\PagoDetalle;
use Carbon\Carbon;

trait DeudaTrait
{
    protected function formatoFechaDeuda(string $fecha, int $diaCbr): string
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

    public function calculaDeudas($idCon)
    {
        $contrato = Contrato::where('ID_CON', $idCon)
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->first();

        if (! $contrato) {
            return collect([]);
        }

        $fechaSolicitud = $contrato->FEC_SOL;

        $ultimo = PagoDetalle::join('pago', 'pago.ID_PAG', '=', 'pago_detalle.ID_PAG')
            ->where('ID_CON', $idCon)
            ->where('MOT_PAG', 'MENSUALIDAD')
            ->orderBy('pago_detalle.ID_PD', 'DESC')
            ->first();

        if ($ultimo) {
            $nuevaFecha = $this->formatoFechaDeuda($ultimo->ANIO_PD.'-'.$ultimo->NRO_MES.'-01', (int) $contrato->DIA_CBR);
            $fechaInicioConteo = Carbon::parse($nuevaFecha)->addMonth();
        } else {
            $nuevaFecha = $this->formatoFechaDeuda($fechaSolicitud, (int) $contrato->DIA_CBR);
            $fechaInicioConteo = Carbon::parse($nuevaFecha);
        }

        if ($contrato->EST_CON === 'BAJA FORZOSA' && $contrato->FEC_BF !== null) {
            $actual = Carbon::parse($contrato->FEC_BF)->addMonth()->format('Y-m-d');
        } else {
            $actual = Carbon::now()->addMonth()->format('Y-m-d');
        }

        $diferencia = $fechaInicioConteo->diffInMonths($actual);
        $mesesTolerancia = $this->meses_tolerancia($contrato->TIPO_PAGO);
        if ($diferencia > $mesesTolerancia) {
            $diferencia = $mesesTolerancia;
        }

        if ($contrato->EST_CON === 'BAJA FORZOSA' && $contrato->DEU_BF === 'NO') {
            $diferencia = 0;
        }

        $deudas = collect([]);
        if ($fechaInicioConteo < $actual) {
            for ($i = 0; $i < $diferencia; $i++) {
                $deudas->push([
                    'fecha' => $fechaInicioConteo->format('Y-m-d'),
                    'mes' => strtoupper($fechaInicioConteo->isoFormat('MMMM')),
                    'año' => $fechaInicioConteo->format('Y'),
                ]);

                $fechaInicioConteo = $fechaInicioConteo->addMonth();
            }
        }

        if (count($deudas) === 0) {
            return collect([]);
        }

        return $deudas->sortByDesc('fecha');
    }

    public function deudorTrait($cliente)
    {
        $deudor = collect([]);
        $fechaGenerada = $this->calculaDeudas($cliente->ID_CON);

        if (count($fechaGenerada) === 0 || ! $fechaGenerada->last() || ! isset($fechaGenerada->last()['fecha'])) {
            return $deudor;
        }

        if ($cliente->EST_CON === 'BAJA FORZOSA' && $cliente->FEC_BF !== null) {
            $actual = $cliente->FEC_BF;
        } else {
            $actual = Carbon::now()->format('Y-m-d');
        }

        $primeraFechaGenerada = Carbon::parse($fechaGenerada->last()['fecha']);
        $diasDeuda = $primeraFechaGenerada->diffInDays($actual);
        $tipoAlerta = $this->tipo_alerta($diasDeuda, $cliente->TIPO_PAGO);
        $mensaje = $this->mensaje($diasDeuda, $cliente->TIPO_PAGO);

        $deudor->push([
            'id_cli' => $cliente->ID_CLI,
            'id_con' => $cliente->ID_CON,
            'ultima_fecha' => $fechaGenerada->firstWhere('fecha'),
            'dias_deuda' => $diasDeuda,
            'nom_cli' => $cliente->NOM_CLI,
            'ape_cli' => $cliente->APE_CLI,
            'ci_cli' => $cliente->CI_CLI,
            'dir_cli' => $cliente->DIR_CLI,
            'cod_cli' => $cliente->COD_CLI,
            'tipo_pago' => $cliente->TIPO_PAGO,
            'alerta' => $tipoAlerta,
            'mensaje' => $mensaje,
        ]);

        return $deudor;
    }

    public function tipo_alerta($diasDeuda, $tipoPago)
    {
        if ($tipoPago === 'PRE-PAGO') {
            if ($diasDeuda <= 15) {
                return '';
            }
            if ($diasDeuda <= 30) {
                return 'warning';
            }

            return 'danger';
        }

        if ($tipoPago === 'POST-PAGO') {
            if ($diasDeuda <= 30) {
                return '';
            }
            if ($diasDeuda <= 60) {
                return 'warning';
            }

            return 'danger';
        }

        return '';
    }

    public function mensaje($diasDeuda, $tipoPago)
    {
        if ($tipoPago === 'PRE-PAGO') {
            return $diasDeuda > 30 ? 'EN CORTE' : '';
        }

        if ($tipoPago === 'POST-PAGO') {
            return $diasDeuda > 60 ? 'EN CORTE' : '';
        }

        return '';
    }

    public function meses_tolerancia($tipoPago)
    {
        if ($tipoPago === 'PRE-PAGO') {
            return 1;
        }

        if ($tipoPago === 'POST-PAGO') {
            return 2;
        }

        return 0;
    }
}
