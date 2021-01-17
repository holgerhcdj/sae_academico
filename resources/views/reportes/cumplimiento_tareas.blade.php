<style>
</style>

<table border="1" >
	<tr>
		<th colspan="5" style="text-align:center;">REGISTRO DE CUMPLIMIENTO DE TAREAS DOMICILIARIAS</th>
	</tr>
	<tr>
		<th colspan="2" style="text-align:left  ">ESPECIALIDAD {{$rst[0]->esp_descripcion}}</th>
		<th colspan="3" style="text-align:left  ">CURSO {{$rst[0]->cur_descripcion}}</th>
	</tr>
	<tr>
		<th colspan="2" style="text-align:left  ">SEMANA DEL: {{$rst[0]->tar_finicio.' AL '.$rst[0]->tar_ffin}}</th>
		@if($rst[0]->esp_id==10 ||$rst[0]->esp_id==8 || $rst[0]->esp_id==8)
		<th colspan="3" style="text-align:left  ">PARALELO {{$rst[0]->mat_paralelo}}</th>
		@else
		<th colspan="3" style="text-align:left  ">PARALELO {{$rst[0]->mat_paralelot}}</th>
		@endif
	</tr>
	<tr>
		<th colspan="2" style="text-align:left  ">JORNADA {{$rst[0]->jor_descripcion}}</th>
		<th colspan="3">INDICADORES DE CUMPLIMIENTO</th>
	</tr>
	<tr>
		<td>#</td>
		<td>Estudiante</td>
		<td>Entregado</td>
		<td>Pendiente</td>
		<td>Observaciones</td>
	</tr>
	<?php $x=1;$ent=0;$pend=0;?>
			@foreach($rst as $r)
			<tr>
				<td>{{$x++}}</td>
				<td>{{$r->est_apellidos.' '.$r->est_nombres }}</td>
				@if($r->tru_estado==5)
				<td>{{'SI'}}</td>
				<td></td>
				@else
				<td></td>
				<td>{{'NO'}}</td>
				@endif
				<td></td>
			</tr>
			<?php 
			if($r->tru_estado==5){
				$ent++;
			}else{
				$pend++;
			}
			?>
			@endforeach
	<tr>
		<th colspan="2">Totales: </th>
		<th>{{$ent}}</th>
		<th>{{$pend}}</th>
		<th></th>
	</tr>
	<tr>
		<th colspan="5" style='text-align:right' >Docente: {{Auth::user()->usu_apellidos.' '.Auth::user()->name}}</th>
	</tr>
</table>