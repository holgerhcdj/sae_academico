<!-- Segid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('segid', 'Segid:') !!}
    {!! Form::number('segid', null, ['class' => 'form-control']) !!}
</div>

<!-- Departamento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('departamento', 'Departamento:') !!}
    {!! Form::number('departamento', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Responsable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable', null, ['class' => 'form-control']) !!}
</div>

<!-- Area Trabajada Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area_trabajada', 'Area Trabajada:') !!}
    {!! Form::text('area_trabajada', null, ['class' => 'form-control']) !!}
</div>

<!-- Seguimiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('seguimiento', 'Seguimiento:') !!}
    {!! Form::text('seguimiento', null, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('seguimientoAccionesDeces.index') !!}" class="btn btn-default">Cancel</a>
</div>
