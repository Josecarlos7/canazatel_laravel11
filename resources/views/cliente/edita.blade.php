@extends('layouts.master')
@section('cliente','active')
@section('title','EDITA CLIENTE')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">EDITA CLIENTE</h3>
    </div>
    <div class="box-body">
        <form method="POST" action="{{ route('cliente.actualiza') }}" data-parsley-validate>
            @csrf
            <input type="hidden" name="id_cli" value="{{ $cliente->ID_CLI }}">
            <input type="hidden" name="cod_ant" value="{{ $cliente->COD_CLI }}">
            <input type="hidden" name="lat_cli" value="{{ $cliente->LAT_CLI }}">
            <input type="hidden" name="lng_cli" value="{{ $cliente->LNG_CLI }}">
            <div class="row">
                <div class="form-group col-md-3">
                    <label>CODIGO DEL CLIENTE</label>
                    <input type="number" class="form-control" name="num_cli" value="{{ $cliente->NUM_CLI }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label>INICIAL SUCURSAL</label>
                    <input type="text" class="form-control" value="-{{ $sucursal->ABR_SUC }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>NOMBRES</label>
                    <input type="text" class="form-control" name="nom_cli" value="{{ $cliente->NOM_CLI }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label>APELLIDOS</label>
                    <input type="text" class="form-control" name="ape_cli" value="{{ $cliente->APE_CLI }}" required>
                </div>

                <div class="form-group col-md-3">
                    <label>CI / NIT</label>
                    <input type="text" class="form-control" name="ci_cli" value="{{ $cliente->CI_CLI }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label>CELULAR</label>
                    <input type="text" class="form-control" name="cel_cli" value="{{ $cliente->CEL_CLI }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label>TELEFONO</label>
                    <input type="text" class="form-control" name="tel_cli" value="{{ $cliente->TEL_CLI }}">
                </div>
                <div class="form-group col-md-3">
                    <label>SUCURSAL</label>
                    <input type="text" class="form-control" value="{{ $sucursal->NOM_SUC }}" disabled>
                </div>

                <div class="form-group col-md-6">
                    <label>DIRECCION</label>
                    <input type="text" class="form-control" name="dir_cli" value="{{ $cliente->DIR_CLI }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>DESCRIPCION DIRECCION</label>
                    <textarea class="form-control" name="des_dir" rows="2">{{ $cliente->DES_DIR }}</textarea>
                </div>

                <div class="col-md-12"><h4 class="text-primary">PERSONA DE REFERENCIA</h4></div>
                <div class="form-group col-md-4">
                    <label>NOMBRE Y APELLIDO</label>
                    <input type="text" class="form-control" name="nom_pr" value="{{ $cliente->NOM_PR }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>CI</label>
                    <input type="text" class="form-control" name="ci_pr" value="{{ $cliente->CI_PR }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>CELULAR</label>
                    <input type="text" class="form-control" name="cel_pr" value="{{ $cliente->CEL_PR }}" required>
                </div>

                <div class="col-md-12" style="background:#f7f7c6; padding:10px; margin:10px 0;">
                    <strong>REQUISITOS</strong>
                    <div class="checkbox"><label><input type="checkbox" name="fot_ci" value="SI" {{ $cliente->FOT_CI === 'SI' ? 'checked' : '' }}> Fotocopia de carnet</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="fot_luz" value="SI" {{ $cliente->FOT_LUZ === 'SI' ? 'checked' : '' }}> Fotocopia de luz</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="fot_agu" value="SI" {{ $cliente->FOT_AGU === 'SI' ? 'checked' : '' }}> Fotocopia de agua</label></div>
                </div>

                <div class="col-md-12" style="background:#d9edf7; padding:10px; margin:10px 0;">
                    <button class="btn btn-success btn-sm pull-right" type="button" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> Agregar nuevo archivo</button>
                    <h4 class="text-primary">ARCHIVOS</h4>
                    @forelse ($files as $file)
                    <a class="btn btn-app" target="_blank" href="{{ url($file->URL_FILE) }}">
                        <i class="fa fa-file-o"></i><b>{{ $file->TIP_FILE }}</b>
                    </a>
                    @empty
                    <p class="text-muted">No hay archivos adjuntos</p>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ url('/cliente') }}" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i> Volver</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Editar cliente</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalNuevo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Archivo</h4>
            </div>
            <form action="{{ route('cliente.file') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_cli" value="{{ $cliente->ID_CLI }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>IMAGEN DEL ARCHIVO</label>
                            <input type="file" name="img_file" accept="image/*" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>TIPO DE ARCHIVO</label>
                            <select class="form-control" name="tip_file" required>
                                <option value="FOTOCOPIA DE CARNET">FOTOCOPIA DE CARNET</option>
                                <option value="FOTOCOPIA DE LUZ">FOTOCOPIA DE LUZ</option>
                                <option value="FOTOCOPIA DE AGUA">FOTOCOPIA DE AGUA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Guardar archivo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
