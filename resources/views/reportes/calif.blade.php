<?php
?>
<html>
<style type="text/css">
*{
	font-family: Arial; 
}
	.sub_t td{
		text-align:center; 
		font-weight:bolder !important; 
	}
</style>
<table>
	<thead>
            <tr class="sub_t"><td  colspan="20" >DIRECCION NACIONAL DE REGULACIÓN DE LA EDUCACIÓN</td></tr>
		<tr class="sub_t"><td colspan="20">Anexi 1.- FICHA DE REGISTRO DE EXPEDIENTE ACADÉMICO DE LOS ESTUDIANTES DE TERCER AÑO DE BACHILLERATO</td></tr>
		<tr >
			<td colspan="7"></td>
			<td colspan="3">RÉGIMEN SIERRA</td>
			<td colspan="5"></td>
			<td colspan="5">AÑO LECTIVO</td>
		</tr>
		<tr class="sub_t"><td colspan="20">I. DATOS GENERALES DE LA INSTITUCIÓN EDUCATIVA</td></tr>
		<tr>
			<td colspan="16" >ZONA:9</td>
			<td colspan="4" >DISTRITO:007</td>
		</tr>
		<tr>
			<td colspan="16">NOMBRE DE LA INSTITUCIÓN: UNIDAD EDUCATIVA POPULAR "VIDA NUEVA"</td>
			<td colspan="4">CÓDIGO AMIE: 17H01306</td>
		</tr>
		<tr>
			<td colspan="16">3RO DE BACHILLERATO(BGU): TÉCNICO EN SERVICIOS</td>
			<td colspan="4">FIGURA PROFESIONAL: </td>
		</tr>
		<tr>
			<td colspan="8">RESOLUCIÓN OFERTA EDUCATIVA ACTUALIZADA</td>
			<td colspan="2">SI</td>
			<td colspan="1">X</td>
			<td colspan="2">NO</td>
			<td colspan="3"></td>
			<td colspan="4">PARALELO: </td>
		</tr>
		<tr>
			<td colspan="8">CONSEJO EDUCATIVO REGISTRADO y RATIFICADO EN EL DISTRITO</td>
			<td colspan="2">SI</td>
			<td colspan="1">X</td>
			<td colspan="2">NO</td>
			<td colspan="3"></td>
			<td colspan="4">JORNADA: </td>
		</tr>
		<tr>
			<td colspan="20">FECHA DE VERIFICACIÓN DEL EXPEDIENTE ACADÉMICO:</td>
		</tr>
		<tr class="sub_t"><td colspan="20">II. DE LOS ESTUDIANTES</td></tr>
		<tr>
			<td rowspan="2" >No</td>
			<td rowspan="2" >Apellidos/Nombres</td>
			<td rowspan="2" >No.CÉDULA</td>
			<td colspan="10" >CALIFICACIONES DE EDUCACION GENERAL BÁSICA</td>
			<td colspan="2"  >CALIFICACIONES DE BACHILLERATO</td>
			<td colspan="2"  >PARTICIPACIÓN ESTUDIANTIL</td>
			<td colspan="2"  >EXÁMEN ENNES (carácter informativo)</td>
			<td rowspan="2">OBSERVACIONES</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td >2°</td>
			<td >3°</td>
			<td >4°</td>
			<td >5°</td>
			<td >6°</td>
			<td >7°</td>
			<td >Primaria</td>        
			<td >8°</td>
			<td >9°</td>
			<td >10°</td>
			<td >1°</td>
			<td >2°</td>
			<td >SI</td>
			<td >NO</td>
			<td >SI</td>
			<td >NO</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<?php $x=1?>
		@foreach ($est as $e)
		<tr>
			<td>{{$x++}}</td>
			<td>{{$e->est_apellidos." ".$e->est_nombres }}</td>
			<td>{{$e->est_cedula}}</td>
			<td>{{$e->n2}}</td>
			<td>{{$e->n3}}</td>
			<td>{{$e->n4}}</td>
			<td>{{$e->n5}}</td>
			<td>{{$e->n6}}</td>
			<td>{{$e->n7}}</td>
			<td>{{$e->cert_primaria}}</td>
			<td>{{$e->n8}}</td>
			<td>{{$e->n9}}</td>
			<td>{{$e->n10}}</td>
			<td>{{$e->n11}}</td>
			<td>{{$e->n12}}</td>
			@if($e->par_estudiantil==0)
			<td></td>
			<td>{{'x'}}</td>
			@else
			<td>{{'x'}}</td>
			<td></td>
			@endif
			@if($e->ex_enes==0)
			<td></td>
			<td>{{'x'}}</td>
			@else
			<td>{{'x'}}</td>
			<td></td>
			@endif
			<td>{{$e->obs}}</td>
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<th colspan="20">&nbsp;</th>
		</tr>
		<tr>
			<th colspan="20">&nbsp;</th>
		</tr>
		<tr>
			<td colspan="10" align="center">Msc. Alejandro Caisatoa</td>
			<td colspan="10" align="center">Lcda. Lucía Collaguazo</td>
		</tr>
		<tr>
			<td colspan="10" align="center">RECTOR</td>
			<td colspan="10" align="center">SECRETARIA</td>
		</tr>
	</tfoot>
    
</table>
</html>