<table class="table table-responsive" id="asistencias-table">
    <thead>
        <tr>
        <th>#</th>
        <th>Responsable</th>
        <th>Jornada</th>
        <th>Curso</th>
        <th>Materia</th>
        <th>Fecha</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1;?>
    @foreach($asistencias as $asistencia)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $asistencia->usu_apellidos.' '.$asistencia->name !!}</td>
            <td>{!! $asistencia->jor_descripcion !!}</td>
            <td>{!! $asistencia->cur_descripcion.' '.$asistencia->mat_paralelo !!}</td>
            <td>
                @if($asistencia->mtr_id==3)
                {{'Asistencia General'}}
                @else
                {{$asistencia->mtr_descripcion}}
                @endif
            </td>
            <td>{!! $asistencia->fecha !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('asistencias.edit', [$asistencia->fecha.'&'.$asistencia->mtr_id.'&'.$asistencia->jor_id.'&'.$asistencia->cur_id.'&'.$asistencia->mat_paralelo]) !!}" title="Revisar Asistencias" class='btn btn-default btn-xs'><i class="fa fa-list-alt text-danger"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>