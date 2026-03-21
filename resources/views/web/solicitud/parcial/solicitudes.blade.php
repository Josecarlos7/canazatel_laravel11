@if (count($solicitudes)!=0)
<table class="table table-bordered table-hover table-striped">
	<tr>
		<th>#</th>
		<th>NOMBRE</th>
		<th>CI / NIT</th>
		<th>CELULAR</th>
		<th>TELEFONO</th>
		<th>DIRECCIÓN</th>
		<th>DESCRIPCION</th>
		<th>FECHA|HORA</th>
		<th>ACCIONES</th>
	</tr>
	@foreach ($solicitudes as $index=>$solicitud)
	<tr>
		<td>{{$index+1}}</td>
		<td>{{$solicitud->NOM_SW.' '.$solicitud->APE_SW}}</td>
		<td>{{$solicitud->CI_SW}}</td>
		<td>{{$solicitud->CEL_SW}}</td>
		<td>{{$solicitud->TEL_SW}}</td>
		<td>{{$solicitud->DIR_SW}}</td>
		<td>{{$solicitud->DES_SW}}</td>
		<td>{{$solicitud->FEC_SW.' | '.$solicitud->HOR_SW}}</td>
		<td><a  href="{{url('cliente/nuevo/'.$sucursal->ID_SUC.'/'.$solicitud->ID_SW)}}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button></td>
	</tr>
	@endforeach
</table>
@else
<h4 class="text-center text-muted">NO SE REGISTRARON SOLICITUDES EN ESTA SUCURSAL</h4>
@endif
