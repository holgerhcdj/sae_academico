<table class="table table-responsive" id="evaluacionPreguntas-table">
    <thead>
        <tr>
            <th>Evg Id</th>
        <th>Evp Pregunta</th>
        <th>Evp Imagen</th>
        <th>Evp Valor</th>
        <th>Evp Resp1</th>
        <th>Evp Resp2</th>
        <th>Evp Resp3</th>
        <th>Evp Resp4</th>
        <th>Evp Resp5</th>
        <th>Evp Resp</th>
        <th>Evp Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($evaluacionPreguntas as $evaluacionPreguntas)
        <tr>
            <td>{!! $evaluacionPreguntas->evg_id !!}</td>
            <td>{!! $evaluacionPreguntas->evp_pregunta !!}</td>
            <td>{!! $evaluacionPreguntas->evp_imagen !!}</td>
            <td>{!! $evaluacionPreguntas->evp_valor !!}</td>
            <td>{!! $evaluacionPreguntas->evp_resp1 !!}</td>
            <td>{!! $evaluacionPreguntas->evp_resp2 !!}</td>
            <td>{!! $evaluacionPreguntas->evp_resp3 !!}</td>
            <td>{!! $evaluacionPreguntas->evp_resp4 !!}</td>
            <td>{!! $evaluacionPreguntas->evp_resp5 !!}</td>
            <td>{!! $evaluacionPreguntas->evp_resp !!}</td>
            <td>{!! $evaluacionPreguntas->evp_estado !!}</td>
            <td>
                {!! Form::open(['route' => ['evaluacionPreguntas.destroy', $evaluacionPreguntas->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('evaluacionPreguntas.show', [$evaluacionPreguntas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('evaluacionPreguntas.edit', [$evaluacionPreguntas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>