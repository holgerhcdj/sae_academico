<?php
$frg=date('Y-m-d');
if(isset($evaluaciones)){
    $frg=$evaluaciones->evl_freg;
}

?>
<!-- Usu Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',Auth::user()->id, ['class' => 'form-control']) !!}
</div>

<!-- Evl Freg Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('evl_freg', 'Evl Freg:') !!}
    {!! Form::date('evl_freg',$frg, ['class' => 'form-control']) !!}
</div>

<!-- Evl Descripcion Field -->
<div class="form-group col-sm-9">
    {!! Form::label('evl_descripcion', 'Descripcion de la Evaluación:') !!}
    {!! Form::text('evl_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Evl Estado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('evl_estado', 'Estado:') !!}
    {!! Form::select('evl_estado',['0'=>'Activo','1'=>'InActivo'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('evaluaciones.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
