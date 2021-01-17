<table class="table table-responsive" id="tramites-table">
    <thead>
        <tr>
        <th>Departamento</th>
        <th>Nombre Tramite</th>
        <th>Obs</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tramites as $tramites)
        <tr>
            <td>{!! $tramites->departamento->descripcion !!}</td>
            <td>{!! $tramites->nombre_tramite !!}</td>
            <td>{!! $tramites->obs !!}</td>
            <td>
                {!! Form::open(['route' => ['tramites.destroy', $tramites->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('tramites.edit', [$tramites->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>