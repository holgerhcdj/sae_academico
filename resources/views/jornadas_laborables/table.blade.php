<table class="table table-responsive" id="jornadasLaborables-table">
    <thead>
        <tr>
        <th>Descripcion</th>
        <th>Desde</th>
        <th>Hasta</th>
        <th>Lun</th>
        <th>Mar</th>
        <th>Mie</th>
        <th>Jue</th>
        <th>Vie</th>
        <th>Sab</th>
        <th>Dom</th>
            <th colspan="3"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($jornadasLaborables as $jornadasLaborables)
        <tr>
            <td>{!! $jornadasLaborables->jrl_descripcion !!}</td>
            <td>{!! $jornadasLaborables->jrl_desde !!}</td>
            <td>{!! $jornadasLaborables->jrl_hasta !!}</td>
            <td>{!! $jornadasLaborables->jrl_lun==1?'x':'-' !!}</td>
            <td>{!! $jornadasLaborables->jrl_mar==1?'x':'-' !!}</td>
            <td>{!! $jornadasLaborables->jrl_mie==1?'x':'-' !!}</td>
            <td>{!! $jornadasLaborables->jrl_jue==1?'x':'-' !!}</td>
            <td>{!! $jornadasLaborables->jrl_vie==1?'x':'-' !!}</td>
            <td>{!! $jornadasLaborables->jrl_sab==1?'x':'-' !!}</td>
            <td>{!! $jornadasLaborables->jrl_dom==1?'x':'-' !!}</td>
            <td>
                {!! Form::open(['route' => ['jornadasLaborables.destroy', $jornadasLaborables->jrl_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('jornadasLaborables.show', [$jornadasLaborables->jrl_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-list-alt"></i></a>
                    <a href="{!! route('jornadasLaborables.edit', [$jornadasLaborables->jrl_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>