<!-- Asg Jrl Usuid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_usuid', 'Asg Jrl Usuid:') !!}
    {!! Form::number('asg_jrl_usuid', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Anl Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_anl', 'Asg Jrl Anl:') !!}
    {!! Form::number('asg_jrl_anl', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_descripcion', 'Asg Jrl Descripcion:') !!}
    {!! Form::text('asg_jrl_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Desde Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_desde', 'Asg Jrl Desde:') !!}
    {!! Form::text('asg_jrl_desde', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Hasta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_hasta', 'Asg Jrl Hasta:') !!}
    {!! Form::text('asg_jrl_hasta', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Lun Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_lun', 'Asg Jrl Lun:') !!}
    {!! Form::number('asg_jrl_lun', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Mar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_mar', 'Asg Jrl Mar:') !!}
    {!! Form::number('asg_jrl_mar', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Mie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_mie', 'Asg Jrl Mie:') !!}
    {!! Form::number('asg_jrl_mie', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Jue Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_jue', 'Asg Jrl Jue:') !!}
    {!! Form::number('asg_jrl_jue', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Vie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_vie', 'Asg Jrl Vie:') !!}
    {!! Form::number('asg_jrl_vie', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Sab Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_sab', 'Asg Jrl Sab:') !!}
    {!! Form::number('asg_jrl_sab', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Dom Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_dom', 'Asg Jrl Dom:') !!}
    {!! Form::number('asg_jrl_dom', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_obs', 'Asg Jrl Obs:') !!}
    {!! Form::text('asg_jrl_obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Asg Jrl Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asg_jrl_estado', 'Asg Jrl Estado:') !!}
    {!! Form::number('asg_jrl_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('asgJornadasLaborables.index') !!}" class="btn btn-default">Cancel</a>
</div>
