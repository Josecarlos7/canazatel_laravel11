<div>
	<input type="hidden" name="monto" id="monto" value="">
	<table class="table table-bordered text-center">
		<tr class="bg-warning">
			<th>PUNTOS EXTRA</th>
			<th>CALCULO</th>
			<th>MONTO A PAGAR</th>
		</tr>
		<tr class="bg-warning">
			<td>
			<input type="text" name="puntos" id="puntos" class="form-control onumeros" value="1" onkeyup="calcular_pts_xtr(this.value)">
			</td>
			<td>
				<h4><b id="pts">1</b> * {{$cliente->PRE_PTS_XTR_SOL}} Bs.</h4>
			</td>
			<td><h4><b id="total">{{1*$cliente->PRE_PTS_XTR_SOL}}</b> Bs.</h4></td>
		</tr>
	</table>
	<p class="text-primary">* Debe ingresar numeros mayores a 0</p>
</div>
<script type="text/javascript">
	function calcular_pts_xtr(puntos){
		var total=puntos*{{$cliente->PRE_PTS_XTR_SOL}};
		
		$('#pts').html(puntos);
		$('#total').html(total);
		$('#monto').val(total);
	}

	$(".onumeros").bind('keypress', function(event) {
		var regex = new RegExp("^[0-9]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		console.log(key);

		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});
</script>