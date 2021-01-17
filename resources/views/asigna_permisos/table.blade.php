<table class="table table-responsive" id="asignaPermisos-table">
    <thead>
        <tr>
            <th>Usu Id</th>
        <th>Mod Id</th>
        <th>New</th>
        <th>Edit</th>
        <th>Del</th>
        <th>Show</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($asignaPermisos as $asignaPermisos)
        <tr>
            <td>{!! $asignaPermisos->usu_id !!}</td>
            <td>{!! $asignaPermisos->mod_id !!}</td>
            <td>{!! $asignaPermisos->new !!}</td>
            <td>{!! $asignaPermisos->edit !!}</td>
            <td>{!! $asignaPermisos->del !!}</td>
            <td>{!! $asignaPermisos->show !!}</td>
            <td>
                {!! Form::open(['route' => ['asignaPermisos.destroy', $asignaPermisos->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('asignaPermisos.show', [$asignaPermisos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('asignaPermisos.edit', [$asignaPermisos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>