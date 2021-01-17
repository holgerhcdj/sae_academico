<table class="table table-responsive" id="aulaVirtuals-table">
    <thead>
        <tr>
            <th>Usu Id</th>
        <th>Tar Tipo</th>
        <th>Tar Titulo</th>
        <th>Tar Descripcion</th>
        <th>Tar Adjuntos</th>
        <th>Tar Link</th>
        <th>Tar Finicio</th>
        <th>Tar Hinicio</th>
        <th>Tar Ffin</th>
        <th>Tar Hfin</th>
        <th>Tar Estado</th>
        <th>Tar Cursos</th>
        <th>Tar Aux Cursos</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($aulaVirtuals as $aulaVirtual)
        <tr>
            <td>{!! $aulaVirtual->usu_id !!}</td>
            <td>{!! $aulaVirtual->tar_tipo !!}</td>
            <td>{!! $aulaVirtual->tar_titulo !!}</td>
            <td>{!! $aulaVirtual->tar_descripcion !!}</td>
            <td>{!! $aulaVirtual->tar_adjuntos !!}</td>
            <td>{!! $aulaVirtual->tar_link !!}</td>
            <td>{!! $aulaVirtual->tar_finicio !!}</td>
            <td>{!! $aulaVirtual->tar_hinicio !!}</td>
            <td>{!! $aulaVirtual->tar_ffin !!}</td>
            <td>{!! $aulaVirtual->tar_hfin !!}</td>
            <td>{!! $aulaVirtual->tar_estado !!}</td>
            <td>{!! $aulaVirtual->tar_cursos !!}</td>
            <td>{!! $aulaVirtual->tar_aux_cursos !!}</td>
            <td>
                {!! Form::open(['route' => ['aulaVirtuals.destroy', $aulaVirtual->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('aulaVirtuals.show', [$aulaVirtual->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('aulaVirtuals.edit', [$aulaVirtual->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>