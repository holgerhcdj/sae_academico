<table class="table table-responsive" id="seguimientoDeces-table">
    <thead>
        <tr>
            <th></th>
        <th>Estudiantes</th>
        <th>Fecha</th>
        <th>Registrado por:</th>
        <th hidden>Motivo</th>
        <th hidden>Observaciones</th>
        <th>Estado</th>
            <th colspan="3">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $x=1;
        ?>
    @foreach($seguimientoDeces as $seguimientoDece)
        <tr>
            <td>{{$x++}}</td>   
            <td>{!! $seguimientoDece->est_apellidos.' '.$seguimientoDece->est_nombres!!}</td>
            <td>{!! $seguimientoDece->fecha !!}</td>
            <td>{!! $seguimientoDece->responsable !!}</td>
            <td hidden>{!! $seguimientoDece->motivo !!}</td>
            <td hidden>{!! $seguimientoDece->obs !!}</td>
            <td>@if($seguimientoDece->estado==0)
                {{'Activo'}}
                @elseif($seguimientoDece->estado==1)
                {{'Inactivo'}}   
                @endif</td>
            <td>
                {!! Form::open(['route' => ['seguimientoDeces.destroy', $seguimientoDece->segid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('seguimientoDeces.edit', [$seguimientoDece->segid]) !!}" title="Editar Seguimiento" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
@if($prm->del==1)                    
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','title'=>'Eliminar Seguimiento', 'onclick' => "return confirm('Se eliminaran los datos y no se podrán recuperar  Está seguro de Eliminar?')"]) !!}
@endif                    
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>