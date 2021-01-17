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

<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Dsc Parcial Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dsc_parcial', 'Dsc Parcial:') !!}
    {!! Form::number('dsc_parcial', null, ['class' => 'form-control']) !!}
</div>

<!-- Dsc Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dsc_tipo', 'Dsc Tipo:') !!}
    {!! Form::number('dsc_tipo', null, ['class' => 'form-control']) !!}
</div>

<!-- Dsc Nota Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dsc_nota', 'Dsc Nota:') !!}
    {!! Form::text('dsc_nota', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('regDisciplinas.index') !!}" class="btn btn-default">Cancel</a>
</div>
