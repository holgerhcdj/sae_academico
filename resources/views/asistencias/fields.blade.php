


<!-- Mat Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mat_id', 'Mat Id:') !!}
    {!! Form::number('mat_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mtr Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mtr_id', 'Mtr Id:') !!}
    {!! Form::number('mtr_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::text('fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Hora Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hora', 'Hora:') !!}
    {!! Form::text('hora', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::number('estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('asistencias.index') !!}" class="btn btn-default">Cancel</a>
</div>
