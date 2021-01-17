<table class="table table-responsive" id="seguimientoCapellanias-table">
    <thead>
        <tr>
        <th>#</th>    
        <th>Estudiantes</th>
        <th>Usuario</th>
        <th>Fecha</th>
        <th>Situacion Familiar</th>
        <th>Situacion Academica </th>
        <th>Situacion Espiritual</th>
        <th>Observacion</th>
        <th>Recomendacion</th>
        <th>Pedido Oracion</th>
        <th>Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
    $x=1;
     ?>
    @foreach($seguimientoCapellanias as $seguimientoCapellania)
    
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $seguimientoCapellania->est_apellidos.' '.$seguimientoCapellania->est_nombres!!}</td>
            <td>{!! $seguimientoCapellania->usu_apellidos.' '.$seguimientoCapellania->name!!}</td>
            <td>{!! $seguimientoCapellania->fecha !!}</td>
            <td>{!! $seguimientoCapellania->situacion_familiar !!}</td>
            <td>{!! $seguimientoCapellania->situacion_academica_ !!}</td>
            <td>{!! $seguimientoCapellania->situacion_espiritual !!}</td>
            <td>{!! $seguimientoCapellania->observacion !!}</td>
            <td>{!! $seguimientoCapellania->recomendacion !!}</td>
            <td>{!! $seguimientoCapellania->pedido_oracion !!}</td>
            <td>
                 @if($seguimientoCapellania->estado==0)
                {{'Activo'}}
                @elseif($seguimientoCapellania->estado==1)
                {{'Inactivo'}}   
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['seguimientoCapellanias.destroy', $seguimientoCapellania->segid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('seguimientoCapellanias.show', [$seguimientoCapellania->segid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('seguimientoCapellanias.edit', [$seguimientoCapellania->segid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>