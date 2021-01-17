<!-- Segid Field -->
<div class="form-group" hidden="">
    {!! Form::label('segid', 'Segid:') !!}
    <p>{!! $seguimientoCapellania->usu_apellidos.' '.$seguimientoCapellania->name !!}</p>
</div>

<!-- Mat Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mat_id', 'Estudiante:') !!}
    <p>{!! $seguimientoCapellania->est_apellidos.' '.$seguimientoCapellania->est_nombres !!}</p>
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Responsable:') !!}
    <p>{!! $seguimientoCapellania->usu_apellidos.' '.$seguimientoCapellania->name !!}</p>
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    <p>{!! $seguimientoCapellania->fecha !!}</p>
</div>

<!-- Situacion Familiar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('situacion_familiar', 'Situacion Familiar:') !!}
    <p>{!! $seguimientoCapellania->situacion_familiar !!}</p>
</div>

<!-- Situacion Academica  Field -->
<div class="form-group col-sm-6">
    {!! Form::label('situacion_academica_', 'Situacion Academica :') !!}
    <p>{!! $seguimientoCapellania->situacion_academica_ !!}</p>
</div>

<!-- Situacion Espiritual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('situacion_espiritual', 'Situacion Espiritual:') !!}
    <p>{!! $seguimientoCapellania->situacion_espiritual !!}</p>
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observacion:') !!}
    <p>{!! $seguimientoCapellania->observacion !!}</p>
</div>

<!-- Recomendacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recomendacion', 'Recomendacion:') !!}
    <p>{!! $seguimientoCapellania->recomendacion !!}</p>
</div>

<!-- Pedido Oracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pedido_oracion', 'Pedido Oracion:') !!}
    <p>{!! $seguimientoCapellania->pedido_oracion !!}</p>
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    <p>@if($seguimientoCapellania->estado==0)
                {{'Activo'}}
                @elseif($seguimientoCapellania->estado==1)
                {{'Inactivo'}}   
                @endif</p>
</div>

