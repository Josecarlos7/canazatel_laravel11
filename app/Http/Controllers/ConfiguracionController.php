<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $cnf = Configuracion::first();

        return view('configuracion.index', compact('cnf'));
    }

    public function store(Request $request)
    {
        $cnf = Configuracion::first();

        if (! $cnf) {
            return redirect()->back()->with('error', 'No existe un registro de configuracion inicial en la base de datos.');
        }

        $cnf->PRE_RECONEXION = $request->pre_reconexion;
        $cnf->PRE_REPARACION = $request->pre_reparacion;
        $cnf->PRE_TRASLADO_I = $request->pre_traslado_i;
        $cnf->PRE_TRASLADO_E = $request->pre_traslado_e;
        $cnf->PRE_CAMBIO_ONT = $request->pre_cambio_ont;
        $cnf->PRE_REPO_CABLE = $request->pre_repo_cable;
        $cnf->PRE_TRAS_INT_SERV = $request->pre_tras_int_serv;
        $cnf->PRE_TRAS_EXT_SERV = $request->pre_tras_ext_serv;
        $cnf->PRE_REP_GRTS = $request->pre_rep_grts;
        $cnf->PRE_REC_GRTS = $request->pre_rec_grts;
        $cnf->save();

        return redirect()->back()->with('exito', 'Configuracion guardada.');
    }

    public function create()
    {
        return redirect()->route('configuracion.index');
    }

    public function show(string $id)
    {
        return redirect()->route('configuracion.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('configuracion.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('configuracion.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('configuracion.index');
    }
}
