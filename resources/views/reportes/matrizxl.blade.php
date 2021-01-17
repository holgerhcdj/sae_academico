<?php

function getAge($birthday) {
    $birth = strtotime($birthday);
    $now = strtotime('now');
    $age = ($now - $birth) / 31536000;
    return floor($age);
}
?>
<style>
    table{
        border-collapse:collapse; 
    }
    #tabla tr td, .enc1 th{
        border: 1px solid #000000;

    }
    .enc1{
        text-align:center;  
    }
    .celda{
        width:5px; 
    }
    .general{
        background:red; 
    }
    .estudiante{
        background-color:#f2f176;
    }
    .representante{
        background-color:#e8896f; 
    }
    .matricula{
        background-color:#3cd1f6; 
    }
</style>


<table id="tabla" >
    <thead>
        <tr>
            <th colspan="27" align="center" valign="middle">
                <img src="img/colegio.png" width="120px" height="70px" />
                UNIDAD EDUCATIVA TÉCNICA "VIDA NUEVA"
            </th>
        </tr>
        <tr>
            <th colspan="27" align="center" valign="middle">

            </th>
        </tr>
        <tr class="enc1">
            <th class="estudiante" colspan="12">Estudiante</th>
            <th class="representante" colspan="6">Representante</th>
            <th class="matricula" colspan="11">Matricula</th>
            <th colspan="5">Facturacion</th>
        </tr>
        <tr class="enc1">
            <th >No</th>
            <th >Cedula</th>
            <th >Apellidos</th>
            <th >Nombres</th>
            <th >Genero</th>
            <th >Fecha Nacimiento</th>
            <th >Edad</th>
            <th >Lugar de Nacimiento</th>
            <th >Direccion</th>
            <th >Correo</th>
            <th >Celular</th>            
            <th >Discapacidad</th>
            <th >Cedula</th>
            <th >Nombres</th>
            <th >Telefono</th>
            <th >Celular</th>
            <th >Correo</th>
            <th>Parentezco</th>
            <th>Jornada</th>
            <th >Especialidad</th>            
            <th >Curso</th>
            <th >Paralelo Cultural</th>
            <th >Paralelo Tecnico</th>
            <th >Tipo</th>
            <th >Responsable</th>
            <th >Plantel Procedencia</th>            
            <th >Estado</th>
            <th >Fecha de Matricula</th>
            <th >Observaciones</th>
            <th>Facturar</th>
            <th>Razon Social</th>
            <th>Ci/Ruc</th>
            <th>Direccion</th>
            <th>Telefono</th>

        </tr>
    </thead>
    <tbody>
        <?php $n = 1; ?>
        @foreach ($estudiantes as $estudiante)
        <tr>
            <td >{{$n++}}</td>
            <td >{{$estudiante->est_cedula}}</td>
            <td  style="width:auto">{{$estudiante->est_apellidos}}</td> 
            <td >{{$estudiante->est_nombres}}</td>
            <td >
                @if ($estudiante->est_sexo == 0)
                {{'Masculino'}}
                @else
                {{'Femenino'}}
                @endif
            </td>
            <td >{{$estudiante->est_fnac}}</td>
            <td><?php echo getAge($estudiante->est_fnac) . " años" ?></td>            
            <td >{{$estudiante->proc_sector}}</td>
            <td >{{$estudiante->est_direccion}}</td>
            <td >{{$estudiante->est_email}}</td>
            <td >{{$estudiante->est_celular}}</td>
            <td >
                @if ($estudiante->est_discapacidad == 0)
                {{'Ninguno'}}
                @elseif($estudiante->est_discapacidad == 1)
                {{'Auditiva'}}
                @elseif($estudiante->est_discapacidad == 2)
                {{'Visual'}}
                @elseif($estudiante->est_discapacidad == 3)
                {{'Mental'}}
                @elseif($estudiante->est_discapacidad == 4)                
                {{'Otro'}}
                @endif
            </td>
            <td >{{$estudiante->rep_cedula}}</td>
            <td >{{$estudiante->rep_nombres}}</td>
            <td >{{$estudiante->est_telefono}}</td>
            <td >{{$estudiante->rep_telefono}}</td>
            <td >{{$estudiante->rep_mail}}</td>
            <td >{{$estudiante->rep_parentezco}}</td>
            <td >{{$estudiante->jor_descripcion}}</td>
            <td >{{$estudiante->esp_descripcion}}</td>
            <td >{{$estudiante->cur_descripcion}}</td>
            <td >{{$estudiante->mat_paralelo}}</td>
            <td >{{$estudiante->mat_paralelot}}</td>
            <td >{{$estudiante->est_tipo}}</td>
            <td >{{$estudiante->responsable}}</td>
            <td >{{$estudiante->plantel_procedencia}}</td>
            <td >
                @if ($estudiante->mat_estado == 0)
                {{'Inscrito'}}
                @elseif($estudiante->mat_estado == 1)
                {{'Matriculado'}}
                @elseif($estudiante->mat_estado == 2)
                {{'Retirado'}}
                @elseif($estudiante->mat_estado == 3)
                {{'Anulado'}}
                @elseif($estudiante->mat_estado == 4)                
                {{'Otro'}}
                @endif
            </td>
            <td ><?php echo substr($estudiante->created_at,0,10) ?></td>
            <td >{{$estudiante->mat_obs}}</td>
            <td >
                @if($estudiante->facturar==1)
                {{'SI'}}
                @else
                {{'NO'}}
                @endif
            </td>
            <td >{{$estudiante->fac_razon_social}}</td>
            <td >{{$estudiante->fac_ruc}}</td>
            <td >{{$estudiante->fac_direccion}}</td>
            <td >{{$estudiante->fac_telefono}}</td>


        </tr>
        @endforeach
    </tbody>
</table>
