<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mat Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mat_id', 'Mat Id:') !!}
    {!! Form::number('mat_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Sms Mensaje Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sms_mensaje', 'Sms Mensaje:') !!}
    {!! Form::text('sms_mensaje', null, ['class' => 'form-control']) !!}
</div>

<!-- Sms Modulo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sms_modulo', 'Sms Modulo:') !!}
    {!! Form::text('sms_modulo', null, ['class' => 'form-control']) !!}
</div>

<!-- Sms Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sms_tipo', 'Sms Tipo:') !!}
    {!! Form::number('sms_tipo', null, ['class' => 'form-control']) !!}
</div>

<!-- Destinatario Field -->
<div class="form-group col-sm-6">
    {!! Form::label('destinatario', 'Destinatario:') !!}
    {!! Form::text('destinatario', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::number('estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Respuesta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('respuesta', 'Respuesta:') !!}
    {!! Form::text('respuesta', null, ['class' => 'form-control']) !!}
</div>

<!-- Persona Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona', 'Persona:') !!}
    {!! Form::text('persona', null, ['class' => 'form-control']) !!}
</div>

<!-- Sms Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sms_fecha', 'Sms Fecha:') !!}
    {!! Form::date('sms_fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Sms Hora Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sms_hora', 'Sms Hora:') !!}
    {!! Form::text('sms_hora', null, ['class' => 'form-control']) !!}
</div>

<!-- Sms Grupo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sms_grupo', 'Sms Grupo:') !!}
    {!! Form::text('sms_grupo', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('smsMails.index') !!}" class="btn btn-default">Cancel</a>
</div>
