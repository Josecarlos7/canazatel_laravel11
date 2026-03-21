@extends('layouts.master')
@section('localidad','active')
@section('title','LOCALIDADES REGISTRADAS')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">LOCALIDADES REGISTRADAS</h3>
    </div>
    <div class="box-body">
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> NUEVA LOCALIDAD</button>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-sm datatable">
                <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>LOCALIDAD</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($localidades as $numero => $localidad)
                    <tr>
                        <td>{{ $numero + 1 }}</td>
                        <td>{{ $localidad->NOM_LOC }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" type="button" onclick='modalEdita(@json($localidad))'><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-sm btn-danger" type="button" onclick="modalElimina({{ $localidad->ID_LOC }})"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva localidad</h4>
            </div>
            <form action="{{ url('/localidad') }}" method="POST" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nom_loc" class="form-label">NOMBRE DE LA LOCALIDAD:</label>
                            <input type="text" class="form-control may" name="nom_loc" placeholder="Ingrese el nombre de la localidad" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar localidad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdita">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar localidad</h4>
            </div>
            <form action="{{ route('localidad.update') }}" method="POST" id="update" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_loc" id="id_loc" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nom_loc" class="form-label">NOMBRE DE LA LOCALIDAD:</label>
                            <input type="text" class="form-control may" name="nom_loc" id="nom_loc" placeholder="Ingrese el nombre de la localidad" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Editar localidad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalElimina">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ELIMINA LOCALIDAD</h4>
            </div>
            <form action="{{ route('localidad.elimina') }}" method="POST" id="elimina" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_loc" id="id_loc" value="">
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="alert alert-danger"><h3>ESTA SEGURO QUE DESEA ELIMINAR ESTA LOCALIDAD?</h3></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Eliminar localidad</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function modalEdita(localidad) {
        $('#update #id_loc').val(localidad.ID_LOC);
        $('#update #nom_loc').val(localidad.NOM_LOC);
        $('#modalEdita').modal('show');
    }

    function modalElimina(id_loc) {
        $('#elimina #id_loc').val(id_loc);
        $('#modalElimina').modal('show');
    }
</script>
@endsection
