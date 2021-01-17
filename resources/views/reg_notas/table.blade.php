<table class="table table-responsive" id="regNotas-table">
    <thead>
        <tr>
            <th>Mat Id</th>
        <th>Periodo</th>
        <th>Ins Id</th>
        <th>Mtr Id</th>
        <th>Usu Id</th>
        <th>Nota</th>
        <th>F Modific</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($regNotas as $regNotas)
        <tr>
            <td>{!! $regNotas->mat_id !!}</td>
            <td>{!! $regNotas->periodo !!}</td>
            <td>{!! $regNotas->ins_id !!}</td>
            <td>{!! $regNotas->mtr_id !!}</td>
            <td>{!! $regNotas->usu_id !!}</td>
            <td>{!! $regNotas->nota !!}</td>
            <td>{!! $regNotas->f_modific !!}</td>
            <td>
                {!! Form::open(['route' => ['regNotas.destroy', $regNotas->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('regNotas.show', [$regNotas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('regNotas.edit', [$regNotas->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>