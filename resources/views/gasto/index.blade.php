@extends('layouts.master')
@section('gasto','active')
@section('title','GASTOS REGISTRADOS')
@section('content')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach ($sucursales as $index => $sucursal)
        <li class="{{ $index == 0 ? 'active' : '' }}" onclick="gastos({{ $sucursal->ID_SUC }})"><a href="#sucursal_{{ $sucursal->ID_SUC }}" data-toggle="tab">{{ $sucursal->NOM_SUC }}</a></li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($sucursales as $index => $sucursal)
        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="sucursal_{{ $sucursal->ID_SUC }}">
            <div class="row">
                <div class="col-md-6 col-sm-6"><input type="date" class="form-control" id="fecha_{{ $sucursal->ID_SUC }}" value="{{ now()->format('Y-m-d') }}"></div>
                <div class="col-md-6 col-sm-6"><button class="btn btn-warning btn-sm btn-block" type="button" onclick="gastos({{ $sucursal->ID_SUC }})"><i class="fa fa-search"></i> BUSCAR POR FECHA</button></div>
            </div>
            <div id="div_gastos_{{ $sucursal->ID_SUC }}"></div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="modalNuevoGasto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo gasto</h4>
            </div>
            <form action="{{ url('/gasto') }}" method="POST" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="nom_suc" class="form-label">SUCURSAL:</label>
                            <input type="text" class="form-control" id="nom_suc" value="" disabled>
                            <input type="hidden" name="id_suc" id="id_suc" value="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="mot_gas" class="form-label">MOTIVO DEL GASTO:</label>
                            <textarea class="form-control may" name="mot_gas" placeholder="Ingrese la razon del gasto" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cant_gas" class="form-label">MONTO DEL GASTO:</label>
                            <div class="input-group">
                                <input type="number" class="form-control num" name="cant_gas" value="" required>
                                <span class="input-group-addon">.</span>
                                <input type="number" class="form-control num" id="deci_gas" name="deci_gas" value="">
                                <span class="input-group-addon">Bs.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Registrar gasto</button>
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
                <h4 class="modal-title">ELIMINAR GASTO</h4>
            </div>
            <form id="form_elimina_gasto">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_gas" id="id_gas" value="">
                    <div class="alert alert-danger text-center"><h3>¿ESTA SEGURO QUE DESEA ELIMINAR EL GASTO?</h3></div>
                    <div class="alert bg-blue">
                        <ul>
                            <li>El eliminado sera irreversible, asegurese de estar seguro</li>
                        </ul>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                <button type="button" class="btn btn-danger" id="btn_elimina" onclick="eliminar_gasto();"><i class="fa fa-check"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    let id_suc_o = 0;

    $(document).ready(function() {
        var sucursales = @json($sucursales);
        if (sucursales.length > 0) {
            var fecha = $('#fecha_' + sucursales[0].ID_SUC).val();
            gastos(sucursales[0].ID_SUC, fecha);
        }
    });

    $('#deci_gas').keypress(function(e) {
        if (this.value.length >= 1) {
            e.preventDefault();
            return false;
        }
    });

    function gastos(id_suc) {
        var fecha = $('#fecha_' + id_suc).val();
        $.ajax({
            url: "{{ url('gastos/sucursal/') }}" + '/' + id_suc + '/' + fecha,
            dataType: 'HTML',
            beforeSend: function() {
                $('#div_gastos_' + id_suc).html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> CARGANDO...</h4>');
            },
            success: function(data) {
                $('#div_gastos_' + id_suc).html(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function modalNuevoGasto(sucursal) {
        $('#nom_suc').val(sucursal.NOM_SUC);
        $('#id_suc').val(sucursal.ID_SUC);
        $('#modalNuevoGasto').modal('show');
    }

    function modalElimina(gasto) {
        $('#id_gas').val(gasto.ID_GAS);
        id_suc_o = gasto.ID_SUC;
        $('#modalElimina').modal('show');
    }

    function eliminar_gasto() {
        $.ajax({
            url: "{{ route('gasto.elimina') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: 'JSON',
            type: 'POST',
            data: $('#form_elimina_gasto').serialize(),
            beforeSend: function() {
                $('#btn_elimina').html('<i class="fa fa-spinner fa-pulse"></i> Procesando...').attr('disabled', true);
            },
            success: function(data) {
                success_message(data);
                gastos(id_suc_o);
                $('#btn_elimina').html('<i class="fa fa-check"></i> Eliminar').attr('disabled', false);
                $('#modalElimina').modal('hide');
            },
            error: function(data) {
                $('#btn_elimina').html('<i class="fa fa-check"></i> Eliminar').attr('disabled', false);
                if (data.status && data.status == 500) {
                    error_message(JSON.parse(data.responseText));
                } else {
                    error_message('Algo salio mal, refresque el navegador e intentelo nuevamente');
                }
            }
        });
    }
</script>
@endsection
