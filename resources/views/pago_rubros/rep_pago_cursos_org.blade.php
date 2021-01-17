<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
	<style>
body { width: 8.5in;height: 11in}

.mrg_salto{
	width:130%;
	margin-left:-100px;
	background: #888;
}
.cont_table{
	height: 11in;
}
table tbody td{
	font-size:10px; 
}
/* cuando vayamos a imprimir ... */
@media print{
	*{ -webkit-print-color-adjust: exact; }
	html{ background: none; padding: 0; }
	body{ box-shadow: none; margin: 0; }
	.mrg_salto{
		display:none; 
	}
	/* indicamos el salto de pagina */
	.saltoDePagina{
		display:block;
		page-break-before:always;
	}
}
@page { margin: 0;}
</style>	
</head>
<body>
			<span><img width="50px" src="{{ asset('img/logo_institucional_sae.png') }}"></span>
		<header>
			<label style="font-size:10px; "><?php echo "Fecha Impresión: ".date("d-m-Y H:i")?></label>
		</header>
	<div class="cont_table">
		<table >
			<thead>
				<tr>
					<th width="10px">No</th>
					<th width="100px">Jornada</th>
					<th width="100px">Curso</th>
					<th width="250px">Estudiante</th>
					<th width="35px">Pagado</th>
					<th width="35px">Saldo</th>
				</tr>
			</thead>
			<tbody>
				<?php $t=0;$c=1;?>
				@foreach($pagoRubros as $pagoRubros)
				<?php $t+=$pagoRubros->pago;?>
				<tr>
					<td>{{$c++}}</td>
					<td>{!! $pagoRubros->jor_descripcion !!}</td>
					<td>{!! $pagoRubros->cur_descripcion ." (".$pagoRubros->mat_paralelo.")" !!}</td>
					<td>{!! $pagoRubros->est_apellidos ." ".$pagoRubros->est_nombres !!}</td>
					<td style="text-align:right" >{!! number_format($pagoRubros->pago,2) !!}</td>
					<td style="text-align:right" >{!! number_format($rubro[0]->rub_valor-$pagoRubros->pago,2) !!}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3"></th>
					<th class="text-right text-danger">Total Recaudado</th>
					<th id="th_total" class="text-danger">{{ number_format($t,2) }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</body>
</html>
