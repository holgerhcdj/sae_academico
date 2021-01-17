<table class="table table-hover" id="anioLectivos-table">
    <thead>
        <th>ID</th>
        <th>Periodo</th>
        <th>Observaciones</th>
        <th>Permitir Matricula</th>
        <th>Votacion</th>
        <th>Tipo de Periodo</th>
        <th>Activo</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php $x=1;?>
    @foreach($anioLectivos as $anioLectivo)
        <tr>
            <td>{{$anioLectivo->id}}</td>
            <td>{!! $anioLectivo->anl_descripcion !!}</td>
            <td>{!! $anioLectivo->anl_obs !!}</td>
            <td>
                @if($anioLectivo->especial==0)
                <i class="fa fa-check-square-o text-success" aria-hidden="true"></i>
                @endif
            </td>
            <td>
                @if($anioLectivo->votacion==1)
                <i class="fa fa-check-square-o text-success" aria-hidden="true"></i>
                @endif
            </td>
            <td>
                @if($anioLectivo->periodo==0 && $anioLectivo->periodo!=null)
                {!! "Regular" !!}
                @elseif($anioLectivo->periodo==1)
                {!! "Especial" !!}
                @endif
            </td>
            <td>
                @if($anioLectivo->anl_selected==1)
                <i class="fa fa-check-square-o text-success" aria-hidden="true"></i>
                @endif
            </td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('anioLectivos.edit', [$anioLectivo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>