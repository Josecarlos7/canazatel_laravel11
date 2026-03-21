<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Contrato;
use App\Models\File;
use App\Models\Pago;
use App\Models\PagoDetalle;
use App\Models\SolicitudWeb;
use App\Models\Sucursal;
use App\Traits\DeudaTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use DeudaTrait;

    public function index()
    {
        $query = Sucursal::query();
        if ((string) auth()->user()->ID_SUC !== '') {
            $query->where('ID_SUC', auth()->user()->ID_SUC);
        }

        $sucursales = $query->get();

        return view('cliente.index', compact('sucursales'));
    }

    public function clientes($id_suc)
    {
        $sucursal = Sucursal::findOrFail($id_suc);
        $clientes = Cliente::where('ID_SUC', $id_suc)
            ->where('EST_CLI', 'ACTIVO')
            ->select('COD_CLI', 'NOM_CLI', 'APE_CLI', 'CI_CLI', 'DIR_CLI', 'ID_CLI')
            ->get();
        $clientes_inactivos = Cliente::where('ID_SUC', $id_suc)
            ->where('EST_CLI', 'INACTIVO')
            ->get();

        return view('cliente.parcial.clientes', compact('sucursal', 'clientes', 'clientes_inactivos'));
    }

    public function nuevo($id_suc, $id_sw)
    {
        $sw = null;
        if ((int) $id_sw !== 0) {
            $sw = SolicitudWeb::find($id_sw);
        }

        $sucursal = Sucursal::with('planes')->findOrFail($id_suc);

        return view('cliente.nuevo', compact('sucursal', 'sw'));
    }

    public function store(Request $request)
    {
        $sucursal = Sucursal::findOrFail($request->id_suc);
        $codigo = $request->num_cli.'-'.$sucursal->ABR_SUC;

        $existe = Cliente::where('CI_CLI', $request->ci_cli)
            ->orWhere('COD_CLI', $codigo)
            ->first();

        if ($existe) {
            return response()->json(['existe', $existe]);
        }

        $cliente = new Cliente();
        $cliente->ID_SUC = $request->id_suc;
        $cliente->NUM_CLI = $request->num_cli;
        $cliente->ABR_SUC_CLI = $sucursal->ABR_SUC;
        $cliente->COD_CLI = $codigo;
        $cliente->NOM_CLI = $request->nom_cli;
        $cliente->APE_CLI = $request->ape_cli;
        $cliente->CI_CLI = $request->ci_cli;
        $cliente->CEL_CLI = $request->cel_cli;
        $cliente->TEL_CLI = $request->tel_cli;
        $cliente->DIR_CLI = $request->dir_cli;
        $cliente->DES_DIR = $request->des_dir;
        $cliente->FOT_CI = $request->fot_ci;
        $cliente->FOT_LUZ = $request->fot_luz;
        $cliente->FOT_AGU = $request->fot_agu;
        $cliente->NOM_PR = $request->nom_pr;
        $cliente->CI_PR = $request->ci_pr;
        $cliente->CEL_PR = $request->cel_pr;
        $cliente->LAT_CLI = $request->lat_cli;
        $cliente->LNG_CLI = $request->lng_cli;
        if (empty($cliente->EST_CLI)) {
            $cliente->EST_CLI = 'ACTIVO';
        }
        $cliente->save();

        return response()->json($cliente);
    }

    public function edita($id_cli)
    {
        $cliente = Cliente::findOrFail($id_cli);
        $sucursal = Sucursal::with('planes')->findOrFail($cliente->ID_SUC);
        $files = File::where('ID_CLI', $id_cli)->get();

        return view('cliente.edita', compact('cliente', 'sucursal', 'files'));
    }

    public function actualiza(Request $request)
    {
        $cliente = Cliente::findOrFail($request->id_cli);
        $sucursal = Sucursal::findOrFail($cliente->ID_SUC);

        $nuevoCodigo = $request->num_cli.'-'.$sucursal->ABR_SUC;
        if ($request->cod_ant !== $nuevoCodigo && Cliente::where('COD_CLI', $nuevoCodigo)->exists()) {
            return redirect()->back()->with('error', 'Ya existe un cliente con el codigo: "'.$nuevoCodigo.'"');
        }

        $cliente->NUM_CLI = $request->num_cli;
        $cliente->ABR_SUC_CLI = $sucursal->ABR_SUC;
        $cliente->COD_CLI = $nuevoCodigo;
        $cliente->NOM_CLI = $request->nom_cli;
        $cliente->APE_CLI = $request->ape_cli;
        $cliente->CI_CLI = $request->ci_cli;
        $cliente->CEL_CLI = $request->cel_cli;
        $cliente->TEL_CLI = $request->tel_cli;
        $cliente->DIR_CLI = $request->dir_cli;
        $cliente->DES_DIR = $request->des_dir;
        $cliente->FOT_CI = $request->fot_ci;
        $cliente->FOT_LUZ = $request->fot_luz;
        $cliente->FOT_AGU = $request->fot_agu;
        $cliente->NOM_PR = $request->nom_pr;
        $cliente->CI_PR = $request->ci_pr;
        $cliente->CEL_PR = $request->cel_pr;
        $cliente->LAT_CLI = $request->lat_cli;
        $cliente->LNG_CLI = $request->lng_cli;
        $cliente->save();

        return redirect('/cliente')->with('exito', 'Cliente editado');
    }

    public function elimina(Request $request)
    {
        $cliente = Cliente::findOrFail($request->id_cli);
        $cliente->EST_CLI = 'INACTIVO';
        $cliente->COD_ATG = $cliente->COD_CLI;
        $cliente->COD_CLI = null;
        $cliente->save();

        return response()->json($cliente->ID_SUC);
    }

    public function activa(Request $request)
    {
        $cliente = Cliente::findOrFail($request->id_cli);
        $cliente->EST_CLI = 'ACTIVO';
        if (empty($cliente->COD_CLI) && ! empty($cliente->NUM_CLI) && ! empty($cliente->ABR_SUC_CLI)) {
            $cliente->COD_CLI = $cliente->NUM_CLI.'-'.$cliente->ABR_SUC_CLI;
        }
        $cliente->save();

        return response()->json($cliente->ID_SUC);
    }

    public function informacion($id_cli)
    {
        $cliente = Cliente::findOrFail($id_cli);
        $sucursal = Sucursal::with('planes')->findOrFail($cliente->ID_SUC);
        $cnf = Configuracion::first();

        return view('cliente.informacion', compact('cliente', 'sucursal', 'cnf'));
    }

    public function actual($id_cli)
    {
        $pagos = collect([]);
        $deudas = collect([]);
        $alerta = collect([]);

        $ultimo_pago = Pago::join('contrato', 'contrato.ID_CON', '=', 'pago.ID_CON')
            ->where('ID_CLI', $id_cli)
            ->where('MOT_PAG', 'MENSUALIDAD')
            ->where('EST_CON', '<>', 'CANCELADO')
            ->orderByDesc('ID_PAG')
            ->first();

        $cliente = Cliente::where('cliente.ID_CLI', $id_cli)
            ->join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->where('EST_CON', '<>', 'CANCELADO')
            ->first();

        $activo = Contrato::join('plan', 'plan.ID_PLAN', '=', 'contrato.ID_PLAN')
            ->with('convenio')
            ->where('ID_CLI', $id_cli)
            ->where('EST_CON', '<>', 'CANCELADO')
            ->orderByDesc('ID_CON')
            ->first();

        if ($activo) {
            $alerta = $this->deudorTrait($cliente);
            $pagos = Pago::leftJoin('pago_detalle', 'pago_detalle.ID_PAG', '=', 'pago.ID_PAG')
                ->where('ID_CON', $activo->ID_CON)
                ->select('pago_detalle.ID_PD', 'pago.ID_PAG', 'pago.MOT_PAG', 'pago_detalle.ANIO_PD', 'pago_detalle.MES_PD', 'pago_detalle.FTR_PD')
                ->orderByDesc('pago.ID_PAG')
                ->get();
            $deudas = $this->calculaDeudas($activo->ID_CON);
        }

        return view('cliente.parcial.actual', compact('activo', 'pagos', 'ultimo_pago', 'deudas', 'alerta'));
    }

    public function historial($id_cli)
    {
        $alerta = collect([]);
        $cliente = Cliente::where('cliente.ID_CLI', $id_cli)
            ->join('contrato', 'contrato.ID_CLI', '=', 'cliente.ID_CLI')
            ->where('EST_CON', '<>', 'CANCELADO')
            ->first();
        $activo = Contrato::where('ID_CLI', $id_cli)->where('EST_CON', '<>', 'CANCELADO')->first();
        $contratos = Contrato::with('plan')
            ->where('ID_CLI', $id_cli)
            ->orderByDesc('ID_CON')
            ->get();

        if ($activo) {
            $alerta = $this->deudorTrait($cliente);
        }

        return view('cliente.parcial.historial', compact('contratos', 'alerta'));
    }

    public function pagos($id_con)
    {
        $pagos = Pago::leftJoin('pago_detalle', 'pago_detalle.ID_PAG', '=', 'pago.ID_PAG')
            ->where('ID_CON', $id_con)
            ->select('pago.ID_PAG', 'pago.MOT_PAG', 'pago_detalle.ANIO_PD', 'pago_detalle.MES_PD', 'pago_detalle.ID_PD')
            ->orderByDesc('pago.ID_PAG')
            ->get();

        return view('cliente.parcial.pagos', compact('pagos'));
    }

    public function cliente_pdf($id_cli)
    {
        $cliente = Cliente::where('ID_CLI', $id_cli)
            ->join('sucursal', 'sucursal.ID_SUC', '=', 'cliente.ID_SUC')
            ->first();

        $pdf = Pdf::setPaper('LETTER', 'portrait')->loadView('pdf.cliente', compact('cliente'));

        return $pdf->stream('CLIENTE.pdf');
    }

    public function factura($id_pd)
    {
        $detalle = PagoDetalle::where('ID_PD', $id_pd)->firstOrFail();
        $detalle->FTR_PD = ((int) $detalle->FTR_PD === 0) ? 1 : 0;
        $detalle->save();

        return response()->json('Factura actualizada');
    }

    public function file(Request $request)
    {
        $file = new File();
        $file->ID_CLI = $request->id_cli;
        $file->TIP_FILE = $request->tip_file;

        if ($request->hasFile('img_file')) {
            $imagen = $request->file('img_file');
            $extension = $imagen->extension();
            $direccion = $imagen->storeAs(
                'img/FILES',
                'FILE-'.Carbon::now()->format('Y-m-d_H-i-s').'.'.$extension,
                'public'
            );
            $file->URL_FILE = 'storage/'.$direccion;
        }

        $file->save();

        return redirect()->back()->with('exito', 'Archivo guardado exitosamente');
    }

    public function create()
    {
        return redirect()->route('cliente.index');
    }

    public function show(string $id)
    {
        return redirect()->route('cliente.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('cliente.index');
    }

    public function update(Request $request, string $id)
    {
        return $this->actualiza($request);
    }

    public function destroy(string $id)
    {
        return redirect()->route('cliente.index');
    }
}
