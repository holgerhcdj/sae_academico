<!-- Anl Id Field -->
<div class="form-group col-sm-6" style="display:none " >
    {!! Form::label('anl_id', 'Anl Id:') !!}
    {!! Form::number('anl_id', null, ['class' => 'form-control']) !!}
</div>
<!-- Responsable Field -->
<div class="form-group col-sm-6" style="display:none ">
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable', null, ['class' => 'form-control']) !!}
</div>
<!-- Descripcion Field -->
<div class="form-group col-sm-2">
    {!! Form::label('jor_id', 'Jornadas:') !!}
    {!! Form::select('jor_id',$jornadas,null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Valor Field -->
<div class="form-group col-sm-2">
    {!! Form::label('valor', 'Valor:') !!}
    {!! Form::number('valor', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-4">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Observacion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::text('observacion', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3" style="display:none ">
    {!! Form::label('estado', 'Estado:') !!}
        {{ Form::select('estado', [
    '0' => 'ACTIVO',
    '1' => 'INACTIVO'
    ],null,['class' => 'form-control']) }}    
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('valorPensiones.index') !!}" class="btn btn-default">Cancelar</a>
</div>
