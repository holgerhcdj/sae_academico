<!-- Grp Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grp_descripcion', 'Grp Descripcion:') !!}
    {!! Form::text('grp_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Grp Valoracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grp_valoracion', 'Grp Valoracion:') !!}
    {!! Form::text('grp_valoracion', null, ['class' => 'form-control']) !!}
</div>

<!-- Grp Estado Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('grp_estado', 'Grp Estado:') !!}
    {!! Form::number('grp_estado',0, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('encGrupos.index') !!}" class="btn btn-default">Cancel</a>
</div>
