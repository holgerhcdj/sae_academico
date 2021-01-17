<table class="table table-responsive" id="regDisciplinas-table">
    <thead>
        <tr>
            <th>#</th>
        <th>Jornada</th>
        <th>Curso</th>
        <th>Paralelo</th>
        <th>Usuario</th>
        <th>Parcial</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($regDisciplinas as $regDisciplina)
        <tr>
            <td>{!! $regDisciplina->mat_id !!}</td>
            <td>{!! $regDisciplina->mtr_id !!}</td>
            <td>{!! $regDisciplina->usu_id !!}</td>
            <td>{!! $regDisciplina->dsc_parcial !!}</td>
            <td>{!! $regDisciplina->dsc_tipo !!}</td>
            <td>{!! $regDisciplina->dsc_nota !!}</td>
            <td>
                {!! Form::open(['route' => ['regDisciplinas.destroy', $regDisciplina->dsc_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('regDisciplinas.show', [$regDisciplina->dsc_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('regDisciplinas.edit', [$regDisciplina->dsc_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>