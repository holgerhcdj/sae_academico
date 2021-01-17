<!-- Ecb Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ecb_id', 'Ecb Id:') !!}
    {!! Form::number('ecb_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Gru Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gru_descripcion', 'Gru Descripcion:') !!}
    {!! Form::text('gru_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Gru Valoracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gru_valoracion', 'Gru Valoracion:') !!}
    {!! Form::number('gru_valoracion', null, ['class' => 'form-control']) !!}
</div>

<!-- Gru Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gru_estado', 'Gru Estado:') !!}
    {!! Form::number('gru_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('encuestaGrupos.index') !!}" class="btn btn-default">Cancel</a>
</div>
