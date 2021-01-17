<table class="table table-responsive" id="fichaDeces-table">
    <thead>
        <tr>
            <th>#</th>
        <th>Cedula</th>
        <th>Estudiante</th>
        <th>Jornada</th>
        <th>Especialidad</th>
        <th>Curso</th>
        <th>Paralelo</th>
        <th>Estado</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $x=1;
        ?>
    @foreach($fichaDeces as $f)
        <tr>
            <td>{{$x++}}</td>
            <td>{{$f->est_cedula}}</td>
            <td>{{$f->est_apellidos.' '.$f->est_nombres}}</td>
            <td>{{$f->jor_descripcion}}</td>
            <td>{{$f->esp_descripcion}}</td>
            <td>{{$f->cur_descripcion}}</td>
            <td>{{$f->mat_paralelo}}</td>
            <td>
                @if($f->estado==0)
                {{'S.F'}}
                 @elseif($f->estado==1)
                {{'Aceptado'}}
                @elseif($f->estado==2)
                {{'Rechazado'}}   
                @endif
            </td>   
            <td>
                <a href="{!! route('fichaDeces.edit',[$f->mat_id]) !!}" class='btn btn-default btn-xs' title="Ficha de Datos Acumulativa"><i class="glyphicon glyphicon-list-alt text-primary"></i></a>
<!--                 <a href="{!! route('fichaDeces.edit', [$f->mat_id]) !!}" class='btn btn-default btn-xs' title="Ficha de Datos Acumulativa"><i class="glyphicon glyphicon-list-alt text-primary"></i></a> -->
                <!-- <a href="{!! route('fichaDeces.show', [$f->mat_id]) !!}" class='btn btn-default btn-xs' title="Seguimiento de Estudiantes" ><i class="glyphicon glyphicon-user text-danger"></i></a> -->
            </td>
        </tr>
    @endforeach
    </tbody>
</table>