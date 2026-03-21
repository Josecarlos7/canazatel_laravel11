<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Models\Plan;
use App\Models\PlanCanal;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $planes = Plan::with('canales')->get();
        $canales = Canal::all();

        return view('plan.index', compact('planes', 'canales'));
    }

    public function store(Request $request)
    {
        $v = Plan::validationStore($request);
        if ($v) {
            return redirect()->back()->with('error', $v)->withInput();
        }

        $plan = new Plan();
        $plan->NOM_PLAN = $request->nom_plan;
        $plan->TIPO_PLAN = $request->tipo_plan;
        $plan->PRE_INST = $request->pre_inst;
        $plan->PRE_PTS_INST_XTR = $request->pre_pts_inst_xtr;
        $plan->PRE_PTS_XTR = $request->pre_pts_xtr;
        $plan->PRE_PTS_XTR_SOL = $request->pre_pts_xtr_sol;
        $plan->PRE_MENS = $request->pre_mens;
        $plan->save();

        return redirect()->back()->with('exito', 'Plan creado exitosamente');
    }

    public function actualiza(Request $request)
    {
        $plan = Plan::findOrFail($request->id_plan);
        $plan->NOM_PLAN = $request->nom_plan;
        $plan->TIPO_PLAN = $request->tipo_plan;
        $plan->PRE_INST = $request->pre_inst;
        $plan->PRE_PTS_INST_XTR = $request->pre_pts_inst_xtr;
        $plan->PRE_PTS_XTR = $request->pre_pts_xtr;
        $plan->PRE_PTS_XTR_SOL = $request->pre_pts_xtr_sol;
        $plan->PRE_MENS = $request->pre_mens;
        $plan->save();

        return redirect()->back()->with('exito', 'Plan editado exitosamente');
    }

    public function planCanales($id_plan)
    {
        $canales = Canal::all();
        $asignados = PlanCanal::where('ID_PLAN', $id_plan)->pluck('ID_CAN')->toArray();

        return view('plan.parcial.planCanales', compact('canales', 'id_plan', 'asignados'));
    }

    public function asignaCanales(Request $request)
    {
        PlanCanal::where('ID_PLAN', $request->id_plan)->delete();
        if ($request->input('ch_') !== null) {
            for ($i = 0; $i < count($request->input('ch_')); $i++) {
                $plancanal = new PlanCanal();
                $plancanal->ID_PLAN = $request->id_plan;
                $plancanal->ID_CAN = $request->input('ch_.'.$i);
                $plancanal->save();
            }
        }

        return redirect()->back()->with('exito', 'Canales asignados exitosamente');
    }

    public function create()
    {
        return redirect()->route('plan.index');
    }

    public function show(string $id)
    {
        return redirect()->route('plan.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('plan.index');
    }

    public function update(Request $request, string $id)
    {
        return $this->actualiza($request);
    }

    public function destroy(string $id)
    {
        return redirect()->route('plan.index');
    }
}
