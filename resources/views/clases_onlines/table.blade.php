
<table class="table table-responsive" id="clasesOnlines-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Docente</th>
        <th>Materia</th>
        <th>Cursos</th>
        <th>Link</th>
        <th>Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1;?>
    @foreach($clasesOnlines as $clasesOnline)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $clasesOnline->usu_apellidos.' '.$clasesOnline->name !!}</td>
            <td>{!! $clasesOnline->mtr_descripcion !!}</td>
            <td>{!! $clasesOnline->cls_cursos !!}</td>
            <td><a href="{!! $clasesOnline->cls_link !!}" target="_blank" >{!! $clasesOnline->cls_link !!}</a></td>
            <td>
                @if($clasesOnline->cls_estado==0)
                {{'Activo'}}
                @else
                {{'InActivo'}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['clasesOnlines.destroy', $clasesOnline->cls_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('clasesOnlines.edit', [$clasesOnline->cls_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>