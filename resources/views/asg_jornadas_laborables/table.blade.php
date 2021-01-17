<table class="table table-responsive" id="asgJornadasLaborables-table">
    <thead>
        <tr>
            <th>Asg Jrl Usuid</th>
        <th>Asg Jrl Anl</th>
        <th>Asg Jrl Descripcion</th>
        <th>Asg Jrl Desde</th>
        <th>Asg Jrl Hasta</th>
        <th>Asg Jrl Lun</th>
        <th>Asg Jrl Mar</th>
        <th>Asg Jrl Mie</th>
        <th>Asg Jrl Jue</th>
        <th>Asg Jrl Vie</th>
        <th>Asg Jrl Sab</th>
        <th>Asg Jrl Dom</th>
        <th>Asg Jrl Obs</th>
        <th>Asg Jrl Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($asgJornadasLaborables as $asgJornadasLaborables)
        <tr>
            <td>{!! $asgJornadasLaborables->asg_jrl_usuid !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_anl !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_descripcion !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_desde !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_hasta !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_lun !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_mar !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_mie !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_jue !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_vie !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_sab !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_dom !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_obs !!}</td>
            <td>{!! $asgJornadasLaborables->asg_jrl_estado !!}</td>
            <td>
                {!! Form::open(['route' => ['asgJornadasLaborables.destroy', $asgJornadasLaborables->asg_jrl_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('asgJornadasLaborables.show', [$asgJornadasLaborables->asg_jrl_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('asgJornadasLaborables.edit', [$asgJornadasLaborables->asg_jrl_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>