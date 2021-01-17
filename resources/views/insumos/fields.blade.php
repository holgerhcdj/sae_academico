<!-- Ins Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ins_descripcion', 'Descripcion:') !!}
    {!! Form::text('ins_descripcion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Ins Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ins_obs', 'Observaciones:') !!}
    {!! Form::text('ins_obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('insumos.index') !!}" class="btn btn-default">Cancelar</a>
</div>
