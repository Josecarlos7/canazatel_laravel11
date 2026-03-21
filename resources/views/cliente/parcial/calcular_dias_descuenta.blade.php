@php
	$sub_total=($cliente->PRE_MENS ) + ($cliente->PTS_XTR * $cliente->PRE_PTS_XTR);
@endphp
<input type="hidden" name="monto" id="monto_d" value="">
<input type="hidden" name="dias" id="dias_i" value="">
<div>
	<table class="table table-bordered text-center">
		<tr class="bg-warning">
			<th>DIAS</th>
			<th>CALCULO</th>
			<th>DESCUENTO</th>
			<th>MONTO A PAGAR</th>
		</tr>
		<tr class="bg-warning">
			<td>
			<input type="number" name="dias" id="dias_ipt" class="form-control" value="0" onkeyup="calcular_descuento(this.value)">
			</td>
			<td>
				<h4><b id="dias_d">0</b> dias * ( {{$sub_total}} Bs. / 30 dias )</h4>
			</td>
			<td>
				<h4 id="descuento">0</h4>
			</td>
			<td><h4 id="total_pagar">0</h4></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	function calcular_descuento(dias){
		var total=dias*({{$sub_total}}/30);
		if (total % 1 != 0) {
			total = total.toFixed();
		}
		var total_pagar={{$sub_total}}-total;
		console.log(total);
		$('#dias_d').html(dias);
		$('#descuento').html(total);
		$('#total_pagar').html(total_pagar);
		$('#dias_i').val(dias);
		$('#monto_d').val(total_pagar);
	}
</script>