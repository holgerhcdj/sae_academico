<!-- Mtr Descripcion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('mtr_descripcion', 'Descripcion:') !!}
    {!! Form::text('mtr_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Mtr Obs Field -->
<div class="form-group col-sm-4">
    {!! Form::label('mtr_obs', 'Observaciones:') !!}
    {!! Form::text('mtr_obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Mtr Tipo Field -->
<div class="form-group col-sm-4">
    {!! Form::label('mtr_tipo', 'Tipo:') !!}
    
    {{ Form::select('mtr_tipo', [
    '0' => 'CULTURAL',
    '1' => 'TÉCNICO'
    ],null,['class' => 'form-control']) }}    
</div>
<!-- Anl Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('anl_id', 'Anl Id:') !!}
    {!! Form::number('anl_id', $anl_select[0]['id'], ['class' => 'form-control']) !!}
</div>

<!-- Esp Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('esp_id', 'Especialidad:') !!}
    {!! Form::number('esp_id', 10, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('materias.index') !!}" class="btn btn-default">Cancelar</a>
</div>
