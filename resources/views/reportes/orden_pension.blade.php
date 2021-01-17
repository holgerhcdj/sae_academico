<table>
	<tbody>
		<?php $c=1;?>
		@foreach($orden as $ord)
		<?php
		if(substr($ord->codigo,0,2)=='MT'){
			$pref='1';
		}else{
			$pref='';
		}
		?>
		<tr>
			<td width="10px" >CO</td>
			<td width="15px" align="right">{{ $ord->est_cedula.$pref }}</td>
			<td>USD</td>
			<td>{{ $ord->valor }}</td>			
			<td>REC</td>
			<td></td>			
			<td></td>
			<td>{{ $ord->codigo }}</td>			
			<td>N</td>
			<td></td>			
			<td width="50px" >{{ $ord->est_apellidos." ".$ord->est_nombres }}</td>

		</tr>
		@endforeach
	</tbody>
</table>