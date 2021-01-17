<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $insumos->id !!}</p>
</div>

<!-- Ins Descripcion Field -->
<div class="form-group">
    {!! Form::label('ins_descripcion', 'Descripcion:') !!}
    <p>{!! $insumos->ins_descripcion !!}</p>
</div>

<!-- Ins Obs Field -->
<div class="form-group">
    {!! Form::label('ins_obs', 'Observaciones:') !!}
    <p>{!! $insumos->ins_obs !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{!! $insumos->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Editado El:') !!}
    <p>{!! $insumos->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Eliminado El:') !!}
    <p>{!! $insumos->deleted_at !!}</p>
</div>

