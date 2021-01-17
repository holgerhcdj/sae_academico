<!-- Sol Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_nombres', 'Sol Nombres:') !!}
    {!! Form::text('sol_nombres', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_email', 'Sol Email:') !!}
    {!! Form::text('sol_email', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_telefono', 'Sol Telefono:') !!}
    {!! Form::text('sol_telefono', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_estado', 'Sol Estado:') !!}
    {!! Form::number('sol_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Freg Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_freg', 'Sol Freg:') !!}
    {!! Form::date('sol_freg', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Hreg Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_hreg', 'Sol Hreg:') !!}
    {!! Form::text('sol_hreg', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Obs Usuario Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_obs_usuario', 'Sol Obs Usuario:') !!}
    {!! Form::text('sol_obs_usuario', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Obs Solicitante Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_obs_solicitante', 'Sol Obs Solicitante:') !!}
    {!! Form::text('sol_obs_solicitante', null, ['class' => 'form-control']) !!}
</div>

<!-- Sol Usuario Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sol_usuario', 'Sol Usuario:') !!}
    {!! Form::text('sol_usuario', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('solicitudMatriculas.index') !!}" class="btn btn-default">Cancel</a>
</div>
