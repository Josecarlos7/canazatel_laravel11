@extends('layouts.master')
@section('canal','active')
@section('title','CANALES REGISTRADOS')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">CANALES REGISTRADOS</h3>
    </div>
    <div class="box-body">
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> NUEVO CANAL</button>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-sm datatable">
                <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>IMG</th>
                        <th>CANAL</th>
                        <th>NACIONALIDAD</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($canales as $numero => $canal)
                    <tr>
                        <td>{{ $numero + 1 }}</td>
                        <td>
                            @if ($canal->IMG_CAN == '')
                            <span class="badge bg-default">SIN IMAGEN</span>
                            @else
                            <img src="{{ asset('storage/'.$canal->IMG_CAN) }}" width="60" height="30">
                            @endif
                        </td>
                        <td>{{ $canal->NOM_CAN }}</td>
                        <td>{{ $canal->NAC_CAN }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" type="button" onclick='modalEdita(@json($canal))'><i class="fa fa-pencil"></i></button>
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
                <h4 class="modal-title">Nuevo canal</h4>
            </div>
            <form action="{{ url('/canal') }}" method="POST" data-parsley-validate enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom_can" class="form-label">NOMBRE DEL CANAL:</label>
                            <input type="text" class="form-control may" name="nom_can" placeholder="Ingrese el nombre del canal" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emp_can" class="form-label">EMPRESA DEL CANAL:</label>
                            <input type="text" class="form-control may" name="emp_can" placeholder="Ingrese la empresa del canal">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nac_can" class="form-label">NACIONALIDAD DEL CANAL:</label>
                            <input type="text" class="form-control may" name="nac_can" placeholder="Ingrese la nacionalidad del canal">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="img_can">IMAGEN DEL CANAL:</label>
                            <input type="file" name="img_can" accept="image/*">
                            <p class="help-block">Ingrese una imagen del logo del canal.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar canal</button>
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
                <h4 class="modal-title">Edita canal</h4>
            </div>
            <form action="{{ route('canal.actualiza') }}" method="POST" id="update" data-parsley-validate enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_can" id="id_can" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom_can" class="form-label">NOMBRE DEL CANAL:</label>
                            <input type="text" class="form-control may" name="nom_can" id="nom_can" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emp_can" class="form-label">EMPRESA DEL CANAL:</label>
                            <input type="text" class="form-control may" name="emp_can" id="emp_can">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nac_can" class="form-label">NACIONALIDAD DEL CANAL:</label>
                            <input type="text" class="form-control may" name="nac_can" id="nac_can">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="img_can">IMAGEN DEL CANAL:</label>
                            <input type="file" name="img_can" accept="image/*">
                            <p class="help-block">*Llene este campo solo si desea cambiar la imagen</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Editar canal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function modalEdita(canal) {
        $('#update #id_can').val(canal.ID_CAN);
        $('#update #nom_can').val(canal.NOM_CAN);
        $('#update #emp_can').val(canal.EMP_CAN);
        $('#update #nac_can').val(canal.NAC_CAN);
        $('#modalEdita').modal('show');
    }
</script>
@endsection
