<!-- Inspid Field -->
<div class="form-group" hidden>
    {!! Form::label('inspid', 'Inspid:') !!}
    <p>{!! $novedadesInspeccion->inspid !!}</p>
</div>

<!-- Mat Id Field -->
<div class="form-group">
    {!! Form::label('mat_id', 'Estudiante:') !!}
    <p>{!! $novedadesInspeccion->est_apellidos.' '.$novedadesInspeccion->est_nombres !!}</p>
</div>

<!-- Usu Id Field -->
<div class="form-group" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    <p>{!! $novedadesInspeccion->usu_id !!}</p>
</div>

<!-- Fecha Field -->
<div class="form-group">
    {!! Form::label('fecha', 'Fecha:') !!}
    <p>{!! $novedadesInspeccion->fecha !!}</p>
</div>

<!-- Novedad Field -->
<div class="form-group">
    {!! Form::label('novedad', 'Novedad:') !!}
    <p>{!! $novedadesInspeccion->novedad !!}</p>
</div>

<!-- Acciones Field -->
<div class="form-group">
    {!! Form::label('acciones', 'Acciones:') !!}
    <p>{!! $novedadesInspeccion->acciones !!}</p>
</div>

<!-- Recomendaciones Field -->
<div class="form-group">
    {!! Form::label('recomendaciones', 'Recomendaciones:') !!}
    <p>{!! $novedadesInspeccion->recomendaciones !!}</p>
</div>

<!-- Reportada A Field -->
<div class="form-group">
    {!! Form::label('reportada_a', 'Reportada A:') !!}
    <p>{!! $novedadesInspeccion->reportada_a !!}</p>
</div>

<!-- Derivado A Field -->
<div class="form-group">
    {!! Form::label('derivado_a', 'Derivado A:') !!}
    <p>
        @if($novedadesInspeccion->derivado_a==0)
        {{"Dece"}}
        @elseif($novedadesInspeccion->derivado_a==1)
        {{"Capellanía"}}
        @elseif($novedadesInspeccion->derivado_a==2)
        {{"Representante"}}
        @else
        {{"Otros"}}
        @endif

    </p>
</div>

<!-- Departamento Field -->
<div class="form-group">
    {!! Form::label('departamento', 'Departamento:') !!}
    <p>{!! $novedadesInspeccion->departamento !!}</p>
</div>

<!-- Estado Field -->
<div class="form-group">
    {!! Form::label('estado', 'Estado:') !!}
    <p>
        @if($novedadesInspeccion->estado==0)
        {{"Activo"}}
        @else
        {{"Inactivo"}}
        @endif
    </p>
</div>

<!-- Envio Sms Field -->
<div class="form-group">
    {!! Form::label('envio_sms', 'Envío Sms:') !!}
    <p>
        @if($novedadesInspeccion->envio_sms==0)
        {{"Enviar"}}
        @else
        {{"No Enviar"}}
        @endif

    </p>
</div>

<!-- Envio Detalle Field -->
<div class="form-group">
    {!! Form::label('envio_detalle', 'Envío Detalle:') !!}
    <p>{!! $novedadesInspeccion->envio_detalle !!}</p>
</div>

<!-- Estado Sms Field -->
<div class="form-group">
    {!! Form::label('estado_sms', 'Estado Sms:') !!}
    <p>
        @if($novedadesInspeccion->estado_sms==0)
        {{"Enviado"}}
        @else
        {{"No enviado"}}
        @endif
    </p>
</div>

