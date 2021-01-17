<!-- Enc Numero Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enc_numero', 'Enc Numero:') !!}
    {!! Form::text('enc_numero', null, ['class' => 'form-control']) !!}
</div>

<!-- Enc Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enc_descripcion', 'Enc Descripcion:') !!}
    {!! Form::text('enc_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Enc Objetivo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enc_objetivo', 'Enc Objetivo:') !!}
    {!! Form::text('enc_objetivo', null, ['class' => 'form-control']) !!}
</div>

<!-- Enc Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enc_estado', 'Enc Estado:') !!}
    {!! Form::number('enc_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Enc Freg Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enc_freg', 'Enc Freg:') !!}
    {!! Form::date('enc_freg', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('encEncabezados.index') !!}" class="btn btn-default">Cancel</a>
</div>
