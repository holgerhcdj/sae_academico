<table class="table table-responsive" id="smsMails-table">
    <thead>
        <tr>
        <th>Cod</th>
        <th>Responsable</th>
        <th>Jornada</th>
        <th>Curso</th>
        <th>Descripcion</th>
        <th>Modulo</th>
        <th>Fecha</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=0;?>
    @foreach($smsMails as $smsMail)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $smsMail->sms_grupo !!}</td>
            <td>{!! $smsMail->usu_apellidos.' '.$smsMail->name !!}</td>
            <td>{!! $smsMail->jor_descripcion !!}</td>
            <td>{!! $smsMail->cur_descripcion.' '.$smsMail->mat_paralelo !!}</td>
            <td>{!! $smsMail->sms_fecha.' '.$smsMail->sms_hora !!}</td>
            <td>
                {!! Form::open(['route' => ['smsMails.destroy', $smsMail->sms_grupo], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('smsMails.show', [$smsMail->sms_grupo]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('smsMails.edit', [$smsMail->sms_grupo]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>