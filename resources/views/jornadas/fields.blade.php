<!-- Jor Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('jor_descripcion', 'Jor Descripcion:') !!}
    {!! Form::text('jor_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Jor Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('jor_obs', 'Jor Obs:') !!}
    {!! Form::text('jor_obs', null, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jornadas.index') !!}" class="btn btn-default">Cancel</a>
</div>
