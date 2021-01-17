<!-- Prg Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prg_id', 'Prg Id:') !!}
    {!! Form::number('prg_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Respuesta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('respuesta', 'Respuesta:') !!}
    {!! Form::text('respuesta', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('encRegistros.index') !!}" class="btn btn-default">Cancel</a>
</div>
