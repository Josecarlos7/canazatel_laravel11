@extends('layouts.master')
@section('material','active')
@section('title','MATERIALES REGISTRADOS')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">MATERIALES REGISTRADOS</h3>
    </div>
    <div class="box-body">
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> NUEVO MATERIAL</button>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-sm datatable">
                <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>MATERIAL</th>
                        <th class="text-center">STOCK</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materiales as $numero => $material)
                    <tr>
                        <td>{{ $numero + 1 }}</td>
                        <td>{{ $material->NOM_MAT }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ ($material->STK_MAT ?? 0) == 0 ? 'red' : 'blue' }}">{{ $material->STK_MAT ?? 0 }} /U.</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" type="button" onclick='modalEdita(@json($material))'><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-sm btn-success" type="button" onclick='modalAgregaStock(@json($material))'><i class="fa fa-plus"></i></button>
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
                <h4 class="modal-title">Nuevo Material</h4>
            </div>
            <form action="{{ url('/material') }}" method="POST" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="nom_mat" class="form-label">NOMBRE DEL MATERIAL:</label>
                            <input type="text" class="form-control may" name="nom_mat" placeholder="Ingrese el nombre del material" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar material</button>
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
                <h4 class="modal-title">Edita Material</h4>
            </div>
            <form action="{{ route('material.actualiza') }}" method="POST" id="update" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_mat" id="id_mat">
                <div class="modal-body">
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="nom_mat" class="form-label">NOMBRE DEL MATERIAL:</label>
                            <input type="text" class="form-control may" name="nom_mat" id="nom_mat" placeholder="Ingrese el nombre del material" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Edita material</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregaStock">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Stock</h4>
            </div>
            <form action="{{ route('material.agregaStock') }}" method="POST" id="form_stock" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_mat" id="id_mat">
                <div class="modal-body">
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="cnt_inv" class="form-label">CANTIDAD:</label>
                            <input type="number" min="1" class="form-control may" name="cnt_inv" id="cnt_inv" placeholder="Ingrese cantidad a de Stock" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function modalEdita(material) {
        $('#update #id_mat').val(material.ID_MAT);
        $('#update #nom_mat').val(material.NOM_MAT);
        $('#modalEdita').modal('show');
    }

    function modalAgregaStock(material) {
        $('#form_stock #id_mat').val(material.ID_MAT);
        $('#modalAgregaStock').modal('show');
    }
</script>
@endsection
