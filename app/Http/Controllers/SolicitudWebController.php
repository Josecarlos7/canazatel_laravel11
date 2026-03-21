<?php

namespace App\Http\Controllers;

use App\Models\SolicitudWeb;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudWebController extends Controller
{
    public function index()
    {
        $idSucursalUsuario = Auth::user()->ID_SUC ?? null;

        if (empty($idSucursalUsuario)) {
            $sucursales = Sucursal::orderBy('NOM_SUC', 'ASC')->get();
        } else {
            $sucursales = Sucursal::where('ID_SUC', $idSucursalUsuario)->orderBy('NOM_SUC', 'ASC')->get();
        }

        return view('web.solicitud.index', compact('sucursales'));
    }

    public function solicitudes($id_suc)
    {
        $sucursal = Sucursal::findOrFail($id_suc);
        $solicitudes = SolicitudWeb::where('ID_SUC', $id_suc)->orderBy('ID_SW', 'DESC')->get();

        return view('web.solicitud.parcial.solicitudes', compact('sucursal', 'solicitudes'))->render();
    }

    public function store(Request $request)
    {
        if (! $request->lat_cli) {
            return response()->json('Debe escoger una ubicacion en el mapa por favor', 500);
        }

        $solicitud = new SolicitudWeb();
        $solicitud->ID_SUC = $request->id_suc;
        $solicitud->NOM_SW = $request->nom_cli;
        $solicitud->APE_SW = $request->ape_cli;
        $solicitud->CI_SW = $request->ci_cli;
        $solicitud->TEL_SW = $request->tel_cli;
        $solicitud->CEL_SW = $request->cel_cli;
        $solicitud->DIR_SW = $request->dir_cli;
        $solicitud->DES_SW = $request->des_dir;
        $solicitud->FEC_SW = Carbon::now()->format('Y-m-d');
        $solicitud->HOR_SW = Carbon::now()->format('H:i:s');
        $solicitud->LAT_SW = $request->lat_cli;
        $solicitud->LNG_SW = $request->lng_cli;
        $solicitud->save();

        return response()->json(true);
    }
}
