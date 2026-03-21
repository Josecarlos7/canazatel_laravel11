@extends('layouts.master')
@section('sucursal','active')
@section('title','REGISTRO DE SUCURSAL')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">NUEVA SUCURSAL</h3>
    </div>
    <div class="box-body">
        <form action="{{ url('/sucursal') }}" method="POST" data-parsley-validate id="nuevo">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nom_suc" class="form-label">NOMBRE DE LA SUCURSAL:</label>
                    <input type="text" class="form-control may" name="nom_suc" placeholder="Ingrese el nombre de la sucursal" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="abr_suc" class="form-label">INICIALES DE LA SUCURSAL:</label>
                    <input type="text" class="form-control may" name="abr_suc" placeholder="Ingrese las iniciales de la sucursal" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="id_loc" class="form-label">LOCALIDAD:</label>
                    <select class="form-control" name="id_loc" required>
                        @foreach($localidades as $localidad)
                        <option value="{{ $localidad->ID_LOC }}">{{ $localidad->NOM_LOC }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="id_plan" class="form-label">PLANES:</label>
                    <select class="select2" data-dropdown-css-class="select2-purple" name="id_plan[]" id="id_plan" multiple="multiple" data-placeholder="Seleccione un plan" style="width: 100%;" required>
                        @foreach($planes as $plan)
                        <option value="{{ $plan->ID_PLAN }}">{{ $plan->NOM_PLAN }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="dir_suc" class="form-label">DIRECCION DE LA SUCURSAL:</label>
                    <input type="text" class="form-control may" name="dir_suc" placeholder="Ingrese la direccion de la sucursal" required>
                    <input type="hidden" name="lat_suc" id="lat_suc" value="">
                    <input type="hidden" name="lng_suc" id="lng_suc" value="">
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary pull-left" href="{{ url('/sucursal') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar sucursal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $('#nuevo #id_plan').select2();
</script>
@endsection
