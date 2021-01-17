<!-- Esp Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('esp_descripcion', 'Descripcion:') !!}
    {!! Form::text('esp_descripcion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Esp Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('esp_obs', 'Observaciones:') !!}
    {!! Form::text('esp_obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('especialidades.index') !!}" class="btn btn-default">Cancelar</a>
</div>
