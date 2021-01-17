<!-- Segid Field -->
<div class="form-group" hidden="">
    {!! Form::label('segid', 'Segid:') !!}
    <p>{!! $seguimientoDece->segid !!}</p>
</div>

<!-- Mat Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('mat_id', 'Estudiante:') !!}
    <p>{!! $seguimientoDece->est_apellidos.' '.$seguimientoDece->est_nombres!!}</p>
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('fecha', 'Fecha:') !!}
    <p>{!! $seguimientoDece->fecha !!}</p>
</div>

<!-- Motivo Field -->
<div class="form-group col-sm-4">
    {!! Form::label('motivo', 'Motivo:') !!}
    <p>{!! $seguimientoDece->motivo !!}</p>
</div>

<!-- Responsable Field -->
<div class="form-group col-sm-4">
    {!! Form::label('responsable', 'Responsable:') !!}
    <p>{!! $seguimientoDece->responsable !!}</p>
</div>

<!-- Obs Field -->
<div class="form-group col-sm-4">
    {!! Form::label('obs', 'Obs:') !!}
    <p>{!! $seguimientoDece->obs !!}</p>
</div>

<!-- Estado Field -->
<div class="form-group col-sm-4">
    {!! Form::label('estado', 'Estado:') !!}
    <p>@if($seguimientoDece->estado==0)
                {{'Activo'}}
                @elseif($seguimientoDece->estado==1)
                {{'Inactivo'}}   
                @endif</p>
</div>

