@extends('layouts.master')
@section('rol','active')
@section('title','ROLES Y PERMISOS DE LOS USUARIOS')
@section('content')

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#roles" data-toggle="tab">ROLES</a></li>
        <li><a href="#permisos" data-toggle="tab">PERMISOS</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="roles">
            <table class="table table-hover table-bordered table-striped datatable">
                <thead>
                    <tr class="bg-yellow">
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>PERMISOS</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $numero => $rol)
                    <tr>
                        <td>{{ $numero + 1 }}</td>
                        <td>{{ $rol->name }}</td>
                        <td>
                            @foreach($rol->permissions as $perm)
                            <span class="badge badge-info">{{ $perm->name }}</span>
                            @endforeach
                        </td>
                        <td><button class="btn btn-warning btn-sm" onclick='edit(@json($rol), @json($rol->permissions));'><i class="fa fa-pencil"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="permisos">
            <table class="table table-hover table-striped table-bordered table-sm datatable">
                <thead>
                    <tr class="bg-yellow">
                        <th>#</th>
                        <th>PERMISO</th>
                        <th>DESCRIPCION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $numero => $permiso)
                    <tr>
                        <td>{{ $numero + 1 }}</td>
                        <td>{{ $permiso->name }}</td>
                        <td>{{ $permiso->description ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar rol</h4>
            </div>
            <form method="POST" action="{{ route('rol.update') }}" id="update">
                @csrf
                <input type="hidden" name="id_rol" id="id_rol" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">NOMBRE DEL ROL</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="permisos">PERMISOS</label>
                            <select class="select2" data-dropdown-css-class="select2-purple" name="permisos[]" id="permisos" multiple="multiple" data-placeholder="Seleccione un permiso" style="width: 100%;" required>
                                @foreach($permisos as $permiso)
                                <option value="{{ $permiso->id }}">{{ $permiso->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        var permisos = {!! json_encode($permisos->toArray()) !!};
        var data = [];
        permisos.forEach(function (permiso) {
            data.push({ id: permiso.id, text: permiso.name });
        });
        $('#update #permisos').select2({ data: data });
    });

    function edit(rol, permisos) {
        var data = [];
        permisos.forEach(function (permiso) {
            data.push(permiso.id);
        });
        $('#update #permisos').val(data).change();
        $('#update #name').val(rol.name);
        $('#update #id_rol').val(rol.id);
        $('#modalUpdate').modal('show');
    }
</script>
@endsection
