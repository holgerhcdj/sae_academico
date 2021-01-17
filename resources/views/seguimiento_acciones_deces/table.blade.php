<table class="table table-responsive" id="seguimientoAccionesDeces-table">
    <thead>
        <tr>
            <th>Segid</th>
        <th>Departamento</th>
        <th>Fecha</th>
        <th>Responsable</th>
        <th>Area Trabajada</th>
        <th>Seguimiento</th>
        <th>Obs</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($seguimientoAccionesDeces as $seguimientoAccionesDece)
        <tr>
            <td>{!! $seguimientoAccionesDece->segid !!}</td>
            <td>{!! $seguimientoAccionesDece->departamento !!}</td>
            <td>{!! $seguimientoAccionesDece->fecha !!}</td>
            <td>{!! $seguimientoAccionesDece->responsable !!}</td>
            <td>{!! $seguimientoAccionesDece->area_trabajada !!}</td>
            <td>{!! $seguimientoAccionesDece->seguimiento !!}</td>
            <td>{!! $seguimientoAccionesDece->obs !!}</td>
            <td>
                {!! Form::open(['route' => ['seguimientoAccionesDeces.destroy', $seguimientoAccionesDece->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('seguimientoAccionesDeces.show', [$seguimientoAccionesDece->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('seguimientoAccionesDeces.edit', [$seguimientoAccionesDece->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>