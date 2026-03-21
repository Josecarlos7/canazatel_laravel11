@extends('layouts.master')
@section('alerta', 'active')
@section('title', 'ALERTA')
@section('content')

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach ($sucursales as $index => $sucursal)
        <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#sucursal_{{ $sucursal->ID_SUC }}" data-toggle="tab">{{ $sucursal->NOM_SUC }}</a></li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($sucursales as $index => $sucursal)
        @php
        $planes = \App\Models\SucursalPlan::where('ID_SUC', $sucursal->ID_SUC)
            ->join('plan', 'plan.ID_PLAN', '=', 'sucursal_plan.ID_PLAN')
            ->get();
        @endphp
        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="sucursal_{{ $sucursal->ID_SUC }}">
            <form id="form_{{ $sucursal->ID_SUC }}" class="row">
                <input type="hidden" name="id_suc" value="{{ $sucursal->ID_SUC }}">
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="estado">
                            <option value="ASIGNADOS" selected>ASIGNADOS</option>
                            @foreach ($planes as $plan)
                            <option value="{{ $plan->ID_PLAN }}">{{ $plan->NOM_PLAN }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success btn-block" type="button" onclick="clientes({{ $sucursal->ID_SUC }})"><i class="fa fa-search"></i> BUSCAR</button>
                </div>
            </form>
            <div id="div_sucursal_{{ $sucursal->ID_SUC }}"></div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
function clientes(id_suc){
    $.ajax({
        url: "{{ route('alerta.deudores') }}",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        dataType: 'HTML',
        type: 'POST',
        data: $('#form_' + id_suc).serialize(),
        beforeSend: function(){
            $('#div_sucursal_' + id_suc).html('<h4 class="text-center text-muted"><i class="fa fa-spinner fa-pulse"></i> Procesando...</h4>');
        },
        success: function(data){
            $('#div_sucursal_' + id_suc).html(data);
        },
        error: function(data){
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
