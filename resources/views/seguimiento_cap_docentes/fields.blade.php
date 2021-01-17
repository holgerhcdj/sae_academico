<?php 
$f=date('Y-m-d');
$capellan=Auth::User()->id;
if (isset($seguimientoCapDocentes)) {
    $capellan=$seguimientoCapDocentes->capellan;
    $f=$seguimientoCapDocentes->fecha;
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

     if ($("textarea[name=historia_vida]").val().length==0){
    alert("Historia Vida es obligatorio");

    $("textarea[name=historia_vida]").select();
    $("textarea[name=historia_vida]").addClass("error");
    return  false;
        }

     if ($("textarea[name=situacion_academica]").val().length==0){
    alert("Situacion  Academica es obligatorio");

    $("textarea[name=situacion_academica]").select();
    $("textarea[name=situacion_academica]").addClass("error");
    return  false;
        }

     if ($("textarea[name=recomendaciones]").val().length==0){
    alert("Recomendaciones es obligatorio");

    $("textarea[name=recomendaciones]").select();
    $("textarea[name=recomendaciones]").addClass("error");
    return  false;
        }

     if ($("textarea[name=necesidad_oracion]").val().length==0){
    alert("Necesidad Oracion es obligatorio");

    $("textarea[name=necesidad_oracion]").select();
    $("textarea[name=necesidad_oracion]").addClass("error");
    return  false;
        }

     if ($("textarea[name=recomendacion]").val().length==0){
    alert("Recomendacion es obligatorio");

    $("textarea[name=recomendacion]").select();
    $("textarea[name=recomendacion]").addClass("error");
    return  false;
        }
    }

</script>
<!-- Usu Id Field -->
<div class="form-group col-sm-4" hidden >
    {!! Form::label('usu_id', 'Capellan:') !!}
    {!! Form::text('usu_id',$capellan , ['class' => 'form-control', 'readonly' => 'readonly']) !!}
</div>

<!-- Usu Id2 Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('usu_id2', 'Docente:') !!}
    {!! Form::text('usu_id2',null, ['class' => 'form-control sel-status']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', $f, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    
</div>
<!-- Historia Vida Field -->
<div class="form-group col-sm-4">
    {!! Form::label('historia_vida', 'Historia Vida:') !!}
    {!! Form::textarea('historia_vida', null, ['class' => 'form-control']) !!}
</div>

<!-- Situacion Academica Field -->
<div class="form-group col-sm-4">
    {!! Form::label('situacion_academica', 'Situacion Academica:') !!}
    {!! Form::textarea('situacion_academica', null, ['class' => 'form-control']) !!}
</div>

<!-- Recomendaciones Field -->
<div class="form-group col-sm-4">
    {!! Form::label('recomendaciones', 'Recomendaciones:') !!}
    {!! Form::textarea('recomendaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Necesidad Oracion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('necesidad_oracion', 'Necesidad Oracion:') !!}
    {!! Form::textarea('necesidad_oracion', null, ['class' => 'form-control']) !!}
</div>

<!-- Recomendacion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('recomendacion', 'Recomendacion:') !!}
    {!! Form::textarea('recomendacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-4">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado', ['0'=>'Activo','1'=>'Inactivo'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('seguimientoCapDocentes.index') !!}" class="btn btn-default">Cancelar</a>
</div>
