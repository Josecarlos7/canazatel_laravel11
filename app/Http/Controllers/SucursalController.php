<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Plan;
use App\Models\Sucursal;
use App\Models\SucursalPlan;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::with('planes')
            ->join('localidad', 'localidad.ID_LOC', '=', 'sucursal.ID_LOC')
            ->select('sucursal.*', 'localidad.NOM_LOC')
            ->get();

        return view('sucursal.index', compact('sucursales'));
    }

    public function nuevo()
    {
        $planes = Plan::all();
        $localidades = Localidad::all();

        return view('sucursal.nuevo', compact('planes', 'localidades'));
    }

    public function edita($id_suc)
    {
        $sucursal = Sucursal::where('ID_SUC', $id_suc)
            ->with('planes')
            ->join('localidad', 'localidad.ID_LOC', '=', 'sucursal.ID_LOC')
            ->select('sucursal.*', 'localidad.NOM_LOC')
            ->firstOrFail();

        $planes = Plan::all();
        $localidades = Localidad::all();

        return view('sucursal.edita', compact('sucursal', 'planes', 'localidades'));
    }

    public function store(Request $request)
    {
        $v = Sucursal::validationStore($request);
        if ($v) {
            return redirect()->back()->with('error', $v)->withInput();
        }

        $sucursal = new Sucursal();
        $sucursal->ID_LOC = $request->id_loc;
        $sucursal->NOM_SUC = $request->nom_suc;
        $sucursal->ABR_SUC = $request->abr_suc;
        $sucursal->DIR_SUC = $request->dir_suc;
        $sucursal->LAT_SUC = $request->lat_suc;
        $sucursal->LNG_SUC = $request->lng_suc;
        $sucursal->save();

        if (isset($request->id_plan)) {
            for ($i = 0; $i < count($request->input('id_plan')); $i++) {
                $sp = new SucursalPlan();
                $sp->ID_SUC = $sucursal->ID_SUC;
                $sp->ID_PLAN = $request->input('id_plan.'.$i);
                $sp->save();
            }
        }

        return redirect('/sucursal')->with('exito', 'Sucursal creada exitosamente');
    }

    public function update(Request $request)
    {
        $sucursal = Sucursal::findOrFail($request->id_suc);
        $sucursal->ID_LOC = $request->id_loc;
        $sucursal->NOM_SUC = $request->nom_suc;
        $sucursal->ABR_SUC = $request->abr_suc;
        $sucursal->DIR_SUC = $request->dir_suc;
        $sucursal->LAT_SUC = $request->lat_suc;
        $sucursal->LNG_SUC = $request->lng_suc;
        $sucursal->save();

        SucursalPlan::where('ID_SUC', $request->id_suc)->delete();
        if (isset($request->id_plan)) {
            for ($i = 0; $i < count($request->input('id_plan')); $i++) {
                $sp = new SucursalPlan();
                $sp->ID_SUC = $sucursal->ID_SUC;
                $sp->ID_PLAN = $request->input('id_plan.'.$i);
                $sp->save();
            }
        }

        return redirect('/sucursal')->with('exito', 'Sucursal actualizada');
    }

    public function create()
    {
        return redirect()->route('sucursal.index');
    }

    public function show(string $id)
    {
        return redirect()->route('sucursal.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('sucursal.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('sucursal.index');
    }
}
