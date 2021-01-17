<?php
//print_r($op);
?>
<table class="table table-responsive" id="especialidades-table">
    <thead>
    <th>Descripcion</th>
    <th>Octavo</th>
    <th>Noveno</th>
    <th>Decimo</th>
    <th>Primero</th>
    <th>Segundo</th>
    <th>Tercero</th>
    <th>Observaciones</th>
    <th colspan="3">Acciones</th>
</thead>
<tbody>
    @foreach($especialidades as $especialidad)
    <tr>
        <td>{!! $especialidad->esp_descripcion !!}</td>
        @if($op['op']==1)
        <td>
            <div class='btn-group'>
                <form action="materiasCursos.asignar" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="1" id="jor_id" name="jor_id" />
                    <input type="hidden" value="1" id="tipo" name="tipo" />
                    <input type="hidden" value="1" id="cur_id" name="cur_id" />
                    <input type="hidden" value="{{$especialidad->id}}" id="esp_id" name="esp_id" />
                    {!! Form::button('<i class="glyphicon glyphicon-list-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-default btn-xs']) !!}
                </form>
            </div>
        </td>
        <td>
            <div class='btn-group'>
                <form action="materiasCursos.asignar" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="1" id="jor_id" name="jor_id" />
                    <input type="hidden" value="1" id="tipo" name="tipo" />
                    <input type="hidden" value="2" id="cur_id" name="cur_id" />
                    <input type="hidden" value="{{$especialidad->id}}" id="esp_id" name="esp_id" />
                    {!! Form::button('<i class="glyphicon glyphicon-list-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-default btn-xs']) !!}
                </form>
            </div>
        </td>
        <td>
            <div class='btn-group'>
                <form action="materiasCursos.asignar" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="1" id="jor_id" name="jor_id" />
                    <input type="hidden" value="1" id="tipo" name="tipo" />
                    <input type="hidden" value="3" id="cur_id" name="cur_id" />
                    <input type="hidden" value="{{$especialidad->id}}" id="esp_id" name="esp_id" />
                    {!! Form::button('<i class="glyphicon glyphicon-list-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-default btn-xs']) !!}
                </form>
            </div>
        </td>
        <td>
            <div class='btn-group'>
                <form action="materiasCursos.asignar" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="1" id="jor_id" name="jor_id" />
                    <input type="hidden" value="1" id="tipo" name="tipo" />
                    <input type="hidden" value="4" id="cur_id" name="cur_id" />
                    <input type="hidden" value="{{$especialidad->id}}" id="esp_id" name="esp_id" />
                    {!! Form::button('<i class="glyphicon glyphicon-list-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-default btn-xs']) !!}
                </form>
            </div>
        </td>
        <td>
            <div class='btn-group'>
                <form action="materiasCursos.asignar" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="1" id="jor_id" name="jor_id" />
                    <input type="hidden" value="1" id="tipo" name="tipo" />
                    <input type="hidden" value="5" id="cur_id" name="cur_id" />
                    <input type="hidden" value="{{$especialidad->id}}" id="esp_id" name="esp_id" />
                    {!! Form::button('<i class="glyphicon glyphicon-list-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-default btn-xs']) !!}
                </form>
            </div>
        </td>
        <td>
            <div class='btn-group'>
                <form action="materiasCursos.asignar" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="1" id="jor_id" name="jor_id" />
                    <input type="hidden" value="1" id="tipo" name="tipo" />
                    <input type="hidden" value="6" id="cur_id" name="cur_id" />
                    <input type="hidden" value="{{$especialidad->id}}" id="esp_id" name="esp_id" />
                    {!! Form::button('<i class="glyphicon glyphicon-list-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-default btn-xs']) !!}
                </form>
            </div>
        </td>
        @endif
        <td>{!! $especialidad->esp_obs !!}</td>
        <td hidden="">
            {!! Form::open(['route' => ['especialidades.destroy', $especialidad->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                <a href="{!! route('especialidades.edit', [$especialidad->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Seguro Desea Eliminar?')"]) !!}
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</tbody>
</table>