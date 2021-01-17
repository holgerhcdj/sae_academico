<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $jornadas->id !!}</p>
</div>

<!-- Jor Descripcion Field -->
<div class="form-group">
    {!! Form::label('jor_descripcion', 'Jor Descripcion:') !!}
    <p>{!! $jornadas->jor_descripcion !!}</p>
</div>

<!-- Jor Obs Field -->
<div class="form-group">
    {!! Form::label('jor_obs', 'Jor Obs:') !!}
    <p>{!! $jornadas->jor_obs !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $jornadas->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $jornadas->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $jornadas->deleted_at !!}</p>
</div>

