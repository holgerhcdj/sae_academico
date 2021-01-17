<table class="table table-responsive" id="smsMails-table">
    <thead>
        <tr>
            <th>#</th>
        <th>Cod</th>
        <th>Responsable</th>
        <th>Jornada</th>
        <th>Curso</th>
        <th>Fecha</th>
        <th colspan="3">...</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1;?>
    @foreach($smsMails as $smsMail)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $smsMail->sms_grupo !!}</td>
            <td>{!! $smsMail->usu_apellidos.' '.$smsMail->name !!}</td>
            <td>{!! $smsMail->jor_descripcion !!}</td>
            <td>{!! $smsMail->cur_descripcion.' '.$smsMail->mat_paralelo !!}</td>
            <td>{!! $smsMail->sms_fecha !!}</td>
            <td>
                <a href="{!! route('smsMails.show', [$smsMail->sms_grupo]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>