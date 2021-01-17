<table class="table table-responsive" id="encuestaPreguntas-table">
    <thead>
        <tr>
            <th>Gru Id</th>
        <th>Pre Pregunta</th>
        <th>Pre Valoracion</th>
        <th>Pre Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($encuestaPreguntas as $encuestaPreguntas)
        <tr>
            <td>{!! $encuestaPreguntas->gru_id !!}</td>
            <td>{!! $encuestaPreguntas->pre_pregunta !!}</td>
            <td>{!! $encuestaPreguntas->pre_valoracion !!}</td>
            <td>{!! $encuestaPreguntas->pre_estado !!}</td>
            <td>
                {!! Form::open(['route' => ['encuestaPreguntas.destroy', $encuestaPreguntas->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('encuestaPreguntas.show', [$encuestaPreguntas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('encuestaPreguntas.edit', [$encuestaPreguntas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>