@extends('layouts.master')
@section('solicitud','active')
@section('title','SOLICITUDES REALIZADAS')
@section('content')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach ($sucursales as $index => $sucursal)
        <li class="{{ $index == 0 ? 'active' : '' }}" onclick="solicitudes({{ $sucursal->ID_SUC }})"><a href="#sucursal_{{ $sucursal->ID_SUC }}" data-toggle="tab">{{ $sucursal->NOM_SUC }}</a></li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($sucursales as $index => $sucursal)
        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="sucursal_{{ $sucursal->ID_SUC }}">
            <div id="div_solicitudes_{{ $sucursal->ID_SUC }}"></div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="modalSolicitud">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva solicitud</h4>
            </div>
            <form action="{{ url('/solicitud') }}" method="POST" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_suc" id="id_suc" value="">
                <div class="modal-body">
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="nom_suc" class="form-label">SUCURSAL:</label>
                            <input type="text" class="form-control may" name="nom_suc" id="nom_suc" value="" disabled>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="des_sol" class="form-label">DETALLE DE LA SOLICITUD:</label>
                            <textarea class="form-control may" name="des_sol"></textarea>
                        </div>

                        <table class="table table-bordered table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>MATERIAL</th>
                                    <th>DISPONIBLE</th>
                                    <th>CANTIDAD</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="body_table">
                                <tr>
                                    <td>
                                        <select class="form-control material" name="id_mat[]" id="id_mat_1" onchange="buscaMaterial(1); valida(this.value);" required>
                                            <option disabled selected>-ESCOJA UN MATERIAL-</option>
                                            @foreach ($materiales as $material)
                                            <option value="{{ $material->ID_MAT }}">{{ $material->NOM_MAT }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="disponible_1" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="cant_sm[]" id="cantidad_1" value="0" onkeyup="valida_cantidad(1)" required>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" type="button" onclick="agregar();"><i class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRecepcion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Recepcion de solicitud</h4>
            </div>
            <form action="{{ route('solicitud.recepcion') }}" method="POST" data-parsley-validate>
                @csrf
                <input type="hidden" name="id_sol" id="id_sol" value="">
                <div class="modal-body">
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="resp_rec" class="form-label">RESPUESTA DE RECEPCION DE LA SOLICITUD:</label>
                            <textarea class="form-control" name="resp_rec"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Recepcionar Solicitud</button>
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
                <h4 class="modal-title">ELIMINAR SOLICITUD</h4>
            </div>
            <form method="POST" action="{{ route('solicitud.elimina') }}" id="elimina">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_sol" id="id_sol" value="">
                    <div class="alert alert-danger text-center"><h3>¿ESTA SEGURO QUE DESEA ELIMINAR LA SOLICITUD?</h3></div>
                    <div class="alert bg-blue">
                        <ul>
                            <li>La eliminacion de la solicitud sera permanente</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var sucursales = @json($sucursales);
        if (sucursales.length > 0) {
            solicitudes(sucursales[0].ID_SUC);
        }
    });

    function solicitudes(id_suc) {
        $.ajax({
            url: "{{ url('solicitudes/sucursal/') }}" + '/' + id_suc,
            dataType: 'HTML',
            beforeSend: function() {
                $('#div_solicitudes_' + id_suc).html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>');
            },
            success: function(data) {
                $('#div_solicitudes_' + id_suc).html(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function modalSolicitud(sucursal) {
        $('#id_suc').val(sucursal.ID_SUC);
        $('#nom_suc').val(sucursal.NOM_SUC);
        $('#modalSolicitud').modal('show');
    }

    var numero = 2;
    function agregar() {
        $('#body_table').append(
            '<tr>' +
            '<td>' +
            '<select class="form-control material" name="id_mat[]" id="id_mat_' + numero + '" onchange="buscaMaterial(' + numero + '); valida(this.value);" required>' +
            '<option disabled selected>-ESCOJA UN MATERIAL-</option>' +
            @foreach ($materiales as $material)
            '<option value="{{ $material->ID_MAT }}">{{ $material->NOM_MAT }}</option>' +
            @endforeach
            '</select>' +
            '</td>' +
            '<td>' +
            '<input type="number" class="form-control" id="disponible_' + numero + '" value="" readonly>' +
            '</td>' +
            '<td>' +
            '<input type="number" class="form-control" name="cant_sm[]" value="0" id="cantidad_' + numero + '" onkeyup="valida_cantidad(' + numero + ')" required>' +
            '</td>' +
            '<td>' +
            '<button class="btn btn-danger borrar" type="button"><i class="fa fa-minus"></i></button>' +
            '</td>' +
            '</tr>'
        );
        numero++;
    }

    $(document).on('click', '.borrar', function(event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });

    function modalRecepcion(id_sol) {
        $('#modalRecepcion #id_sol').val(id_sol);
        $('#modalRecepcion').modal('show');
    }

    function buscaMaterial(num) {
        var id_mat = $('#id_mat_' + num).val();
        $.ajax({
            url: "{{ url('material/buscaMaterial/') }}" + '/' + id_mat,
            dataType: 'JSON',
            success: function(data) {
                $('#disponible_' + num).val(data.STK_MAT);
                $('#cantidad_' + num).val(0);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function valida(id_mat) {
        var cont = 0;
        $('.material').each(function() {
            if (id_mat == $(this).val()) {
                cont++;
            }
            if (cont > 1) {
                $(this).closest('tr').remove();
            }
        });
    }

    function valida_cantidad(num) {
        var disponible = parseInt($('#disponible_' + num).val() || '0');
        var cantidad = parseInt($('#cantidad_' + num).val() || '0');
        if (cantidad > disponible) {
            $('#cantidad_' + num).val(disponible);
        }
    }

    function modalElimina(solicitud) {
        $('#elimina #id_sol').val(solicitud.ID_SOL);
        $('#modalElimina').modal('show');
    }
</script>
@endsection
