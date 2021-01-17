<table class="table table-responsive" id="sucursales-table">
    <thead>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Direccion</th>
        <th>Telefono</th>
        <th>Email</th>
        <th>Estado</th>
        <th colspan="3">Acciones</th>
    </thead>
    <tbody>
    @foreach($sucursales as $sucursales)
        <tr>
            <td>{!! $sucursales->codigo !!}</td>
            <td>{!! $sucursales->nombre !!}</td>
            <td>{!! $sucursales->direccion !!}</td>
            <td>{!! $sucursales->telefono !!}</td>
            <td>{!! $sucursales->email !!}</td>
            <td>{!! $sucursales->estado !!}</td>
            <td hidden="">
                {!! Form::open(['route' => ['sucursales.destroy', $sucursales->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('sucursales.show', [$sucursales->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('sucursales.edit', [$sucursales->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>