<!-- Personas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('personas', 'Personas:') !!}
    {!! Form::text('personas', null, ['class' => 'form-control']) !!}
</div>

<!-- Req Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('req_id', 'Req Id:') !!}
    {!! Form::number('req_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mvr Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mvr_descripcion', 'Mvr Descripcion:') !!}
    {!! Form::text('mvr_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Personas Ids Field -->
<div class="form-group col-sm-6">
    {!! Form::label('personas_ids', 'Personas Ids:') !!}
    {!! Form::text('personas_ids', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('movimientosRequerimientos.index') !!}" class="btn btn-default">Cancel</a>
</div>
