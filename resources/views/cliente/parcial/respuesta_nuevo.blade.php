@if ($existe)
<div class="col-md-12 alert alert-danger text-center"><h4><i class="fa fa-exclamation-triangle"></i><br> EL CLIENTE TODAVIA TIENE UN CONTRATO ACTIVO</h4></div>
<table class="table table-bordered table-hover text-center">
    <tr class="bg-gray">
        <th>FECHA INICIO</th>
        <th>TIPO DE PAGO</th>
        <th>ESTADO</th>
    </tr>
    <tr>
        <td>{{ $existe->FEC_SOL }}</td>
        <td>{{ $existe->TIPO_PAGO }}</td>
        <td>{{ $existe->EST_CON }}</td>
    </tr>
</table>
<div class="alert bg-blue">
    <ul>
        <li>Debe cancelar el contrato activo para poder crear uno nuevo</li>
        <li>Tambien debe cancelar las deudas pendientes del contrato activo</li>
    </ul>
</div>
@else
<div class="col-md-12 alert alert-success text-center"><h4><i class="fa fa-check-circle"></i><br> CONTRATO REGISTRADO EXITOSAMENTE</h4></div>
@endif
