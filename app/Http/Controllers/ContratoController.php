<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Convenio;
use App\Models\Contrato;
use App\Traits\DeudaTrait;
use App\Traits\PagoInstalacionTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    use PagoInstalacionTrait;
    use DeudaTrait;

    public function store(Request $request)
    {
        if ($request->fec_sol < '2008-06-15') {
            return response()->json('La fecha no puede ser menor a: 2008-06-15', 500);
        }
        if ((int) $request->pts_xtr < 0) {
            return response()->json('La cantidad de puntos extra no puede ser menor a cero', 500);
        }
        if ($request->fec_sol > Carbon::now()->format('Y-m-d')) {
            return response()->json('La fecha de solicitud no puede ser mayor a la fecha actual', 500);
        }

        $existe = Contrato::where('ID_CLI', $request->id_cli)
            ->where('EST_CON', '<>', 'CANCELADO')
            ->first();

        if ($existe) {
            return view('cliente.parcial.respuesta_nuevo', compact('existe'));
        }

        $cliente = Cliente::findOrFail($request->id_cli);
        $numero = 1;
        $ultimo = Contrato::where('ID_SUC', $cliente->ID_SUC)->orderByDesc('ID_CON')->first();
        if ($ultimo) {
            $numero = ((int) $ultimo->COD_CON) + 1;
        }

        $cliente->EST_CLI = 'ACTIVO';
        $cliente->save();

        $contrato = new Contrato();
        $contrato->ID_CLI = $request->id_cli;
        $contrato->ID_SUC = $cliente->ID_SUC;
        $contrato->ID_PLAN = $request->id_plan;
        $contrato->ID_USU_ACT = auth()->user()->ID_USU;
        $contrato->COD_CON = $numero;
        $contrato->TIPO_PAGO = $request->tipo_pago;
        $contrato->FEC_SOL = $request->fec_sol;
        $contrato->HOR_SOL = Carbon::now()->format('H:i:s');
        $contrato->DIA_CBR = Carbon::parse($request->fec_sol)->isoFormat('D');
        $contrato->PTS_XTR = $request->pts_xtr;
        $contrato->EST_CON = 'PENDIENTE';
        $contrato->TXT_CON = 'INSTALACION NUEVA PARA '.(((int) $contrato->PTS_XTR) + 1).' PUNTO(S)';
        $contrato->save();

        if ($request->convenio === 'SI') {
            $convenio = new Convenio();
            $convenio->ID_CON = $contrato->ID_CON;
            $convenio->TIPO_CVN = $request->tipo_cvn;
            $convenio->DESC_CVN = $request->desc_cvn ?: 0;
            $convenio->save();
        }

        if (Contrato::where('ID_CLI', $request->id_cli)->where('ID_CON', '<>', $contrato->ID_CON)->count() === 0) {
            $this->pagoInstalacion($contrato->ID_CON, $request);
        }

        $existe = null;

        return view('cliente.parcial.respuesta_nuevo', compact('existe'));
    }

    public function actualiza(Request $request)
    {
        $contrato = Contrato::findOrFail($request->id_con);

        if ($request->fec_sol > Carbon::now()->format('Y-m-d')) {
            return response()->json('La fecha de solicitud no puede ser mayor que la fecha actual', 500);
        }

        if ($contrato->EST_CON === 'ACTIVO') {
            if ($request->fec_ini > Carbon::now()->format('Y-m-d')) {
                return response()->json('La fecha de activacion no puede ser mayor que la fecha actual', 500);
            }
            if ($request->fec_ini < $request->fec_sol) {
                return response()->json('La fecha de activacion no puede ser menor a la fecha de la solicitud', 500);
            }
            $contrato->FEC_INI = $request->fec_ini;
        }

        $contrato->ID_PLAN = $request->id_plan;
        $contrato->TIPO_PAGO = $request->tipo_pago;
        $contrato->FEC_SOL = $request->fec_sol;
        $contrato->DIA_CBR = Carbon::parse($request->fec_sol)->isoFormat('D');
        $contrato->PTS_XTR = $request->pts_xtr;
        $contrato->save();

        if ($request->convenio === 'SI') {
            $convenio = $request->id_cvn ? Convenio::find($request->id_cvn) : null;
            if (! $convenio) {
                $convenio = new Convenio();
            }
            $convenio->ID_CON = $contrato->ID_CON;
            $convenio->TIPO_CVN = $request->tipo_cvn;
            $convenio->DESC_CVN = $request->desc_cvn ?: 0;
            $convenio->save();
        }

        return response()->json('Contrato editado');
    }

    public function activa(Request $request)
    {
        $contrato = Contrato::findOrFail($request->id_con);

        if ($request->fec_ini > Carbon::now()->format('Y-m-d')) {
            return response()->json('La fecha no puede ser mayor que la fecha actual', 500);
        }
        if ($request->fec_ini < $contrato->FEC_SOL) {
            return response()->json('La fecha no puede ser menor a la fecha de la solicitud', 500);
        }

        $contrato->FEC_INI = $request->fec_ini;
        $contrato->HOR_INI = Carbon::now()->format('H:i:s');
        $contrato->EST_CON = 'ACTIVO';
        $contrato->save();

        return response()->json('El contrato se activo exitosamente');
    }

    public function baja(Request $request)
    {
        $contrato = Contrato::findOrFail($request->id_con);
        $deudas = $this->calculaDeudas($contrato->ID_CON);

        if (count($deudas) === 0) {
            $contrato->FEC_FIN = Carbon::now()->format('Y-m-d');
            $contrato->HOR_FIN = Carbon::now()->format('H:i:s');
            $contrato->EST_CON = 'CANCELADO';
            $contrato->save();
        }

        return view('cliente.parcial.respuesta_baja', compact('deudas'));
    }

    public function bajaForzosa(Request $request)
    {
        $contrato = Contrato::findOrFail($request->id_con);
        $contrato->EST_CON = 'BAJA FORZOSA';
        $contrato->DEU_BF = 'SI';
        $contrato->FEC_BF = Carbon::now()->format('Y-m-d');
        $contrato->save();

        return response('<div class="col-md-12 alert alert-success text-center"><h4><i class="fa fa-check-circle fa-2x"></i><br>BAJA FORZOSA EXITOSA</h4></div>');
    }

    public function recoge(Request $request)
    {
        $contrato = Contrato::findOrFail($request->id_con);
        $estado = $contrato->RCG_CON === 'SI' ? 'NO' : 'SI';
        $contrato->RCG_CON = $estado;
        $contrato->save();

        return response()->json($estado);
    }

    public function pdfTvContrato($id_con)
    {
        $contrato = Contrato::join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('localidad', 'localidad.ID_LOC', '=', 'sucursal.ID_LOC')
            ->where('ID_CON', $id_con)
            ->first();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.ContratoTv', compact('contrato'));

        return $pdf->stream('CONTRATO TV.pdf');
    }

    public function pdfWifiContrato($id_con)
    {
        $contrato = Contrato::join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('localidad', 'localidad.ID_LOC', '=', 'sucursal.ID_LOC')
            ->where('ID_CON', $id_con)
            ->first();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.ContratoWifi', compact('contrato'));

        return $pdf->stream('CONTRATO WIFI.pdf');
    }

    public function index()
    {
        return redirect()->route('cliente.index');
    }

    public function create()
    {
        return redirect()->route('cliente.index');
    }

    public function show(string $id)
    {
        return redirect()->route('cliente.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('cliente.index');
    }

    public function update(Request $request, string $id)
    {
        return $this->actualiza($request);
    }

    public function destroy(string $id)
    {
        return redirect()->route('cliente.index');
    }
}
