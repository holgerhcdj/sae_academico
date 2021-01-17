<table class="table table-responsive" id="materiasCursos-table">
    <thead>
        <tr>
            <th>Curso</th>
            <th>Materia</th>
            <th>Horas</th>
            <th>Bloques</th>
            <th>Estado</th>
            <th colspan="3"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($materiasCursos as $materiasCurso)
        <tr>
            <td>{!! $materiasCurso->curso->cur_descripcion !!}</td>
            <td>
                {!! $materiasCurso->materia->mtr_descripcion !!}
            </td>
            <td>{!! $materiasCurso->horas !!}</td>
            <td>{!! $materiasCurso->bloques !!}</td>
            <td>
                @if($materiasCurso->estado==0)
                    {{'En Curso'}}
                @else
                    {{'Finalizado'}}
                @endif
            </td>
            <td class="text-right">
                <input type="hidden" class="mtr_id" value="{{$materiasCurso->materia->id}}">
                <input type="hidden" class="asg_id" value="{{$materiasCurso->id}}">
                <input type="hidden" class="mtr_desc" value="{{$materiasCurso->materia->mtr_descripcion}}">
                <input type="hidden" class="mtr_horas" value="{{$materiasCurso->horas}}">
                <input type="hidden" class="mtr_bloq" value="{{$materiasCurso->bloques}}">
                <input type="hidden" class="mtr_estado" value="{{$materiasCurso->estado}}">
                <button class="btn_mtredit" title="Modificar Nombre de la Materia"><i class="glyphicon glyphicon-pencil text-primary"></i></button>
            </td>
            <td class="text-left">
                {!! Form::open(['route' => ['materiasCursos.destroy', $materiasCurso->id ], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {!! Form::button('<i class="glyphicon glyphicon-trash" ></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','title'=>'Eliminar Asignación' ,'onclick' => "return confirm('Esta Seguro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>