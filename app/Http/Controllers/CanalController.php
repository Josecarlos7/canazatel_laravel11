<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CanalController extends Controller
{
    public function index()
    {
        $canales = Canal::all();

        return view('canal.index', compact('canales'));
    }

    public function store(Request $request)
    {
        $v = Canal::validationStore($request);
        if ($v) {
            return redirect()->back()->with('error', $v)->withInput();
        }

        $canal = new Canal();
        $canal->NOM_CAN = $request->nom_can;

        if ($request->img_can) {
            $imagen = $request->file('img_can');
            $extension = $imagen->extension();
            $direccion = $imagen->storeAs('img/IMG_CANALES', 'CAN-'.Carbon::now()->format('Y-m-d_H-i-s').'.'.$extension, 'public');
            $canal->IMG_CAN = $direccion;
        }

        $canal->EMP_CAN = $request->emp_can;
        $canal->NAC_CAN = $request->nac_can;
        $canal->save();

        return redirect()->back()->with('exito', 'Canal registrado exitosamente');
    }

    public function actualiza(Request $request)
    {
        $canal = Canal::findOrFail($request->id_can);
        $canal->NOM_CAN = $request->nom_can;

        if ($request->img_can) {
            $imagen = $request->file('img_can');
            $extension = $imagen->extension();
            $direccion = $imagen->storeAs('img/IMG_CANALES', 'CAN-'.Carbon::now()->format('Y-m-d_H-i-s').'.'.$extension, 'public');
            $canal->IMG_CAN = $direccion;
        }

        $canal->EMP_CAN = $request->emp_can;
        $canal->NAC_CAN = $request->nac_can;
        $canal->save();

        return redirect()->back()->with('exito', 'Canal editado exitosamente');
    }

    public function create()
    {
        return redirect()->route('canal.index');
    }

    public function show(string $id)
    {
        return redirect()->route('canal.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('canal.index');
    }

    public function update(Request $request, string $id)
    {
        return $this->actualiza($request);
    }

    public function destroy(string $id)
    {
        return redirect()->route('canal.index');
    }
}
