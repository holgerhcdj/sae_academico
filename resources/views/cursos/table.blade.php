<?php
$matutina = 1;
$nocturna = 2;
$semip = 3;
?>
<table class="table table-responsive" id="cursos-table">
    <thead>
    <th>Descripcion</th>
    <th>Cupo Por Paralelo</th>
    <th>Tipo</th>
    <th>Observaciones</th>
    <th>Acciones</th>
</thead>
<tbody>
    @foreach($cursos as $cursos)

    <?php
    //$curid=$cursos->id.'&0';
    ?>
    <tr>
        <td>{!! $cursos->cur_descripcion !!}</td>
        <td>{!! $cursos->cupo !!}</td>
        @if($cursos->cur_tipo==0)
        <td>{!!'BASICA SUPERIOR'!!}</td>
        @else
        <td>{!!'MEDIA'!!}</td>
        @endif
        <td>{!! $cursos->cur_obs !!}</td>
        <td>
            @if($op==1)
            <div class='btn-group'>
                <form action="materiasCursos.asignar" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="1" id="jor_id" name="jor_id" />
                    <input type="hidden" value="0" id="tipo" name="tipo" />
                    <input type="hidden" value="{{$cursos->id}}" id="cur_id" name="cur_id" />
                    {!! Form::button('<i class="glyphicon glyphicon-list-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-default btn-xs']) !!}
                </form>
            </div>
            @endif
            <div class='btn-group'>
                <a href="{!! route('cursos.edit', [$cursos->id]) !!}" title="Editar" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                <a href="{!! route('cursos.show', [$cursos->id.'&0']) !!}" title="Asignar Dirigente" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-user text-danger"></i></a>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
</table>