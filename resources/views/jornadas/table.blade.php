<table class="table table-responsive" id="jornadas-table">
    <thead>
        <th>Jor Descripcion</th>
        <th>Jor Obs</th>
        <th colspan="3">Acciones</th>
    </thead>
    <tbody>
    @foreach($jornadas as $jornadas)
        <tr>
            <td>{!! $jornadas->jor_descripcion !!}</td>
            <td>{!! $jornadas->jor_obs !!}</td>
            <td >
                <div class='btn-group'>
                    <a href="{!! route('jornadas.edit', [$jornadas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>