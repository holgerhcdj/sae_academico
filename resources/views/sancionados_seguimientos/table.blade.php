<table class="table table-responsive" id="sancionadosSeguimientos-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Responsable</th>
            <th>Tipo Seguimiento</th>
            <th>Estado</th>
            <th colspan="3">...</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1?>
    @foreach($sancionadosSeguimientos as $sancionadosSeguimiento)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $sancionadosSeguimiento->sgsnc_fecha !!}</td>
            <td>{!! $sancionadosSeguimiento->usu_apellidos.' '.$sancionadosSeguimiento->name !!}</td>
            <td>{!! $sancionadosSeguimiento->sgsnc_accion !!}</td>
            <td>
                @if($sancionadosSeguimiento->sgsnc_estado==0)
                {{'Activo'}}
                @elseif($sancionadosSeguimiento->sgsnc_estado==1)
                {{'Anulado'}}
                @elseif($sancionadosSeguimiento->sgsnc_estado==2)
                {{'Finalizado'}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['sancionadosSeguimientos.destroy', $sancionadosSeguimiento->sgsnc_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('sancionadosSeguimientos.edit', [$sancionadosSeguimiento->sgsnc_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open text-primary"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>