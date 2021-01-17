<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mod Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mod_id', 'Mod Id:') !!}
    {!! Form::number('mod_id', null, ['class' => 'form-control']) !!}
</div>

<!-- New Field -->
<div class="form-group col-sm-6">
    {!! Form::label('new', 'New:') !!}
    {!! Form::number('new', null, ['class' => 'form-control']) !!}
</div>

<!-- Edit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('edit', 'Edit:') !!}
    {!! Form::number('edit', null, ['class' => 'form-control']) !!}
</div>

<!-- Del Field -->
<div class="form-group col-sm-6">
    {!! Form::label('del', 'Del:') !!}
    {!! Form::number('del', null, ['class' => 'form-control']) !!}
</div>

<!-- Show Field -->
<div class="form-group col-sm-6">
    {!! Form::label('show', 'Show:') !!}
    {!! Form::number('show', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('asignaPermisos.index') !!}" class="btn btn-default">Cancel</a>
</div>
