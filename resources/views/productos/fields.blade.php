<?php

if(isset($productos)){
$dv_aux=$dv;
}else{
$dv_aux=0;    
}

?>
<script type="text/javascript">

$(document).ready(function() {
  $(".sel-status").select2();
});

    function validar(){

     if ($("input[name=pro_descripcion]").val().length==0){
        alert("Descripcion es obligatorio");

    $("input[name=pro_descripcion]").select();
    $("input[name=pro_descripcion]").addClass("error");
    return  false;
        }

    if ($("input[name=pro_medida]").val().length==0){
        alert("Medida es obligatorio");

    $("input[name=pro_medida]").select();
    $("input[name=pro_medida]").addClass("error");
    return  false;
        }

    if ($("input[name=pro_marca]").val().length==0){
        alert("Marca es obligatorio");

    $("input[name=pro_marca]").select();
    $("input[name=pro_marca]").addClass("error");
    return  false;
        }

    if ($("input[name=pro_tipo]").val().length==0){
        alert("Tipo es obligatorio");

    $("input[name=pro_tipo]").select();
    $("input[name=pro_tipo]").addClass("error");
    return  false;
        }

    if ($("input[name=pro_unidad]").val().length==0){
        alert("Unidad es obligatorio");

    $("input[name=pro_unidad]").select();
    $("input[name=pro_unidad]").addClass("error");
    return  false;
        }

    if ($("input[name=pro_serie]").val().length==0){
        alert("Serie es obligatorio");

    $("input[name=pro_serie]").select();
    $("input[name=pro_serie]").addClass("error");
    return  false;
        }

    if ($("input[name=pro_codigo]").val().length==0){
        alert("Código es obligatorio");

    $("input[name=pro_codigo]").select();
    $("input[name=pro_codigo]").addClass("error");
    return  false;
        }
}

</script>
<style>
    .error{
        border: solid 1px brown;
    }
</style>

<!-- Tpid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tpid', 'Tipo/Familia:') !!}
    {!! Form::select('tpid', $tp_prod ,null, ['class' => 'form-control sel-status']) !!}
</div>

<!-- Pro Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('div_id', ' Bodega/Division Actual:') !!}
    {!! Form::select('div_id',$div,$dv_aux, ['class' => 'form-control']) !!}
</div>

<!-- Pro Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_descripcion', ' Descripcion:') !!}
    {!! Form::text('pro_descripcion', null, ['class' => 'form-control']) !!}
</div>


<!-- Pro Medida Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pro_medida', ' Medida:') !!}
    {!! Form::text('pro_medida', null, ['class' => 'form-control']) !!}
</div>

<!-- Pro Marca Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pro_marca', ' Marca:') !!}
    {!! Form::text('pro_marca', null, ['class' => 'form-control']) !!}
</div>

<!-- Pro Tipo Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('pro_tipo', ' Tipo:') !!}
    {!! Form::text('pro_tipo',0, ['class' => 'form-control']) !!}
</div>

<!-- Pro Unidad Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pro_unidad', ' Unidad:') !!}
    {!! Form::select('pro_unidad',['UNIDAD'=>'UNIDAD','JUEGO'=>'JUEGO','ROLLO'=>'ROLLO','PAQUETE'=>'PAQUETE'],null, ['class' => 'form-control']) !!}
</div>

<!-- Pro Serie Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pro_serie', ' Serie:') !!}
    {!! Form::text('pro_serie', null, ['class' => 'form-control']) !!}
</div>

<!-- Pro Codigo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pro_codigo', ' Codigo:') !!}
    {!! Form::text('pro_codigo', null, ['class' => 'form-control']) !!}
</div>

<!-- Pro Estado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pro_estado', ' Estado:') !!}
    {!! Form::select('pro_estado',['0'=>'Activo','1'=>'Inactivo'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('productos.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
