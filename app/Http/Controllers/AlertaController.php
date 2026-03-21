<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Sucursal;
use App\Traits\DeudaTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertaController extends Controller
{
    use DeudaTrait;

    public function index()
    {
        if (Auth::user()->ID_SUC == '') {
            $sucursales = Sucursal::get();
        } else {
            $sucursales = Sucursal::where('ID_SUC', Auth::user()->ID_SUC)->get();
        }

        return view('alerta.index', compact('sucursales'));
    }

    public function deudores(Request $request)
    {
        $sucursal = Sucursal::find($request->id_suc);

        if ($request->estado === 'ASIGNADOS') {
            $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
                ->where('contrato.ID_SUC', $request->id_suc)
                ->where('contrato.EST_CON', '=', 'ASIGNADO')
                ->get();

            return view('alerta.parcial.asignados', compact('sucursal', 'clientes'))->render();
        }

        $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->where('contrato.ID_SUC', $request->id_suc)
            ->where('contrato.EST_CON', '<>', 'CANCELADO')
            ->where('contrato.ID_PLAN', $request->estado)
            ->get();

        $deudores = $this->deudoresTrait($clientes)->sortBy('dias_deuda', SORT_REGULAR, true);

        return view('alerta.parcial.deudores', compact('sucursal', 'deudores'))->render();
    }

    public function pdf_deudores($id_suc)
    {
        $sucursal = Sucursal::find($id_suc);
        $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->where('contrato.ID_SUC', $id_suc)
            ->where('contrato.EST_CON', '<>', 'CANCELADO')
            ->get();

        $deudores = $this->deudoresTrait($clientes)->sortBy('dias_deuda', SORT_REGULAR, true);

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.deudores', compact('sucursal', 'clientes', 'deudores'));

        return $pdf->stream('DEUDORES.pdf');
    }

    public function pdf_asignados($id_suc)
    {
        $sucursal = Sucursal::find($id_suc);
        $clientes = Cliente::join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->where('contrato.ID_SUC', $id_suc)
            ->where('contrato.EST_CON', '=', 'ASIGNADO')
            ->get();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.asignados', compact('sucursal', 'clientes'));

        return $pdf->stream('ASIGNADOS.pdf');
    }

    protected function deudoresTrait($clientes)
    {
        $deudores = collect([]);

        foreach ($clientes as $cliente) {
            $deudor = $this->deudorTrait($cliente);
            if (count($deudor) !== 0) {
                $deudores->push($deudor[0]);
            }
        }

        return $deudores;
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
