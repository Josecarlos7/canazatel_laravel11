@extends('layouts.master')
@section('asignacion', 'active')
@section('title', 'ASIGNACION DE TECNICOS')
@section('content')

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach ($sucursales as $index => $sucursal)
        <li class="{{ $index == 0 ? 'active' : '' }}" onclick="clientes({{ $sucursal->ID_SUC }})"><a href="#sucursal_{{ $sucursal->ID_SUC }}" data-toggle="tab">{{ $sucursal->NOM_SUC }}</a></li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($sucursales as $index => $sucursal)
        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="sucursal_{{ $sucursal->ID_SUC }}">
            <div id="div_sucursal_{{ $sucursal->ID_SUC }}"></div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="modalConfirma">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">CONFIRMACION DE ASIGNACION</h4>
            </div>
            <form id="form_confirma_asignacion">
                @csrf
                <input type="hidden" name="id_suc" id="id_suc_asignacion">
                <div class="modal-body">
                    <div class="alert alert-danger text-center">
                        <h3>ESTA SEGURO QUE DESEA ASIGNAR LOS</h3>
                        <span class="badge bg-black"><h2 id="badge_contador_asignacion" style="margin:0;"></h2></span>
                        <h3>CLIENTES SELECCIONADOS?</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="button" class="btn btn-danger" id="bt_asigna" onclick="asignar();"><i class="fa fa-check"></i> Asignar clientes</button>
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
                <h4 class="modal-title">CONFIRMACION DE ELIMINACION</h4>
            </div>
            <form id="form_confirma_eliminacion">
                @csrf
                <input type="hidden" name="id_suc" id="id_suc_eliminacion">
                <input type="hidden" name="id_con" id="id_con_eliminacion">
                <div class="modal-body">
                    <div class="alert alert-danger text-center">
                        <h3>ESTA SEGURO QUE DESEA ELIMINAR LA ASIGNACION?</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="button" class="btn btn-danger" id="bt_elimina" onclick="eliminar();"><i class="fa fa-check"></i> Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){
    var primero = {!! json_encode($sucursales->toArray()) !!};
    if (primero.length > 0) {
        clientes(primero[0].ID_SUC);
    }
});

function clientes(id_suc){
    $.ajax({
        url: "{{ url('asignacion/clientes/pendientes') }}/" + id_suc,
        dataType: 'HTML',
        beforeSend: function(){
            $('#div_sucursal_' + id_suc).html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>');
        },
        success: function(data){
            $('#div_sucursal_' + id_suc).html(data);
        },
        error: function(data){
            console.log(data);
        }
    });
}

function modalConfirma(id_suc){
    var contador = 0;
    $('#form_asignacion_' + id_suc + ' .ch').each(function(){
        if ($(this).is(':checked')) {
            contador++;
        }
    });

    if (contador === 0) {
        info_message('Debe seleccionar al menos un cliente');
        return false;
    }

    $('#badge_contador_asignacion').html(contador);
    $('#id_suc_asignacion').val(id_suc);
    $('#modalConfirma').modal('show');
}

function modalElimina(id_suc, id_con){
    $('#id_suc_eliminacion').val(id_suc);
    $('#id_con_eliminacion').val(id_con);
    $('#modalElimina').modal('show');
}

function asignar(){
    var id_suc = $('#id_suc_asignacion').val();
    $.ajax({
        url: "{{ route('asignacion.asigna') }}",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        dataType: 'JSON',
        type: 'POST',
        data: $('#form_asignacion_' + id_suc).serialize(),
        beforeSend: function(){
            $('#bt_asigna').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled', true);
        },
        success: function(data){
            success_message('Clientes asignados correctamente');
            $('#bt_asigna').html('<i class="fa fa-check"></i> Asignar clientes').attr('disabled', false);
            $('#modalConfirma').modal('hide');
            clientes(data);
        },
        error: function(data){
            $('#bt_asigna').html('<i class="fa fa-check"></i> Asignar clientes').attr('disabled', false);
            if (data.status && data.status === 500) {
                error_message(JSON.parse(data.responseText));
            } else {
                error_message('Algo salio mal, refresque el navegador e intentelo nuevamente');
            }
        }
    });
}

function eliminar(){
    var id_suc = $('#id_suc_eliminacion').val();
    $.ajax({
        url: "{{ route('asignacion.elimina') }}",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        dataType: 'JSON',
        type: 'POST',
        data: $('#form_confirma_eliminacion').serialize(),
        beforeSend: function(){
            $('#bt_elimina').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled', true);
        },
        success: function(data){
            success_message('Clientes eliminados correctamente');
            $('#bt_elimina').html('<i class="fa fa-check"></i> Eliminar').attr('disabled', false);
            $('#modalElimina').modal('hide');
            clientes(data);
        },
        error: function(data){
            $('#bt_elimina').html('<i class="fa fa-check"></i> Eliminar').attr('disabled', false);
            if (data.status && data.status === 500) {
                error_message(JSON.parse(data.responseText));
            } else {
                error_message('Algo salio mal, refresque el navegador e intentelo nuevamente');
            }
        }
    });
}
</script>
@endsection
