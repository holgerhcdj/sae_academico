<table class="table table-responsive" id="solicitudMatriculas-table">
    <thead>
        <tr>
            <th> Nombres</th>
        <th> Email</th>
        <th> Telefono</th>
        <th> Estado</th>
        <th> Fecha Registro</th>
        <th> Hora Registro</th>
        <th> Responsable</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($solicitudMatriculas as $solicitudMatricula)
        <tr>
            <td>{!! $solicitudMatricula->sol_nombres !!}</td>
            <td>{!! $solicitudMatricula->sol_email !!}</td>
            <td>{!! $solicitudMatricula->sol_telefono !!}</td>
            <td>{!! $solicitudMatricula->sol_freg !!}</td>
            <td>{!! $solicitudMatricula->sol_hreg !!}</td>
            <td>{!! $solicitudMatricula->sol_obs_usuario !!}</td>
            <td>{!! $solicitudMatricula->sol_obs_solicitante !!}</td>
            <td>{!! $solicitudMatricula->sol_usuario !!}</td>
            <td>
                @if($solicitudMatricula->sol_estado==0)
                {{'Pendiente'}}
                @endif
                @if($solicitudMatricula->sol_estado==1)
                {{'Atendiento'}}
                @endif
                @if($solicitudMatricula->sol_estado==2)
                {{'Finalizado'}}
                @endif

            </td>
            <td>
                {!! Form::open(['route' => ['solicitudMatriculas.destroy', $solicitudMatricula->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('solicitudMatriculas.show', [$solicitudMatricula->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('solicitudMatriculas.edit', [$solicitudMatricula->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>