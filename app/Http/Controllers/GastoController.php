<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Sucursal;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    public function index()
    {
        if (Auth::user()->ID_SUC == '') {
            $sucursales = Sucursal::all();
        } else {
            $sucursales = Sucursal::where('ID_SUC', Auth::user()->ID_SUC)->get();
        }

        return view('gasto.index', compact('sucursales'));
    }

    public function gastos($id_suc, $fecha)
    {
        $sucursal = Sucursal::findOrFail($id_suc);
        $gastos = Gasto::join('users', 'users.ID_USU', '=', 'gasto.ID_USU')
            ->where('gasto.ID_SUC', $id_suc)
            ->select('gasto.*', 'users.NOM_USU', 'users.PAT_USU', 'users.MAT_USU')
            ->where('FEC_GAS', $fecha)
            ->orderByDesc('ID_GAS')
            ->get();

        return view('gasto.parcial.gastos', compact('sucursal', 'gastos', 'fecha'))->render();
    }

    public function store(Request $request)
    {
        $monto = 0;
        if ($request->deci_gas == null) {
            $monto = $request->cant_gas;
        } else {
            $monto = $request->cant_gas.'.'.$request->deci_gas;
        }

        $gasto = new Gasto();
        $gasto->ID_USU = Auth::user()->ID_USU;
        $gasto->ID_SUC = $request->id_suc;
        $gasto->MOT_GAS = $request->mot_gas;
        $gasto->CANT_GAS = $monto;
        $gasto->FEC_GAS = Carbon::now()->format('Y-m-d');
        $gasto->HOR_GAS = Carbon::now()->format('H:i:s');
        $gasto->save();

        return redirect()->back()->with('exito', 'Gasto registrado exitosamente');
    }

    public function pdfGasto($id_gas)
    {
        $gasto = Gasto::join('sucursal', 'sucursal.ID_SUC', '=', 'gasto.ID_SUC')
            ->join('users', 'users.ID_USU', '=', 'gasto.ID_USU')
            ->where('ID_GAS', $id_gas)
            ->firstOrFail();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.gasto', compact('gasto'));

        return $pdf->stream('GASTO.pdf');
    }

    public function elimina(Request $request)
    {
        Gasto::where('ID_GAS', $request->id_gas)->delete();

        return response()->json('Gasto eliminado exitosamente');
    }

    public function create()
    {
        return redirect()->route('gasto.index');
    }

    public function show(string $id)
    {
        return redirect()->route('gasto.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('gasto.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('gasto.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('gasto.index');
    }
}
