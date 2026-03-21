<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Reclamo;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReclamoController extends Controller
{
    public function index()
    {
        $idSucursalUsuario = Auth::user()->ID_SUC ?? null;

        if (empty($idSucursalUsuario)) {
            $sucursales = Sucursal::orderBy('NOM_SUC', 'ASC')->get();
        } else {
            $sucursales = Sucursal::where('ID_SUC', $idSucursalUsuario)->orderBy('NOM_SUC', 'ASC')->get();
        }

        return view('web.reclamo.index', compact('sucursales'));
    }

    public function reclamos($id_suc)
    {
        $pendientes = Reclamo::where('reclamo.ID_SUC', $id_suc)
            ->join('contrato', 'contrato.ID_CON', '=', 'reclamo.ID_CON')
            ->join('cliente', 'cliente.ID_CLI', '=', 'reclamo.ID_CLI')
            ->where('EST_REC', 'PENDIENTE')
            ->get();

        $atendidos = Reclamo::where('reclamo.ID_SUC', $id_suc)
            ->join('contrato', 'contrato.ID_CON', '=', 'reclamo.ID_CON')
            ->join('cliente', 'cliente.ID_CLI', '=', 'reclamo.ID_CLI')
            ->where('EST_REC', 'ATENDIDO')
            ->get();

        return view('web.reclamo.parcial.reclamos', compact('pendientes', 'atendidos', 'id_suc'))->render();
    }

    public function store(Request $request)
    {
        $cliente = Cliente::where('CI_CLI', $request->ci_cli)->first();
        if (! $cliente) {
            return response()->json('USTED NO SE ENCUENTRA REGISTRADO EN CANAZATEL', 500);
        }

        $contrato = Contrato::where('contrato.ID_CLI', $cliente->ID_CLI)
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->where('EST_CON', '<>', 'CANCELADO')
            ->first();

        if (! $contrato) {
            return response()->json('NO TIENE NINGUN CONTRATO ACTIVO', 500);
        }

        $reclamo = new Reclamo();
        $reclamo->ID_SUC = $contrato->ID_SUC;
        $reclamo->ID_CLI = $contrato->ID_CLI;
        $reclamo->ID_CON = $contrato->ID_CON;
        $reclamo->REC_REC = $request->rec_rec;
        $reclamo->FEC_REC = Carbon::now()->format('Y-m-d');
        $reclamo->HOR_REC = Carbon::now()->format('H:i:s');
        $reclamo->save();

        return response()->json('Reclamo enviado');
    }

    public function atender(Request $request)
    {
        $reclamo = Reclamo::findOrFail($request->id_rec);
        $reclamo->EST_REC = 'ATENDIDO';
        $reclamo->save();

        return response()->json(true);
    }
}
