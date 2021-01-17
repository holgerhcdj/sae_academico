<table class="table table-responsive" id="insumos-table">
    <thead>
        <th>Periodo / Año Lectivo</th>
        <th>Descripcion</th>
        <th>Observaciones</th>
        <th>Tipo</th>
        <th>Siglas</th>
        <th>Peso %</th>
        <th>Acciones</th>
    </thead>
    <tbody>
    @foreach($insumos as $insumos)
        <tr>
            <td>{!! $insumos->anl_descripcion !!}</td>
            <td>{!! $insumos->ins_descripcion !!}</td>
            <td>{!! $insumos->ins_obs !!}</td>
            <td>{!! $insumos->tipo !!}</td>
            <td>{!! $insumos->ins_siglas!!}</td>
            <td>{!! $insumos->ins_peso !!}</td>
            <td>
                {!! Form::open(['route' => ['insumos.destroy', $insumos->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('insumos.show', [$insumos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('insumos.edit', [$insumos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Seguro Desea Eliminar?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>