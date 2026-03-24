<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Sucursal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsignacionController extends Controller
{
    public function index()
    {
        if (Auth::user()->ID_SUC == '') {
            $sucursales = Sucursal::get();
        } else {
            $sucursales = Sucursal::where('ID_SUC', Auth::user()->ID_SUC)->get();
        }

        return view('asignacion.index', compact('sucursales'));
    }

    public function clientes_pendientes($id_suc)
    {
        $sucursal = Sucursal::find($id_suc);
        $pendientes = Contrato::join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->where('cliente.ID_SUC', $id_suc)
            ->where('contrato.EST_CON', 'PENDIENTE')
            ->select('contrato.*', 'cliente.NOM_CLI', 'cliente.APE_CLI', 'cliente.DIR_CLI', 'cliente.COD_CLI')
            ->get();
        
        $asignados = Contrato::join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->where('cliente.ID_SUC', $id_suc)
            ->where('contrato.EST_CON', 'ASIGNADO')
            ->select('contrato.*', 'cliente.NOM_CLI', 'cliente.APE_CLI', 'cliente.DIR_CLI', 'cliente.COD_CLI')
            ->get();
            
        return view('asignacion.parcial.clientes_pendientes', compact('sucursal', 'pendientes', 'asignados'))->render();
    }

    public function asigna(Request $request)
    {
        $ids = $request->input('ch', []);

        for ($i = 0; $i < count($ids); $i++) {
            $contrato = Contrato::find($request->input('ch.'.$i));
            if (! $contrato) {
                continue;
            }

            $contrato->EST_CON = 'ASIGNADO';
            $contrato->TXT_CON = $request->input('descripcion.'.$i);
            $contrato->save();
        }

        return response()->json($request->id_suc);
    }

    public function pdf_asignacion($id_con)
    {
        $contrato = Contrato::join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->where('ID_CON', $id_con)
            ->first();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfAsignacion', compact('contrato'));

        return $pdf->stream('ORDEN DE TRABAJO INSTALACION.pdf');
    }

    public function pdf_asignaciones($id_suc)
    {
        $contratos = Contrato::join('sucursal', 'sucursal.ID_SUC', '=', 'contrato.ID_SUC')
            ->join('cliente', 'cliente.ID_CLI', '=', 'contrato.ID_CLI')
            ->join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->where('contrato.ID_SUC', $id_suc)
            ->where('contrato.EST_CON', 'ASIGNADO')
            ->get();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.pdfAsignaciones', compact('contratos'));

        return $pdf->stream('ORDENES DE TRABAJO INSTALACION.pdf');
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        abort(404);
    }

    public function update(Request $request, string $id)
    {
        abort(404);
    }

    public function destroy(string $id)
    {
        abort(404);
    }
}
