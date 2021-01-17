<?php
$tx='';
$h_valor2="hidden";
if(isset($configuraciones)){
    if($configuraciones->con_id==23){
       $tx="";
   }
   if($configuraciones->con_id==24){
       $tx="Clave:";
       $h_valor2='';
   }
}


?>
<!-- Con Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('con_nombre', 'Descripcion:') !!}
    {!! Form::text('con_nombre', null, ['class' => 'form-control']) !!}
</div>
<!-- Con Valor Field -->
<div class="form-group col-sm-6" {{ $h_valor2 }} >
    {!! Form::label('con_valor2',$tx) !!}
    {!! Form::text('con_valor2',null, ['class' => 'form-control']) !!}
</div>
<!-- Con Valor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('con_valor', 'Estado:') !!}
    {!! Form::select('con_valor',['0'=>'Inactivo','1'=>'Activo'],null, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('configuraciones.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
