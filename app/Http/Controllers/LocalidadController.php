<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function index()
    {
        $localidades = Localidad::all();

        return view('localidad.index', compact('localidades'));
    }

    public function store(Request $request)
    {
        $v = Localidad::validationStore($request);
        if ($v) {
            return redirect()->back()->with('error', $v)->withInput();
        }

        $localidad = new Localidad();
        $localidad->NOM_LOC = $request->nom_loc;
        $localidad->save();

        return redirect()->back()->with('exito', 'Localidad registrada exitosamente');
    }

    public function update(Request $request)
    {
        $localidad = Localidad::findOrFail($request->id_loc);
        $localidad->NOM_LOC = $request->nom_loc;
        $localidad->save();

        return redirect()->back()->with('exito', 'Localidad actualizada');
    }

    public function elimina(Request $request)
    {
        $existe = Sucursal::where('ID_LOC', $request->id_loc)->get();
        if (count($existe) !== 0) {
            $mensaje = 'No puede eliminar esta localidad porque se encuentra relacionada con las siguientes sucursales: ';
            foreach ($existe as $sucursal) {
                $mensaje .= $sucursal->NOM_SUC.', ';
            }

            return redirect()->back()->with('error', rtrim($mensaje, ', '));
        }

        Localidad::where('ID_LOC', $request->id_loc)->delete();

        return redirect()->back()->with('exito', 'Localidad eliminada');
    }

    public function create()
    {
        return redirect()->route('localidad.index');
    }

    public function show(string $id)
    {
        return redirect()->route('localidad.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('localidad.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('localidad.index');
    }
}
