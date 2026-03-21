@extends('layouts.master')
@section('usuario','active')
@section('title','USUARIOS REGISTRADOS')
@section('content')
<button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> NUEVO USUARIO</button>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#activos" data-toggle="tab">USUARIOS ACTIVOS</a></li>
        <li><a href="#inactivos" data-toggle="tab">USUARIOS INACTIVOS</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="activos">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered table-sm datatable">
                    <thead>
                        <tr class="bg-gray">
                            <th>#</th>
                            <th>USUARIO</th>
                            <th>CI</th>
                            <th>SUCURSAL</th>
                            <th>EMAIL</th>
                            <th>ROL</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activos as $numero => $usuario)
                        <tr>
                            <td>{{ $numero + 1 }}</td>
                            <td>{{ $usuario->NOM_USU.' '.$usuario->PAT_USU.' '.$usuario->MAT_USU }}</td>
                            <td>{{ $usuario->CI_USU.' '.$usuario->EXP_USU }}</td>
                            <td>{{ $usuario->sucursal->first() ? $usuario->sucursal->first()['NOM_SUC'] : '' }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @foreach ($usuario->roles as $rol)
                                <span class="badge bg-blue">{{ $rol->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick='modalEdita(@json($usuario), @json($usuario->roles))' type="button"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-sm btn-danger" onclick="modalElimina({{ $usuario->ID_USU }})" type="button"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="inactivos">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered table-sm datatable">
                    <thead>
                        <tr class="bg-gray">
                            <th>#</th>
                            <th>USUARIO</th>
                            <th>CI</th>
                            <th>ROL</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inactivos as $numero => $usuario)
                        <tr>
                            <td>{{ $numero + 1 }}</td>
                            <td>{{ $usuario->NOM_USU.' '.$usuario->PAT_USU.' '.$usuario->MAT_USU }}</td>
                            <td>{{ $usuario->CI_USU.' '.$usuario->EXP_USU }}</td>
                            <td>
                                @foreach ($usuario->roles as $rol)
                                <span class="badge bg-blue">{{ $rol->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick='modalEdita(@json($usuario), @json($usuario->roles))' type="button"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-sm btn-success" onclick="modalReactiva({{ $usuario->ID_USU }})" type="button"><i class="fa fa-arrow-up"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo usuario</h4>
            </div>
            <form action="{{ url('/usuario') }}" method="POST" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom_usu" class="form-label">NOMBRES:</label>
                            <input type="text" class="form-control may letras" name="nom_usu" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pat_usu" class="form-label">APELLIDO PATERNO:</label>
                            <input type="text" class="form-control may letras" name="pat_usu" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mat_usu" class="form-label">APELLIDO MATERNO:</label>
                            <input type="text" class="form-control may letras" name="mat_usu" required>
                        </div>
                        <div class="row form-group col-md-6">
                            <div class="form-group col-md-6">
                                <label for="ci_usu" class="form-label">NRO DE CI:</label>
                                <input type="text" class="form-control may" name="ci_usu" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exp_usu" class="form-label">EXP:</label>
                                <select class="form-control" name="exp_usu" required>
                                    <option value="LP">LP</option>
                                    <option value="CBA">CBA</option>
                                    <option value="SC">SC</option>
                                    <option value="CH">CH</option>
                                    <option value="OR">OR</option>
                                    <option value="PT">PT</option>
                                    <option value="TJ">TJ</option>
                                    <option value="BE">BE</option>
                                    <option value="PD">PD</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="form-label">CORREO ELECTRONICO:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password" class="form-label">CONTRASENA:</label>
                            <input type="password" class="form-control min" name="password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_rol" class="form-label">ROL DE USUARIO:</label>
                            <select class="form-control" name="id_rol" onchange="sucursal(this.value);" required>
                                <option selected disabled>-SELECCIONE UN ROL-</option>
                                @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="div_sucursal"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar usuario</button>
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
                <h4 class="modal-title">Editar usuario</h4>
            </div>
            <form action="{{ route('usuario.actualiza') }}" method="POST" data-parsley-validate id="update">
                @csrf
                <input type="hidden" name="id_usu" id="id_usu" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom_usu" class="form-label">NOMBRES:</label>
                            <input type="text" class="form-control may letras" name="nom_usu" id="nom_usu" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pat_usu" class="form-label">APELLIDO PATERNO:</label>
                            <input type="text" class="form-control may letras" name="pat_usu" id="pat_usu" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mat_usu" class="form-label">APELLIDO MATERNO:</label>
                            <input type="text" class="form-control may letras" name="mat_usu" id="mat_usu" required>
                        </div>
                        <div class="row form-group col-md-6">
                            <div class="form-group col-md-6">
                                <label for="ci_usu" class="form-label">NRO DE CI:</label>
                                <input type="text" class="form-control may" name="ci_usu" id="ci_usu" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exp_usu" class="form-label">EXP:</label>
                                <select class="form-control" name="exp_usu" id="exp_usu" required>
                                    <option value="LP">LP</option>
                                    <option value="CBA">CBA</option>
                                    <option value="SC">SC</option>
                                    <option value="CH">CH</option>
                                    <option value="OR">OR</option>
                                    <option value="PT">PT</option>
                                    <option value="TJ">TJ</option>
                                    <option value="BE">BE</option>
                                    <option value="PD">PD</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="form-label">CORREO ELECTRONICO:</label>
                            <input type="text" class="form-control min" name="email" id="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password" class="form-label">CONTRASENA:</label>
                            <input type="password" class="form-control min" name="password" id="password">
                            <small>* Llene este campo solo si desea cambiar la contrasena</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_rol" class="form-label">ROL DE USUARIO:</label>
                            <select class="form-control" name="id_rol" id="id_rol" onchange="sucursal_u(this.value);" required>
                                <option selected disabled>-SELECCIONE UN ROL-</option>
                                @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="div_sucursal_u"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Editar usuario</button>
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
                <h4 class="modal-title">Baja usuario</h4>
            </div>
            <form action="{{ route('usuario.elimina') }}" method="POST" data-parsley-validate id="elimina">
                @csrf
                <input type="hidden" name="id_usu" id="id_usu" value="">
                <div class="modal-body">
                    <div class="col-md-12 alert alert-danger text-center"><h2>ESTA SEGURO QUE DESEA DAR DE BAJA A ESTE USUARIO?</h2></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Dar de Baja</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReactiva">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reactivar usuario</h4>
            </div>
            <form action="{{ route('usuario.reactiva') }}" method="POST" data-parsley-validate id="reactiva">
                @csrf
                <input type="hidden" name="id_usu" id="id_usu" value="">
                <div class="modal-body">
                    <div class="col-md-12 alert alert-success text-center"><h2>ESTA SEGURO QUE DESEA REACTIVAR A ESTE USUARIO?</h2></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Reactivar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function sucursal(id_rol) {
        if (parseInt(id_rol, 10) === 2) {
            $('#div_sucursal').html('<div class="form-group col-md-6">'
                + '<label for="id_suc" class="form-label">SUCURSAL ASIGNADA:</label>'
                + '<select class="form-control" name="id_suc" required>'
                + '<option selected disabled>-SELECCIONE UNA SUCURSAL-</option>'
                @foreach ($sucursales as $sucursal)
                + '<option value="{{ $sucursal->ID_SUC }}">{{ $sucursal->NOM_SUC }}</option>'
                @endforeach
                + '</select>'
                + '</div>');
        } else {
            $('#div_sucursal').empty();
        }
    }

    function sucursal_u(id_rol) {
        if (parseInt(id_rol, 10) === 2) {
            $('#div_sucursal_u').html('<div class="form-group col-md-6">'
                + '<label for="id_suc" class="form-label">SUCURSAL ASIGNADA:</label>'
                + '<select class="form-control" name="id_suc" id="id_suc" required>'
                + '<option selected disabled>-SELECCIONE UNA SUCURSAL-</option>'
                @foreach ($sucursales as $sucursal)
                + '<option value="{{ $sucursal->ID_SUC }}">{{ $sucursal->NOM_SUC }}</option>'
                @endforeach
                + '</select>'
                + '</div>');
        } else {
            $('#div_sucursal_u').empty();
        }
    }

    function modalEdita(usuario, roles) {
        $('#update #id_usu').val(usuario.ID_USU);
        $('#update #nom_usu').val(usuario.NOM_USU);
        $('#update #pat_usu').val(usuario.PAT_USU);
        $('#update #mat_usu').val(usuario.MAT_USU);
        $('#update #ci_usu').val(usuario.CI_USU);
        $('#update #exp_usu').val(usuario.EXP_USU);
        $('#update #email').val(usuario.email);

        if (roles && roles.length > 0) {
            $('#update #id_rol').val(roles[0].id);
            sucursal_u(roles[0].id);
        }

        $('#update #id_suc').val(usuario.ID_SUC);
        $('#modalEdita').modal('show');
    }

    function modalElimina(id_usu) {
        $('#elimina #id_usu').val(id_usu);
        $('#modalElimina').modal('show');
    }

    function modalReactiva(id_usu) {
        $('#reactiva #id_usu').val(id_usu);
        $('#modalReactiva').modal('show');
    }
</script>
@endsection
