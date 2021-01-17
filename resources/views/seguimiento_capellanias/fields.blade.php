<?php 
$f=date('Y-m-d');
if (isset($seguimientoCapellania)){
    $f=$seguimientoCapellania->fecha;
    }

 ?>
 
<style>
    .error{
        border: solid 1px brown;
    }
</style>

<script type="text/javascript">

$(document).ready(function() {
  $(".sel-status").select2();
});
        
        function validar(){

     if ($("textarea[name=situacion_familiar]").val().length==0){
    alert("Situacion Familiar es obligatorio");

    $("textarea[name=situacion_familiar]").select();
    $("textarea[name=situacion_familiar]").addClass("error");
    return  false;
        }

    if ($("textarea[name=situacion_academica_]").val().length==0){
    alert("Situacion Académica es obligatorio");

    $("textarea[name=situacion_academica_]").select();
    $("textarea[name=situacion_academica_]").addClass("error");
    return  false;
        }

    if ($("textarea[name=situacion_espiritual]").val().length==0){
    alert("Situacion Espiritual es obligatorio");
    return  false;

    $("textarea[name=situacion_espiritual]").select();
    $("textarea[name=situacion_espiritual]").addClass("error");
        }

    if ($("textarea[name=observacion]").val().length==0){
    alert("Observación es obligatorio");

    $("textarea[name=observacion]").select();
    $("textarea[name=observacion]").addClass("error");
    return  false;
        }

    if ($("textarea[name=recomendacion]").val().length==0){
    alert("Recomendación es obligatorio");

    $("textarea[name=recomendacion]").select();
    $("textarea[name=recomendacion]").addClass("error");
    return  false;
        }

    if ($("textarea[name=pedido_oracion]").val().length==0){
    alert("Pedido Oración es obligatorio");

    $("textarea[name=pedido_oracion]").select();
    $("textarea[name=pedido_oracion]").addClass("error");
    return  false;
        }

}

</script>

<!-- Mat Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mat_id', 'Estudiante:') !!}
    {!! Form::select('mat_id',$estudiantes, null, ['class' => 'form-control sel-status']) !!}
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6" hidden="">
    {!! Form::label('usu_id', 'Usuario:') !!}
    {!! Form::text('usu_id', Auth::User()->id, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', $f, ['class' => 'form-control']) !!}
</div>

<!-- Situacion Familiar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('situacion_familiar', 'Situacion Familiar:') !!}
    {!! Form::textarea('situacion_familiar', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>

<!-- Situacion Academica  Field -->
<div class="form-group col-sm-6">
    {!! Form::label('situacion_academica_', 'Situacion Academica :') !!}
    {!! Form::textarea('situacion_academica_', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>

<!-- Situacion Espiritual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('situacion_espiritual', 'Situacion Espiritual:') !!}
    {!! Form::textarea('situacion_espiritual', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::textarea('observacion', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>

<!-- Recomendacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recomendacion', 'Recomendacion:') !!}
    {!! Form::textarea('recomendacion', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>

<!-- Pedido Oracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pedido_oracion', 'Pedido Oracion:') !!}
    {!! Form::textarea('pedido_oracion', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',['0'=>'Activo','1'=>'Inactivo'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary','onclick' => 'return validar()']) !!}
    <a href="{!! route('seguimientoCapellanias.index') !!}" class="btn btn-default">Cancelar</a>
</div>
