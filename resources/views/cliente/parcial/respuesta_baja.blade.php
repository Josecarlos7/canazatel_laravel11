@if (count($deudas->all()) !== 0)
<div class="col-md-12 alert alert-danger text-center"><h4><i class="fa fa-exclamation-triangle"></i><br> EL CLIENTE TIENE DEUDAS PENDIENTES</h4></div>
<table class="table table-bordered table-hover table-striped">
    @foreach ($deudas->all() as $deuda)
    <tr>
        <td class="bg-danger" colspan="2">DEUDA MENSUALIDAD</td>
        <td class="bg-danger" colspan="2">{{ $deuda['año'].'/'.$deuda['mes'] }}</td>
    </tr>
    @endforeach
</table>
@else
<div class="col-md-12 alert alert-success text-center"><h4><i class="fa fa-check-circle"></i><br> CONTRATO DADO DE BAJA EXITOSAMENTE</h4></div>
@endif
