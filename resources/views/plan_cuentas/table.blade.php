<table class="table table-responsive" id="planCuentas-table">
    <thead>
        <th>Codigo</th>
        <th>Descripcion</th>
        <th>Obs</th>
        <th>Estado</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($planCuentas as $planCuentas)
        <tr>
            <td>{!! $planCuentas->codigo !!}</td>
            <td>{!! $planCuentas->descripcion !!}</td>
            <td>{!! $planCuentas->obs !!}</td>
            <td>{!! $planCuentas->estado !!}</td>
            <td>
                {!! Form::open(['route' => ['planCuentas.destroy', $planCuentas->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('planCuentas.show', [$planCuentas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('planCuentas.edit', [$planCuentas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>