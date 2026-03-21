@extends('layouts.master')
@section('configuracion','active')
@section('title','CONFIGURACION DEL SISTEMA')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">PARAMETROS GENERALES</h3>
    </div>
    <form action="{{ url('/configuracion') }}" method="POST">
        @csrf
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>PRECIO RECONEXION</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_reconexion" value="{{ $cnf->PRE_RECONEXION ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO REPARACION</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_reparacion" value="{{ $cnf->PRE_REPARACION ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO TRASLADO INTERNO</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_traslado_i" value="{{ $cnf->PRE_TRASLADO_I ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO TRASLADO EXTERNO</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_traslado_e" value="{{ $cnf->PRE_TRASLADO_E ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO CAMBIO ONT/ONU</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_cambio_ont" value="{{ $cnf->PRE_CAMBIO_ONT ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO REPOSICION CABLE</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_repo_cable" value="{{ $cnf->PRE_REPO_CABLE ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO TRASLADO INTERNO DE SERVICIO</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_tras_int_serv" value="{{ $cnf->PRE_TRAS_INT_SERV ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO TRASLADO EXTERNO DE SERVICIO</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_tras_ext_serv" value="{{ $cnf->PRE_TRAS_EXT_SERV ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO REPARACION GRATIS</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_rep_grts" value="{{ $cnf->PRE_REP_GRTS ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>PRECIO RECONEXION GRATIS</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pre_rec_grts" value="{{ $cnf->PRE_REC_GRTS ?? 0 }}" step="0.01">
                        <span class="input-group-addon">Bs.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-center">
            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> GUARDAR CONFIGURACION</button>
        </div>
    </form>
</div>
@endsection
