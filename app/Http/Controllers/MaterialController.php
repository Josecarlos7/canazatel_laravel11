<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialIngreso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $materiales = Material::all();

        return view('material.index', compact('materiales'));
    }

    public function store(Request $request)
    {
        $v = Material::validationStore($request);
        if ($v) {
            return redirect()->back()->with('error', $v)->withInput();
        }

        $material = new Material();
        $material->NOM_MAT = $request->nom_mat;
        $material->save();

        return redirect()->back()->with('exito', 'Material registrado exitosamente');
    }

    public function actualiza(Request $request)
    {
        $material = Material::findOrFail($request->id_mat);
        $material->NOM_MAT = $request->nom_mat;
        $material->save();

        return redirect()->back()->with('exito', 'Material editado exitosamente');
    }

    public function agregaStock(Request $request)
    {
        $material = Material::findOrFail($request->id_mat);
        $stockActual = (int) ($material->STK_MAT ?? 0);
        $cantidad = (int) $request->cnt_inv;
        $material->STK_MAT = $stockActual + $cantidad;
        $material->save();

        $mi = new MaterialIngreso();
        $mi->ID_USU = Auth::user()->ID_USU;
        $mi->CNT_MI = $cantidad;
        $mi->FEC_MI = Carbon::now()->format('Y-m-d');
        $mi->HOR_MI = Carbon::now()->format('H:i:s');
        $mi->save();

        return redirect()->back()->with('exito', 'Stock actualizado');
    }

    public function buscaMaterial($id_mat)
    {
        $material = Material::findOrFail($id_mat);

        return response()->json($material);
    }

    public function create()
    {
        return redirect()->route('material.index');
    }

    public function show(string $id)
    {
        return redirect()->route('material.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('material.index');
    }

    public function update(Request $request, string $id)
    {
        return $this->actualiza($request);
    }

    public function destroy(string $id)
    {
        return redirect()->route('material.index');
    }
}
