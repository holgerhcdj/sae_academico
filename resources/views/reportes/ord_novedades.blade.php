<style>
	*{
		font-size:10px;
		font-family:Comic Sans;  
	}
	th,td{
		border:solid 1px #000; 
	}
	table{
		border-collapse: collapse;
	}
	#titulo{
		font-size:16px; 
	}


.footer {
    width: 100%;
    text-align: left;
    position: fixed;
}
.footer {
    top: -30px;
    left:-20px;
}

</style>
<table class="table" >
	<caption id="titulo">ORDEN NO:{{ $noorden }}</caption>
	<thead>
		<tr>
			<th>No</th>
			<th>JORNADA</th>
			<th>ESPECIALIDAD</th>
			<th>CURSO</th>
			<th>PARALELO</th>
			<th>CEDULA</th>
			<th>ESTUDIANTE</th>
			<th>CODIGO</th>                                
			<th>VALOR</th>                                
			<th>MOTIVO</th>
		</tr>
	</thead>
	<tbody>
		<?php $c=1;?>
		@foreach($orden as $o)
		   <tr>
		   	<td>{{ $c++ }}</td>
		   	<td>{{ $o->jor_descripcion }}</td>
		   	<td>{{ $o->esp_descripcion }}</td>
		   	<td>{{ $o->cur_descripcion }}</td>
		   	<td>{{ $o->mat_paralelot }}</td>
		   	<td>{{ $o->est_cedula }}</td>
		   	<td>{{ $o->est_apellidos." ".$o->est_nombres }}</td>
		   	<td>{{ $o->codigo }}</td>
		   	<td>{{ $o->valor }}</td>
		   	<td>{{ $o->motivo }}</td>

		   </tr>
		@endforeach
	</tbody>
</table>

<div class="footer">
    <span class="pagenum">SAE-VN 2018/2019</span>
</div>
