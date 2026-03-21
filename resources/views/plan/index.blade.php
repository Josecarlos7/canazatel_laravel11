@extends('layouts.master')
@section('plan','active')
@section('title','PLANES REGISTRADOS')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">PLANES REGISTRADOS</h3>
    </div>
    <div class="box-body">
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> NUEVO PLAN</button>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-sm datatable text-center">
                <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>PLAN</th>
                        <th>PRECIOS</th>
                        <th>CANALES</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planes as $numero => $plan)
                    <tr>
                        <td>{{ $numero + 1 }}</td>
                        <td>{{ $plan->NOM_PLAN }}</td>
                        <td>
                            <small>
                                <b>INSTALACION: </b>{{ $plan->PRE_INST }} Bs.<br>
                                <b>MENSUALIDAD: </b>{{ $plan->PRE_MENS }} Bs.<br>
                                <b>PRECIO POR PUNTO: </b>{{ $plan->PRE_PTS_XTR }} Bs.
                            </small>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick='listaCanales(@json($plan->canales))'>{{ count($plan->canales) }}</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" title="Editar canales" type="button" onclick='editarCanales(@json($plan))'><i class="fa fa-cube"></i></button>
                            <button class="btn btn-sm btn-warning" title="Editar plan" type="button" onclick='modalEdita(@json($plan))'><i class="fa fa-pencil"></i></button>
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
                <h4 class="modal-title">Nuevo plan</h4>
            </div>
            <form action="{{ url('/plan') }}" method="POST" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom_plan" class="form-label">NOMBRE DEL PLAN:</label>
                            <input type="text" class="form-control may" name="nom_plan" placeholder="Ingrese el nombre del plan" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipo_plan" class="form-label">TIPO DE PLAN:</label>
                            <select class="form-control" name="tipo_plan" required>
                                <option disabled selected>-SELECCIONE EL TIPO DE PLAN-</option>
                                <option value="TV">TV CABLE</option>
                                <option value="WIFI">WIFI</option>
                                <option value="TV_WIFI">TV CABLE + WIFI</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_inst" class="form-label">PRECIO DE INSTALACION:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="pre_inst" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_mens" class="form-label">PRECIO DE MENSUALIDAD:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pre_mens" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_pts_inst_xtr" class="form-label">PRECIO POR PUNTO EXTRA <b class="text-danger">(INSTALACION)</b>:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pre_pts_inst_xtr" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_pts_xtr" class="form-label">PRECIO POR PUNTO EXTRA <b class="text-primary">(NORMAL)</b>:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pre_pts_xtr" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_pts_xtr_sol" class="form-label">PRECIO POR PUNTO EXTRA <b class="text-success">(POR SOLICITUD)</b>:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pre_pts_xtr_sol" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar plan</button>
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
                <h4 class="modal-title">Editar plan</h4>
            </div>
            <form action="{{ route('plan.actualiza') }}" method="POST" data-parsley-validate id="update">
                @csrf
                <input type="hidden" name="id_plan" id="id_plan">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom_plan" class="form-label">NOMBRE DEL PLAN:</label>
                            <input type="text" class="form-control" name="nom_plan" id="nom_plan" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipo_plan" class="form-label">TIPO DE PLAN:</label>
                            <select class="form-control" name="tipo_plan" id="tipo_plan" required>
                                <option disabled selected>-SELECCIONE EL TIPO DE PLAN-</option>
                                <option value="TV">TV CABLE</option>
                                <option value="WIFI">WIFI</option>
                                <option value="TV_WIFI">TV CABLE + WIFI</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_inst" class="form-label">PRECIO DE INSTALACION:</label>
                            <input type="number" class="form-control" name="pre_inst" id="pre_inst" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_mens" class="form-label">PRECIO DE MENSUALIDAD:</label>
                            <input type="text" class="form-control" name="pre_mens" id="pre_mens" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_pts_inst_xtr" class="form-label">PRECIO POR PUNTO EXTRA <b class="text-danger">(INSTALACION)</b>:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pre_pts_inst_xtr" id="pre_pts_inst_xtr" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_pts_xtr" class="form-label">PRECIO POR PUNTO EXTRA <b class="text-primary">(NORMAL)</b>:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pre_pts_xtr" id="pre_pts_xtr" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pre_pts_xtr_sol" class="form-label">PRECIO POR PUNTO EXTRA <b class="text-success">(POR SOLICITUD)</b>:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pre_pts_xtr_sol" id="pre_pts_xtr_sol" value="0" required>
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Editar plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarCanales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar lista de canales</h4>
            </div>
            <form action="{{ route('asigna.canales') }}" method="POST" data-parsley-validate id="canal">
                @csrf
                <input type="hidden" name="id_plan" id="id_plan" value="">
                <div class="modal-body" id="div_planCanales"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalListarCanales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista de canales</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="div_lista"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function editarCanales(plan) {
        $('#canal #id_plan').val(plan.ID_PLAN);
        $.ajax({
            url: "{{ url('plan/plan-canales') }}/" + plan.ID_PLAN,
            dataType: 'html',
            success: function (data) {
                $('#div_planCanales').html(data);
                $('#modalEditarCanales').modal('show');
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function listaCanales(canales) {
        var html = '';
        canales.forEach(function (c) {
            html += '<div class="col-md-6 col-xs-6"><div class="panel panel-default bg-gray"><div class="panel-body"><div class="row col-md-12"><div class="col-md-6">';
            if (c.IMG_CAN != null && c.IMG_CAN !== '') {
                html += '<img width="60" height="30" src="{{ asset('storage') }}/' + c.IMG_CAN + '">';
            } else {
                html += '<span class="badge bg-default">SIN LOGO</span>';
            }
            html += '</div><div class="col-md-6">CANAL: <b>' + c.NOM_CAN + '</b></div></div></div></div></div>';
        });
        $('#div_lista').html(html);
        $('#modalListarCanales').modal('show');
    }

    function modalEdita(plan) {
        $('#update #id_plan').val(plan.ID_PLAN);
        $('#update #nom_plan').val(plan.NOM_PLAN);
        $('#update #tipo_plan').val(plan.TIPO_PLAN);
        $('#update #pre_inst').val(plan.PRE_INST);
        $('#update #pre_pts_xtr').val(plan.PRE_PTS_XTR);
        $('#update #pre_pts_inst_xtr').val(plan.PRE_PTS_INST_XTR);
        $('#update #pre_pts_xtr_sol').val(plan.PRE_PTS_XTR_SOL);
        $('#update #pre_mens').val(plan.PRE_MENS);
        $('#modalEdita').modal('show');
    }
</script>
@endsection
