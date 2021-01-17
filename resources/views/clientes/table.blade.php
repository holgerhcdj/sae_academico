<table class="table table-responsive" id="clientes-table">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>C.C/Ruc</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Direccion</th>
            <th>Estado</th>
            <th colspan="3">...</th>
        </tr>
    </thead>
    <tbody>
    @foreach($clientes as $clientes)
        <tr>
            <td>{!! $clientes->cli_apellidos.' '.$clientes->cli_nombres !!}</td>
            <td>{!! $clientes->cli_ced_ruc !!}</td>
            <td>{!! $clientes->cli_telefono !!}</td>
            <td>{!! $clientes->cli_email !!}</td>
            <td>{!! $clientes->cli_direccion !!}</td>
            <td>
                @if($clientes->cli_estado==0)
                {{'Activo'}}
                @else
                {{'InActivo'}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['clientes.destroy', $clientes->cli_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('clientes.edit', [$clientes->cli_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>