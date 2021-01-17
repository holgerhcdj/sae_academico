<div class="form-group col-sm-3">
    {!! Form::label('cur_descripcion', 'Descripcion:') !!}
    {!! Form::text('cur_descripcion', null, ['class' => 'form-control','required '=>'required']) !!}
</div>
<div class="form-group col-sm-1">
    {!! Form::label('cupo', 'Cupo Por Paralelo:') !!}
    {!! Form::number('cupo', null, ['class' => 'form-control','required '=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('cur_tipo', 'Tipo:') !!}
    {{ Form::select('cur_tipo', [
    '0' => 'BASICA SUPERIOR',
    '1' => 'MEDIA'
    ],null,['class' => 'form-control']) }}    
</div>

<div class="form-group col-sm-5">
    {!! Form::label('cur_obs', 'Observaciones:') !!}
    {!! Form::text('cur_obs', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cursos.index') !!}" class="btn btn-default">Cancelar</a>
</div>
