<?php
if(isset($rubros)){
    $freg=$rubros->rub_fecha_reg;
    $fpag=$rubros->rub_fecha_max;
}else{
    $freg=date('Y-m-d');
    $fpag=date('Y-m-d');
}
?>
<!-- Rub Fecha Max Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('rub_fecha_max', 'Fecha Limite de Pago:') !!}
    {!! Form::date('rub_fecha_max', $fpag, ['class' => 'form-control']) !!}
</div>
<!-- Rub Fecha Reg Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('rub_fecha_reg', 'Fecha Reg:') !!}
    {!! Form::date('rub_fecha_reg', $freg, ['class' => 'form-control']) !!}
</div>
<!-- Rub Descripcion Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('rub_obs', 'Observacion:') !!}
    {!! Form::text('rub_obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Rub Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_id', 'Gerencia:') !!}
    {!! Form::select('ger_id',$ger,null, ['class' => 'form-control']) !!}
</div>
<!-- Rub Grupo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rub_grupo', 'Grupo al que aplica:') !!}
    {!! Form::select('rub_grupo',['0'=>'Estudiantes','1'=>'Clientes'],null, ['class' => 'form-control']) !!}
</div>
<!-- Rub Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rub_descripcion', 'Descripcion del Rubro:') !!}
    {!! Form::text('rub_descripcion', null, ['class' => 'form-control']) !!}
</div>
<!-- Rub Valor Field -->
<div class="form-group col-sm-2">
    {!! Form::label('rub_valor', 'Valor:') !!}
    {!! Form::text('rub_valor', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Rub Estado Field -->
<div class="form-group col-sm-2">
    {!! Form::label('rub_siglas', 'Siglas:') !!}
    {!! Form::text('rub_siglas',null, ['class' => 'form-control','required','maxlength'=>'3']) !!}
</div>
<!-- Rub Estado Field -->
<div class="form-group col-sm-2">
    {!! Form::label('rub_estado', 'Estado:') !!}
    {!! Form::select('rub_estado',['0'=>'Activo','1'=>'Finalizado'],null, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('rubros.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
