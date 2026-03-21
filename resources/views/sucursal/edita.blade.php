@extends('layouts.master')
@section('sucursal','active')
@section('title','EDICION DE SUCURSAL')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">EDITA SUCURSAL</h3>
    </div>
    <div class="box-body">
        <form action="{{ route('sucursal.update') }}" method="POST" data-parsley-validate id="nuevo">
            @csrf
            <input type="hidden" name="id_suc" value="{{ $sucursal->ID_SUC }}">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nom_suc" class="form-label">NOMBRE DE LA SUCURSAL:</label>
                    <input type="text" class="form-control may" name="nom_suc" value="{{ $sucursal->NOM_SUC }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="abr_suc" class="form-label">INICIALES:</label>
                    <input type="text" class="form-control may" name="abr_suc" value="{{ $sucursal->ABR_SUC }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="id_loc" class="form-label">LOCALIDAD:</label>
                    <select class="form-control" name="id_loc" required>
                        @foreach($localidades as $localidad)
                        <option value="{{ $localidad->ID_LOC }}" {{ $sucursal->ID_LOC == $localidad->ID_LOC ? 'selected' : '' }}>{{ $localidad->NOM_LOC }}</option>
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
                    <input type="text" class="form-control may" name="dir_suc" value="{{ $sucursal->DIR_SUC }}" required>
                    <input type="hidden" name="lat_suc" value="{{ $sucursal->LAT_SUC }}">
                    <input type="hidden" name="lng_suc" value="{{ $sucursal->LNG_SUC }}">
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary pull-left" href="{{ url('/sucursal') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Editar sucursal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $('#nuevo #id_plan').select2();
    $(document).ready(function () {
        var planes = {!! json_encode($sucursal->planes->toArray()) !!};
        var data = [];
        planes.forEach(function (plan) {
            data.push({ id: plan.ID_PLAN, text: plan.NOM_PLAN });
        });
        $('#id_plan').select2({ data: data });

        var seleccionados = [];
        planes.forEach(function (plan) {
            seleccionados.push(plan.ID_PLAN);
        });
        $('#id_plan').val(seleccionados).change();
    });
</script>
@endsection
