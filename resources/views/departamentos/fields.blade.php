<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_id', 'Gerencia:') !!}
    {!! Form::select('ger_id', $ger,null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('departamentos.index') !!}" class="btn btn-default">Cancelar</a>
</div>
