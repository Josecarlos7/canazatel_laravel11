<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Solicitud;
use App\Models\SolicitudMaterial;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    public function index()
    {
        $idSucursalUsuario = Auth::user()->ID_SUC;
        if (empty($idSucursalUsuario)) {
            $sucursales = Sucursal::all();
        } else {
            $sucursales = Sucursal::where('ID_SUC', $idSucursalUsuario)->get();
        }

        $materiales = Material::all();

        return view('solicitud.index', compact('sucursales', 'materiales'));
    }

    public function solicitudes($id_suc)
    {
        $sucursal = Sucursal::findOrFail($id_suc);
        $solicitudes = Solicitud::with('detalles')
            ->where('ID_SUC', $id_suc)
            ->orderByDesc('ID_SOL')
            ->get();

        $idsUsuarios = collect();
        foreach ($solicitudes as $solicitud) {
            $idsUsuarios->push($solicitud->ID_USU, $solicitud->ID_USU_RSP, $solicitud->ID_USU_REC);
        }

        $usuarios = User::whereIn('ID_USU', $idsUsuarios->filter()->unique()->values())->get()->keyBy('ID_USU');

        return view('solicitud.parcial.solicitudes', compact('sucursal', 'solicitudes', 'usuarios'))->render();
    }

    public function store(Request $request)
    {
        $solicitud = new Solicitud();
        $solicitud->ID_SUC = $request->id_suc;
        $solicitud->ID_USU = Auth::user()->ID_USU;
        $solicitud->FEC_SOL = Carbon::now()->format('Y-m-d');
        $solicitud->HOR_SOL = Carbon::now()->format('H:i:s');
        $solicitud->DES_SOL = $request->des_sol;
        $solicitud->EST_SOL = 'PENDIENTE';
        $solicitud->save();

        $idMateriales = $request->input('id_mat', []);
        $cantidades = $request->input('cant_sm', []);

        foreach ($idMateriales as $index => $idMaterial) {
            $cantidad = (int) ($cantidades[$index] ?? 0);
            if ($cantidad <= 0) {
                continue;
            }

            $sm = new SolicitudMaterial();
            $sm->ID_SOL = $solicitud->ID_SOL;
            $sm->ID_MAT = $idMaterial;
            $sm->CANT_SM = $cantidad;
            $sm->save();

            $material = Material::find($idMaterial);
            if ($material) {
                $material->STK_MAT = (int) ($material->STK_MAT ?? 0) - $cantidad;
                $material->save();
            }
        }

        return redirect()->back()->with('exito', 'Solicitud registrada');
    }

    public function atender($id_sol)
    {
        $solicitud = Solicitud::with('detalles')
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'solicitud.ID_SUC')
            ->join('users', 'users.ID_USU', '=', 'solicitud.ID_USU')
            ->where('ID_SOL', $id_sol)
            ->firstOrFail();

        return view('solicitud.atender', compact('solicitud'));
    }

    public function enviar(Request $request)
    {
        $solicitud = Solicitud::findOrFail($request->id_sol);
        SolicitudMaterial::where('ID_SOL', $request->id_sol)->delete();

        $solicitud->RESP_SOL = $request->resp_sol;
        $solicitud->ID_USU_RSP = Auth::user()->ID_USU;
        $solicitud->FEC_RESP = Carbon::now()->format('Y-m-d');
        $solicitud->HOR_RESP = Carbon::now()->format('H:i:s');
        $solicitud->EST_SOL = $request->est_sol;
        $solicitud->save();

        $idMateriales = $request->input('id_mat', []);
        $cantidades = $request->input('cant_sm', []);

        foreach ($idMateriales as $index => $idMaterial) {
            $cantidad = (int) ($cantidades[$index] ?? 0);
            if ($cantidad <= 0) {
                continue;
            }

            $sm = new SolicitudMaterial();
            $sm->ID_SOL = $solicitud->ID_SOL;
            $sm->ID_MAT = $idMaterial;
            $sm->CANT_SM = $cantidad;
            $sm->save();
        }

        return redirect('/solicitud')->with('exito', 'Solicitud enviada');
    }

    public function recepcion(Request $request)
    {
        $solicitud = Solicitud::findOrFail($request->id_sol);
        $solicitud->RESP_REC = $request->resp_rec;
        $solicitud->ID_USU_REC = Auth::user()->ID_USU;
        $solicitud->FEC_REC = Carbon::now()->format('Y-m-d');
        $solicitud->HOR_REC = Carbon::now()->format('H:i:s');
        $solicitud->EST_SOL = 'RECIBIDO';
        $solicitud->save();

        return redirect()->back()->with('exito', 'Solicitud recibida');
    }

    public function elimina(Request $request)
    {
        $detalles = SolicitudMaterial::where('ID_SOL', $request->id_sol)->get();
        foreach ($detalles as $detalle) {
            $material = Material::find($detalle->ID_MAT);
            if ($material) {
                $material->STK_MAT = (int) ($material->STK_MAT ?? 0) + (int) $detalle->CANT_SM;
                $material->save();
            }
        }

        Solicitud::where('ID_SOL', $request->id_sol)->where('EST_SOL', 'PENDIENTE')->delete();

        return redirect()->back()->with('exito', 'Solicitud eliminada');
    }

    public function create()
    {
        return redirect()->route('solicitud.index');
    }

    public function show(string $id)
    {
        return redirect()->route('solicitud.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('solicitud.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('solicitud.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('solicitud.index');
    }
}
