@extends('layouts.master')
@section('solicitud','active')
@section('title','SOLICITUD')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ATENDER SOLICITUD</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <form action="{{ route('solicitud.enviar') }}" method="POST" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_sol" value="{{ $solicitud->ID_SOL }}">
                <div class="form-group col-md-6">
                    <label>SUCURSAL:</label>
                    <input type="text" class="form-control" disabled value="{{ $solicitud->NOM_SUC }}">
                </div>
                <div class="form-group col-md-6">
                    <label>USUARIO:</label>
                    <input type="text" class="form-control" disabled value="{{ $solicitud->NOM_USU . ' ' . $solicitud->PAT_USU . ' ' . $solicitud->MAT_USU }}">
                </div>
                <div class="form-group col-md-6">
                    <label>DESCRIPCION:</label>
                    <textarea class="form-control may" disabled>{{ $solicitud->DES_SOL }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>RESPUESTA:</label>
                    <textarea class="form-control may" name="resp_sol" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>ESTADO:</label>
                    <select class="form-control" name="est_sol" required>
                        <option disabled selected>-SELECCIONE UNA OPCION-</option>
                        <option value="ENVIADO">ENVIADO</option>
                        <option value="RECHAZADO">RECHAZADO</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-sm table-striped">
                        <thead>
                            <tr>
                                <th>MATERIAL</th>
                                <th>CANTIDAD</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="body_table">
                            @foreach ($solicitud->detalles as $detalle)
                            <tr>
                                <td>
                                    <input type="text" disabled class="form-control" value="{{ $detalle->NOM_MAT }}">
                                    <input type="hidden" name="id_mat[]" value="{{ $detalle->ID_MAT }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="cant_sm[]" value="{{ $detalle->CANT_SM }}" required>
                                </td>
                                <td>
                                    <button class="btn btn-danger borrar" type="button" title="Quitar Material de la Solicitud"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-warning btn-block" type="submit"><i class="fa fa-check"></i> ENVIAR PEDIDO</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).on('click', '.borrar', function(event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
</script>
@endsection
