<?php
function getAge($birthday) {
    $birth = strtotime($birthday);
    $now = strtotime('now');
    $age = ($now - $birth) / 31536000;
    return floor($age);
}

?>

<table  class="table table-hover" id="estudiantes-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Cedula</th>
            <th>Estudiante</th>
            <th>Jornada</th>
            <th>Especialidad</th>
            <th>Curso</th>
            <th>Par_C</th>
            <th>Par_T</th>
            <th>Edad</th>
            <th>Sexo</th>
            <th>F_Matricula</th>
            <th>Cel.Rep</th>
            <th>CC.Rep</th>
            <th>Estado</th>            
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        <?php $n = 1; ?>
        @foreach($estudiantes as $estudiante)
                <?php
                switch ($estudiante->mat_estado) {
                    case 0:$estado="Ins";break;
                    case 1:$estado="Mat";break;
                    case 2:$estado="Ret";break;
                    case 3:$estado="Anu";break;
                    case 4:$estado="Otro";break;
                }

                ?>

        <tr>
            <td>{{$n++}}</td>
            <td>{{  $estudiante->est_cedula     }}</td>
            <td><?php echo $estudiante->est_apellidos . " " . $estudiante->est_nombres ?></td>
            <td>{{  $estudiante->jor_descripcion     }}</td>
            <td>{{  $estudiante->esp_descripcion     }}</td>
            <td>{{  $estudiante->cur_descripcion     }}</td>
            <td>{{  $estudiante->mat_paralelo     }}</td>
            <td>{{  $estudiante->mat_paralelot     }}</td>
            <td><?php echo getAge($estudiante->est_fnac)." años" ?></td>            
            <td><?php if(($estudiante->est_sexo)==0){echo "M";}else{echo "F";}?></td>
            <td><?php echo substr($estudiante->created_at,0,10)?></td>
            <td>{{  $estudiante->rep_telefono     }}</td>
            <td>{{  $estudiante->rep_cedula     }}</td>
            <td>{{$estado}}</td>            
            <td>
                {!! Form::open(['route' => ['estudiantes.destroy', $estudiante->est_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="matriculas/edit/{{$estudiante->id}}" class='btn btn-default btn-xs' title="Editar Matricula"><i class="glyphicon glyphicon-book text-green"></i></a>                
                    <a href="{!! route('estudiantes.edit', [$estudiante->est_id]) !!}" class='btn btn-default btn-xs' title="Editar Estudiante"><i class="glyphicon glyphicon-pencil text-blue"></i></a>
                    @if($permisos['del']==1)
                    {!! Form::button('<i class="glyphicon glyphicon-trash" ></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','title'=>'Eliminar Matricula/Estudiante', 'onclick' => "return confirm('Seguro Desea Eliminar?')"]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </td>

        </tr>
        @endforeach        
    </tbody>
</table>
<script>
    $(function () {
        $("#estudiantes-table").DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
    });
</script>