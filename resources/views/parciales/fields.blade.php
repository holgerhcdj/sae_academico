<?php
$fi=date('Y-m-d');
$ff=date('Y-m-d');
if(isset($parciales)){
$fi=$parciales->par_finicio;
$ff=$parciales->par_ffin;
}
?>
<!-- Anl Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('anl_id', 'Anl Id:') !!}
    {!! Form::number('anl_id',Session::get('anl_id'), ['class' => 'form-control']) !!}
</div>

<!-- Par Descripcion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('par_descripcion', 'Nombre del Parcial:') !!}
    {!! Form::text('par_descripcion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Par Finicio Field -->
<div class="form-group col-sm-4">
    {!! Form::label('par_finicio', 'Fecha inicio:') !!}
    {!! Form::date('par_finicio', $fi, ['class' => 'form-control']) !!}
</div>

<!-- Par Ffin Field -->
<div class="form-group col-sm-4">
    {!! Form::label('par_ffin', 'Fecha fin:') !!}
    {!! Form::date('par_ffin', $ff, ['class' => 'form-control']) !!}
</div>

<!-- Par Estado Field -->
<div class="form-group col-sm-4" >
    {!! Form::label('par_act_m', 'MATUTINA:') !!}
    {!! Form::SELECT('par_act_m',['0'=>'CERRADO','1'=>'ABIERTO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Par Estado Field -->
<div class="form-group col-sm-4" >
    {!! Form::label('par_act_s', 'SEMI-PRESENCIAL:') !!}
    {!! Form::SELECT('par_act_s',['0'=>'CERRADO','1'=>'ABIERTO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Par Estado Field -->
<div class="form-group col-sm-4" >
    {!! Form::label('par_estado', 'Bloqueado Estudiantes:') !!}
    {!! Form::SELECT('par_estado',['0'=>'SI','1'=>'NO'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('parciales.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
