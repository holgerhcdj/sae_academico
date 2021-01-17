<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<style>
html { overflow: auto; padding: 0.5in; }
html { background: #999;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
body { box-sizing: border-box;margin: 0 auto;overflow:hidden;padding:0.5in;width: 8.5in;}
table tr td{
	font-size:11px; 
	font-family: Arial, Helvetica, sans-serif;
	border-bottom:solid 1px #ccc; 
}	
table{
		border-collapse:collapse; 
}
		/* cuando vayamos a imprimir ... */
		@media print{
			*{ -webkit-print-color-adjust: exact; }
			html,body { background: none; padding: 0; }
			/* indicamos el salto de pagina */
			.saltoDePagina{
				display:block;
				page-break-before:always;
			}
		}
	</style>
</head>

            <span><img width="50px" src="{{ asset('img/logo_institucional_sae.png') }}"></span>
        <header style="margin-top:-50px">
            <h3 style="padding:5px;text-align:center;">RESUMEN POR CURSOS</h3>
            <label style="font-size:10px; "><?php echo "Fecha Impresión: ".date("d-m-Y H:i")?></label>
        </header>
<body>
	<table >
		<thead>
			<tr>
				<th colspan="6" style="background:black;color:white; ">{{$rubro[0]->rub_descripcion}}</th>
			</tr>
			<tr>
				<th width="10px">No</th>
				<th width="130px">Jornada</th>
				<th width="100px">Curso</th>
				<th width="350px">Estudiante</th>
				<th width="35px">Pago</th>
				<th width="35px">Saldo</th>
			</tr>
		</thead>
		<tbody>
			<?php $t=0;$c=1;$x=1;?>
			@foreach($pagoRubros as $pagoRubros)
			<?php 

            if($rubro[0]->rub_id==4 && ($pagoRubros->jor_id==2 || $pagoRubros->jor_id==3 ) ){
                $rubro[0]->rub_valor=20;
            }

			$saldo=number_format($rubro[0]->rub_valor-$pagoRubros->pago,2);
			$pagado=$pagoRubros->pago;
            if($pagoRubros->pgr_tipo==1){
                $saldo="-";
                $pagado="-";
            }


			$t+=$pagoRubros->pago;
			$c++;
			if($c==35){
			?>
			<tr>
				<td colspan="6">
					<div class="saltoDePagina"></div>
				</td>
			</tr>
			<?php
			$c=0;
		}
		?>
		<tr>
			<td>{{$x++}}</td>
			<td>{!! $pagoRubros->jor_descripcion !!}</td>
			<td>{!! $pagoRubros->cur_descripcion ." (".$pagoRubros->mat_paralelo.")" !!}</td>
			<td>{!! $pagoRubros->est_apellidos ." ".$pagoRubros->est_nombres !!}</td>
			<td style="text-align:right" >{!! ($pagado) !!}</td>

			<td style="text-align:right" >{!! ($saldo) !!}</td>
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td style="text-align:right;font-weight:bolder;" colspan="4">Total</td>
			<td style="text-align:right;font-weight:bolder;">{{number_format($t,2)}}</td>
		</tr>
	</tfoot>
</table>

</body>
</html>