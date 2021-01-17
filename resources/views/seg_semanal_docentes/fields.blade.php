<!-- Cap Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cap_id', 'Cap Id:') !!}
    {!! Form::number('cap_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Doc Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('doc_id', 'Doc Id:') !!}
    {!! Form::number('doc_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Nivel Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nivel', 'Nivel:') !!}
    {!! Form::number('nivel', null, ['class' => 'form-control']) !!}
</div>

<!-- Textos Biblicos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('textos_biblicos', 'Textos Biblicos:') !!}
    {!! Form::text('textos_biblicos', null, ['class' => 'form-control']) !!}
</div>

<!-- Respuesta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('respuesta', 'Respuesta:') !!}
    {!! Form::text('respuesta', null, ['class' => 'form-control']) !!}
</div>

<!-- Nivel Final Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nivel_final', 'Nivel Final:') !!}
    {!! Form::number('nivel_final', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::number('estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('segSemanalDocentes.index') !!}" class="btn btn-default">Cancel</a>
</div>
