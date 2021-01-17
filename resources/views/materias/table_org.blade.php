<table class="table table-responsive" id="materias-table">
    <thead>
        <tr>
            <th>Descripcion</th>
            <th>Tipo</th>
            <th>Observaciones</th>            
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($materias as $materias)
        <tr>
            <td>{!! $materias->mtr_descripcion !!}</td>
            <td>
                @if($materias->mtr_tipo==0)
                {!! 'CULTURAL' !!}
                @else
                {!! 'TÉCNICA' !!}
                @endif
            </td>            
            <td>{!! $materias->mtr_obs !!}</td>            
            <td>
                {!! Form::open(['route' => ['materias.destroy', $materias->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('materias.show', [$materias->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('materias.edit', [$materias->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>