<?php
if(isset($avances)){
    $fi=$avances->f_inicio;
    $ff=$avances->f_fin ;

}else{
    $fi=date('Y-m-d');
    $ff=date('Y-m-d');
}

?>
<!-- F Inicio Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('f_inicio', 'F Inicio:') !!}
    {!! Form::text('f_inicio', $fi, ['class' => 'form-control']) !!}
</div>

<!-- F Fin Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('f_fin', 'F Fin:') !!}
    {!! Form::text('f_fin', $ff, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obs', 'Modulo:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Responsable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('responsable', 'Solicita:') !!}
    {!! Form::text('responsable', Auth::user()->name." ".Auth::user()->usu_apellidos, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',['0'=>'Solicitado','1'=>'Aprobado','2'=>'Finalizado'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('avances.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
