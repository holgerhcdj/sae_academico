<table class="table table-responsive" id="registroAsistencias-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Codigo</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Tipo</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $c=1; ?>
    @foreach($registroAsistencias as $registroAsistencia)
        <tr>
            <td>{!! $c++ !!}</td>
            <td>{!! $registroAsistencia->usu_apellidos.' '.$registroAsistencia->name !!}</td>
            <td>{!! $registroAsistencia->codigo !!}</td>
            <td>{!! $registroAsistencia->fecha !!}</td>
            <td>{!! $registroAsistencia->hora !!}</td>
            <td>{!! $registroAsistencia->tipo==0?'A':'M' !!}</td>
            <td>
                {!! Form::open(['route' => ['registroAsistencias.destroy', $registroAsistencia->tmbid], 'method' => 'delete']) !!}
                <div class='btn-group'>
<!--                     <a href="{!! route('registroAsistencias.show', [$registroAsistencia->tmbid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                    <a href="{!! route('registroAsistencias.edit', [$registroAsistencia->tmbid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>