<table class="table table-responsive" id="visitasHogares-table">
    <thead>
        <tr>
        <th>#</th>
        <th>Estudiante</th>
        <th>Tp_Visita</th>
        <th>N_Visita</th>
        <th>Fecha</th>
        <th>H_Inicio</th>
        <th>H_Fin</th>
        <th>Sector</th>
        <th>Barrio</th>
        <th>Estado</th>
            <th colspan="3">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $x=1;
         ?>
    @foreach($visitasHogares as $visitasHogares)
        <tr>
            <td>{!! $x++ !!}</td>
            <td>{!! $visitasHogares->est_apellidos.' '.$visitasHogares->est_nombres !!}</td>
            <td>@if($visitasHogares->tipo==0)
                {{'Regular'}}
                @elseif($visitasHogares->tipo==1)
                {{'Especial'}}   
                @endif</td>
            <td>{!! $visitasHogares->numero !!}</td>
            <td>{!! $visitasHogares->fecha !!}</td>
            <td>{!! $visitasHogares->h_inicio !!}</td>
            <td>{!! $visitasHogares->h_fin !!}</td>
            <td>{!! $visitasHogares->sector !!}</td>
            <td>{!! $visitasHogares->barrio !!}</td>
            <td>
                @if($visitasHogares->estado==0)
                    {{"Activo"}}
                @else
                    {{"Inactivo"}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['visitasHogares.destroy', $visitasHogares->vstid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('visitasHogares.show', [$visitasHogares->vstid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('visitasHogares.edit', [$visitasHogares->vstid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Está seguro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>