<table class="table table-responsive" id="evaluacionGrupos-table">
    <thead>
        <tr>
            <th>Evl Id</th>
        <th>Evg Descripcion</th>
        <th>Evg Valoracion</th>
        <th>Evg Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($evaluacionGrupos as $evaluacionGrupo)
        <tr>
            <td>{!! $evaluacionGrupo->evl_id !!}</td>
            <td>{!! $evaluacionGrupo->evg_descripcion !!}</td>
            <td>{!! $evaluacionGrupo->evg_valoracion !!}</td>
            <td>{!! $evaluacionGrupo->evg_estado !!}</td>
            <td>
                {!! Form::open(['route' => ['evaluacionGrupos.destroy', $evaluacionGrupo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('evaluacionGrupos.show', [$evaluacionGrupo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('evaluacionGrupos.edit', [$evaluacionGrupo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>