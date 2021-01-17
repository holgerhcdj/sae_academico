<!-- Gru Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gru_id', 'Gru Id:') !!}
    {!! Form::number('gru_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Pre Pregunta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pre_pregunta', 'Pre Pregunta:') !!}
    {!! Form::text('pre_pregunta', null, ['class' => 'form-control']) !!}
</div>

<!-- Pre Valoracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pre_valoracion', 'Pre Valoracion:') !!}
    {!! Form::number('pre_valoracion', null, ['class' => 'form-control']) !!}
</div>

<!-- Pre Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pre_estado', 'Pre Estado:') !!}
    {!! Form::number('pre_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('encuestaPreguntas.index') !!}" class="btn btn-default">Cancel</a>
</div>
