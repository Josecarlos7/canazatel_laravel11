@extends('layouts.master')
@section('cliente','active')
@section('title','NUEVO CLIENTE')
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">NUEVO CLIENTE</h3>
    </div>
    <div class="box-body">
        <form id="form_cliente" data-parsley-validate>
            @csrf
            <input type="hidden" name="id_suc" value="{{ $sucursal->ID_SUC }}">
            <div class="row">
                <div class="form-group col-md-3">
                    <label>CODIGO DEL CLIENTE</label>
                    <input type="number" class="form-control" name="num_cli" id="num_cli" required>
                </div>
                <div class="form-group col-md-3">
                    <label>INICIAL SUCURSAL</label>
                    <input type="text" class="form-control" value="-{{ $sucursal->ABR_SUC }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>NOMBRES</label>
                    <input type="text" class="form-control" name="nom_cli" id="nom_cli" required>
                </div>
                <div class="form-group col-md-3">
                    <label>APELLIDOS</label>
                    <input type="text" class="form-control" name="ape_cli" id="ape_cli" required>
                </div>

                <div class="form-group col-md-3">
                    <label>CI / NIT</label>
                    <input type="text" class="form-control" name="ci_cli" id="ci_cli" required>
                </div>
                <div class="form-group col-md-3">
                    <label>CELULAR</label>
                    <input type="text" class="form-control" name="cel_cli" id="cel_cli" required>
                </div>
                <div class="form-group col-md-3">
                    <label>TELEFONO</label>
                    <input type="text" class="form-control" name="tel_cli" id="tel_cli">
                </div>
                <div class="form-group col-md-3">
                    <label>SUCURSAL</label>
                    <input type="text" class="form-control" value="{{ $sucursal->NOM_SUC }}" disabled>
                </div>

                <div class="form-group col-md-6">
                    <label>DIRECCION</label>
                    <input type="text" class="form-control" name="dir_cli" id="dir_cli" required>
                </div>
                <div class="form-group col-md-6">
                    <label>DESCRIPCION DIRECCION</label>
                    <textarea class="form-control" name="des_dir" id="des_dir" rows="2"></textarea>
                </div>

                <input type="hidden" name="lat_cli" id="lat_cli" value="">
                <input type="hidden" name="lng_cli" id="lng_cli" value="">

                <div class="col-md-12"><h4 class="text-primary">PERSONA DE REFERENCIA</h4></div>
                <div class="form-group col-md-4">
                    <label>NOMBRE Y APELLIDO</label>
                    <input type="text" class="form-control" name="nom_pr" id="nom_pr" required>
                </div>
                <div class="form-group col-md-4">
                    <label>CI</label>
                    <input type="text" class="form-control" name="ci_pr" id="ci_pr" required>
                </div>
                <div class="form-group col-md-4">
                    <label>CELULAR</label>
                    <input type="text" class="form-control" name="cel_pr" id="cel_pr" required>
                </div>

                <div class="col-md-12" style="background:#f7f7c6; padding:10px; margin:10px 0;">
                    <strong>REQUISITOS</strong>
                    <div class="checkbox"><label><input type="checkbox" name="fot_ci" value="SI"> Fotocopia de carnet</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="fot_luz" value="SI"> Fotocopia de luz</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="fot_agu" value="SI"> Fotocopia de agua</label></div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ url('/cliente') }}" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i> Volver</a>
                <button type="submit" class="btn btn-primary" id="btn_registra"><i class="fa fa-check"></i> Registrar cliente</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalExiste">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">CLIENTE YA REGISTRADO</h4>
            </div>
            <div class="modal-body">
                <div class="alert bg-blue text-center">
                    <h4>CODIGO O CI/NIT EXISTENTES</h4>
                    <p><b>CODIGO:</b> <span id="txt_cod"></span></p>
                    <p><b>NOMBRE:</b> <span id="txt_nom"></span></p>
                    <p><b>CI/NIT:</b> <span id="txt_ci"></span></p>
                    <p><b>DIRECCION:</b> <span id="txt_dir"></span></p>
                    <a href="#" id="btn_informacion" class="btn btn-success btn-block"><i class="fa fa-info-circle"></i> IR AL PERFIL DEL CLIENTE</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
@if ($sw)
$('#form_cliente #nom_cli').val(@json($sw->NOM_SW));
$('#form_cliente #ape_cli').val(@json($sw->APE_SW));
$('#form_cliente #ci_cli').val(@json($sw->CI_SW));
$('#form_cliente #cel_cli').val(@json($sw->CEL_SW));
$('#form_cliente #tel_cli').val(@json($sw->TEL_SW));
$('#form_cliente #dir_cli').val(@json($sw->DIR_SW));
$('#form_cliente #des_dir').val(@json($sw->DES_SW));
$('#form_cliente #lat_cli').val(@json($sw->LAT_SW));
$('#form_cliente #lng_cli').val(@json($sw->LNG_SW));
@endif

$('#form_cliente').on('submit', function(ev){
    ev.preventDefault();
    if (!$(this).parsley().isValid()) {
        return false;
    }

    $.ajax({
        url: "{{ route('cliente.store') }}",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        type: 'POST',
        dataType: 'json',
        data: $('#form_cliente').serialize(),
        beforeSend: function(){
            $('#btn_registra').html('<i class="fa fa-spinner fa-pulse"></i> Registrando...').prop('disabled', true);
        },
        success: function(data){
            if (Array.isArray(data) && data[0] === 'existe') {
                $('#txt_nom').html(data[1].NOM_CLI + ' ' + data[1].APE_CLI);
                $('#txt_ci').html(data[1].CI_CLI);
                $('#txt_cod').html(data[1].COD_CLI);
                $('#txt_dir').html(data[1].DIR_CLI);
                $('#btn_informacion').attr('href', "{{ url('cliente/informacion') }}/" + data[1].ID_CLI);
                $('#modalExiste').modal('show');
                $('#btn_registra').html('<i class="fa fa-check"></i> Registrar cliente').prop('disabled', false);
                return;
            }

            success_message('Cliente registrado exitosamente');
            window.location.href = "{{ url('cliente/informacion') }}/" + data.ID_CLI;
        },
        error: function(data){
            console.log(data);
            error_message('Algo salio mal, refresque el navegador e intente nuevamente');
            $('#btn_registra').html('<i class="fa fa-check"></i> Registrar cliente').prop('disabled', false);
        }
    });

    return false;
});
</script>
@endsection
