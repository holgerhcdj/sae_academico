<table class="table table-responsive" id="encuestaGrupos-table">
    <thead>
        <tr>
            <th>Ecb Id</th>
        <th>Gru Descripcion</th>
        <th>Gru Valoracion</th>
        <th>Gru Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($encuestaGrupos as $encuestaGrupos)
        <tr>
            <td>{!! $encuestaGrupos->ecb_id !!}</td>
            <td>{!! $encuestaGrupos->gru_descripcion !!}</td>
            <td>{!! $encuestaGrupos->gru_valoracion !!}</td>
            <td>{!! $encuestaGrupos->gru_estado !!}</td>
            <td>
                {!! Form::open(['route' => ['encuestaGrupos.destroy', $encuestaGrupos->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('encuestaGrupos.show', [$encuestaGrupos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('encuestaGrupos.edit', [$encuestaGrupos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>