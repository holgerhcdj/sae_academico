<?php
function getAge($birthday) {
    $birth = strtotime($birthday);
    $now = strtotime('now');
    $age = ($now - $birth) / 31536000;
    return floor($age);
}
?>

<table id="tbl_matriculas" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Jornada</th>        
            <th>Especialidad</th>
            <th>Curso</th>
            <th>Paralelo C</th>
            <th>Paralelo T</th>
            <td>Acciones</td>
        </tr>
    </thead>
    <tbody>
        @foreach($matriculas as $matricula)
        <tr>
            <td>{!! $matricula->jornada->jor_descripcion !!}</td>        
            <td>{!! $matricula->especialidad->esp_descripcion !!}</td>
            <td>{!! $matricula->curso->cur_descripcion !!}</td>
            <td>{!! $matricula->mat_paralelo !!}</td>
            <td>{!! $matricula->mat_paralelot !!}</td>
        </tr>
        @endforeach        
    </tbody>
</table>
