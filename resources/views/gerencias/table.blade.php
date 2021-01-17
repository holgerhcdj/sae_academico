<table class="table table-responsive" id="gerencias-table">
    <thead>
        <tr>
        <th>Codigo</th>
        <th>Descripcion</th>
        <th>Ruc</th>
        <th>Direccion</th>
        <th>Telefono</th>
        <th>Estado</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($gerencias as $gerencias)
        <tr>
            <td>{!! $gerencias->ger_codigo !!}</td>
            <td>{!! $gerencias->ger_descripcion !!}</td>
            <td>{!! $gerencias->ger_ruc !!}</td>
            <td>{!! $gerencias->ger_direccion !!}</td>
            <td>{!! $gerencias->ger_telefono !!}</td>
            <td>
                @if($gerencias->ger_estado==0)
                {{'Activo'}}
                @else
                {{'In Activo'}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['gerencias.destroy', $gerencias->ger_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('gerencias.edit', [$gerencias->ger_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>