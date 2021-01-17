<?php

function getAge($birthday) {
    $birth = strtotime($birthday);
    $now = strtotime('now');
    $age = ($now - $birth) / 31536000;
    return floor($age);
}

?>
<style>
    body{
        background:white; 
    }
</style>

<div class="col-sm-12">
    <h4 class="bg-info" style="text-align: center;font-weight: bold;">Datos Principales</h4>
</div>
<table class="table table-responsive">
    <thead>
        <th>Estudiante</th>
        <th>Cedula</th>
        <th>Sexo</th>
        <th>Edad</th>
    </thead>
<tbody>
    <tr>
        <td>{{$fexp->est_apellidos.' '.$fexp->est_nombres}}</td>
        <td>{{$fexp->est_cedula}}</td>
        <td><?php if(($fexp->est_sexo)==0){echo "Masculino";}else{echo "Femenino";}?></td>
        <td><?php echo getAge($fexp->est_fnac)." años" ?></td>
    </tr>
</tbody>
</table>

<h4 class="bg-info" style="text-align: center;font-weight: bold;">Matriculas</h4>
<table class="table table-responsive">
    <tr>
        <th>No</th>
        <th>Año Lectivo</th>
        <th>Jornada</th>
        <th>Especialidad</th>
        <th>Curso</th> 
        <th>Par_C</th>
        <th>Par_T</th>
        <th>F_Matricula</th>

    </tr>
    <?php 
    $x=1;
     ?>
@foreach($mat as $mt)
<tr>
            <td>{{$x++}}</td>
            <td>{{  $mt->anl_descripcion     }}</td>
            <td>{{  $mt->jor_descripcion     }}</td>
            <td>{{  $mt->esp_descripcion     }}</td>
            <td>{{  $mt->cur_descripcion     }}</td>
            <td>{{  $mt->mat_paralelo     }}</td>
            <td>{{  $mt->mat_paralelot     }}</td>
            <td><?php echo substr($mt->created_at,0,10)?></td>

</tr>
@endforeach
</table>

<h4 class="bg-info" style="text-align: center;font-weight: bold;">Seguimiento Capellania</h4>
<table class="table table-responsive">
    <tr>
        <th>No</th>
        <th>Capellan</th>
        <th>Fecha</th>
        <th>Situacion Familiar</th>
        <th>Situcaion Academina</th>
        <th>Situcaion Espiritual</th>
        <th>Observacion</th>
        <th>Recomendacion</th>
        <th>Pedido de Oracion</th>

    </tr>
    <?php 
    $x=1;
     ?>
@foreach($fcap as $fc)
<tr>
    <td>{{$x++}}</td>
    <td>{{$fc->usu_apellidos.' '.$fc->name}}</td>
    <td>{{$fc->fecha}}</td>
    <td>{{$fc-> situacion_familiar}}</td>
    <td>{{$fc-> situacion_academica_}}</td>
    <td>{{$fc-> situacion_espiritual}}</td>
    <td>{{$fc-> observacion}}</td>
    <td>{{$fc-> recomendacion}}</td>
    <td>{{$fc-> pedido_oracion}}</td>

</tr>
@endforeach
</table>

<h4 class="bg-info" style="text-align: center;font-weight: bold;">Novedades Inspeccion</h4>
<table class="table table-responsive">
    <tr>
        <th>No</th>
        <th>Responsable</th>
        <th>Fecha</th>
        <th>Novedad</th>
        <th>Reportada A</th>

    </tr>
    <?php 
    $x=1;
     ?>
@foreach($fnov as $fn)
<tr>
    <td>{{$x++}}</td>
    <td>{{$fn->usu_apellidos.' '.$fn->name}}</td>
    <td>{{$fn->fecha}}</td>
    <td>{{$fn->novedad}}</td>
    <td>{{$fn-> reportada_a}}</td>

</tr>
@endforeach
</table>

<h4 class="bg-info" style="text-align: center;font-weight: bold;">Seguimiento Dece</h4>
<table class="table table-responsive">
    <tr>
        <th>No</th>
        <th>Responsable</th>
        <th>Fecha</th>
        <th>Motivo</th>
        <th>Departamento</th>
        <th>Observacion</th>

    </tr>
    <?php 
    $x=1;
     ?>
@foreach($fsdc as $fd)
<tr>
    <td>{{$x++}}</td>
    <td>{{$fd->usu_apellidos.' '.$fd->name}}</td>
    <td>{{$fd->fecha}}</td>
    <td>{{$fd->motivo}}</td>
    <td>@if($fd->departamento==0)
                    {{"DECE"}}
                @else
                    {{"CAPELLANIA"}}
                @endif</td>
    <td>{{$fd-> obs}}</td>

</tr>
@endforeach
</table>

<h4 class="bg-info" style="text-align: center;font-weight: bold;">Visita Hogares</h4>
<table class="table table-responsive">
    <tr>
        <th>No</th>
         <th>Estudiante</th>
        <th>Tp_Visita</th>
        <th>N_Visita</th>
        <th>Fecha</th>
        <th>H_Inicio</th>
        <th>H_Fin</th>
        <th>Sector</th>
        <th>Barrio</th>

    </tr>
    <?php 
    $x=1;
     ?>
@foreach($vth as $vh)
<tr>
    <td>{{$x++}}</td>
    <td>{!! $vh->est_apellidos.' '.$vh->est_nombres !!}</td>
            <td>@if($vh->tipo==0)
                {{'Regular'}}
                @elseif($vh->tipo==1)
                {{'Especial'}}   
                @endif</td>
            <td>{!! $vh->numero !!}</td>
            <td>{!! $vh->fecha !!}</td>
            <td>{!! $vh->h_inicio !!}</td>
            <td>{!! $vh->h_fin !!}</td>
            <td>{!! $vh->sector !!}</td>
            <td>{!! $vh->barrio !!}</td>

</tr>
@endforeach
</table>
