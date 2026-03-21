@extends('layouts.master')
@section('cliente','active')
@section('title','CLIENTES REGISTRADOS EN EL SISTEMA')
@section('content')

@if ($sucursales->count() === 0)
<div class="alert alert-warning text-center">
    <h4>No hay sucursales registradas para mostrar clientes</h4>
</div>
@else
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach ($sucursales as $index => $sucursal)
        <li class="{{ $index === 0 ? 'active' : '' }}" onclick="clientes({{ $sucursal->ID_SUC }})"><a href="#sucursal_{{ $sucursal->ID_SUC }}" data-toggle="tab">{{ $sucursal->NOM_SUC }}</a></li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($sucursales as $index => $sucursal)
        <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="sucursal_{{ $sucursal->ID_SUC }}">
            <div id="div_sucursal_{{ $sucursal->ID_SUC }}"></div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="modal fade" id="modalElimina">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">INHABILITAR CLIENTE</h4>
            </div>
            <form id="form_elimina">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_cli" id="id_cli">
                    <div class="row text-center">
                        <div class="alert alert-danger text-center"><h4>¿ESTA SEGURO QUE DESEA INHABILITAR AL CLIENTE SELECCIONADO?</h4></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="button" class="btn btn-danger" id="btn_elimina" onclick="eliminaCliente();"><i class="fa fa-check"></i> Inhabilitar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalActiva">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ACTIVAR CLIENTE</h4>
            </div>
            <form id="form_activa">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_cli" id="id_cli">
                    <div class="row text-center">
                        <div class="alert alert-success text-center"><h4>¿ESTA SEGURO QUE DESEA ACTIVAR AL CLIENTE SELECCIONADO?</h4></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" id="btn_activa" onclick="activaCliente();"><i class="fa fa-check"></i> Activar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    var sucursales = @json($sucursales);
    if (sucursales.length > 0) {
        clientes(sucursales[0].ID_SUC);
    }
});

function clientes(id_suc){
    $.ajax({
        url: "{{ url('clientes/sucursal') }}/" + id_suc,
        dataType: 'html',
        beforeSend: function(){
            $('#div_sucursal_' + id_suc).html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>');
        },
        success: function(data){
            $('#div_sucursal_' + id_suc).html(data);
        },
        error: function(data){
            console.log(data);
            error_message('No se pudo cargar la lista de clientes');
        }
    });
}

function modalElimina(id_cli){
    $('#form_elimina #id_cli').val(id_cli);
    $('#modalElimina').modal('show');
}

function eliminaCliente(){
    $.ajax({
        url: "{{ route('cliente.elimina') }}",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        dataType: 'json',
        type: 'POST',
        data: $('#form_elimina').serialize(),
        beforeSend: function(){
            $('#btn_elimina').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled', true);
        },
        success: function(data){
            success_message('Cliente inhabilitado');
            $('#btn_elimina').html('<i class="fa fa-check"></i> Inhabilitar Cliente').attr('disabled', false);
            $('#modalElimina').modal('hide');
            clientes(data);
        },
        error: function(data){
            console.log(data);
            $('#btn_elimina').html('<i class="fa fa-check"></i> Inhabilitar Cliente').attr('disabled', false);
            error_message('Algo salio mal, refresque el navegador e intente nuevamente');
        }
    });
}

function modalActiva(id_cli){
    $('#form_activa #id_cli').val(id_cli);
    $('#modalActiva').modal('show');
}

function activaCliente(){
    $.ajax({
        url: "{{ route('cliente.activa') }}",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        dataType: 'json',
        type: 'POST',
        data: $('#form_activa').serialize(),
        beforeSend: function(){
            $('#btn_activa').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled', true);
        },
        success: function(data){
            success_message('Cliente reactivado exitosamente');
            $('#btn_activa').html('<i class="fa fa-check"></i> Activar Cliente').attr('disabled', false);
            $('#modalActiva').modal('hide');
            clientes(data);
        },
        error: function(data){
            console.log(data);
            $('#btn_activa').html('<i class="fa fa-check"></i> Activar Cliente').attr('disabled', false);
            error_message('Algo salio mal, refresque el navegador e intente nuevamente');
        }
    });
}
</script>
@endsection
