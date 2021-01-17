<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $cursos->id !!}</p>
</div>

<!-- Cur Descripcion Field -->
<div class="form-group">
    {!! Form::label('cur_descripcion', 'Descripcion:') !!}
    <p>{!! $cursos->cur_descripcion !!}</p>
</div>

<!-- Cur Obs Field -->
<div class="form-group">
    {!! Form::label('cur_obs', 'Observaciones:') !!}
    <p>{!! $cursos->cur_obs !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{!! $cursos->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Editado El:') !!}
    <p>{!! $cursos->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Eliminado El:') !!}
    <p>{!! $cursos->deleted_at !!}</p>
</div>

