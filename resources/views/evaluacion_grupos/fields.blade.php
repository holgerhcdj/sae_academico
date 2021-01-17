<!-- Evl Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evl_id', 'Evl Id:') !!}
    {!! Form::number('evl_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Evg Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evg_descripcion', 'Evg Descripcion:') !!}
    {!! Form::text('evg_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Evg Valoracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evg_valoracion', 'Evg Valoracion:') !!}
    {!! Form::number('evg_valoracion', null, ['class' => 'form-control']) !!}
</div>

<!-- Evg Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evg_estado', 'Evg Estado:') !!}
    {!! Form::number('evg_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('evaluacionGrupos.index') !!}" class="btn btn-default">Cancel</a>
</div>
