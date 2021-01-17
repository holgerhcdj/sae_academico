<!-- Mat Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mat_id', 'Mat Id:') !!}
    {!! Form::number('mat_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Periodo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('periodo', 'Periodo:') !!}
    {!! Form::number('periodo', null, ['class' => 'form-control']) !!}
</div>

<!-- Ins Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ins_id', 'Ins Id:') !!}
    {!! Form::number('ins_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mtr Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mtr_id', 'Mtr Id:') !!}
    {!! Form::number('mtr_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Nota Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nota', 'Nota:') !!}
    {!! Form::number('nota', null, ['class' => 'form-control']) !!}
</div>

<!-- F Modific Field -->
<div class="form-group col-sm-6">
    {!! Form::label('f_modific', 'F Modific:') !!}
    {!! Form::text('f_modific', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('regNotas.index') !!}" class="btn btn-default">Cancel</a>
</div>
