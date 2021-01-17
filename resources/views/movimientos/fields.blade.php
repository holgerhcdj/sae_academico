<?php
$f=date('Y-m-d');
$f2=date('Y-m-d');
if(isset($movimientos)){
    $f=$movimientos->movfecha;
}
 ?>
<script type="text/javascript">

    $(document).ready(function() {
  $(".sel-status").select2();
});


    $(function(){

    $('.input-number').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
    });

    $('.input-text').on('input', function () { 
    this.value = this.value.replace(/[^a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s-' ']/g,'');
});
        
})

    function validar(){

     if ($("input[name=movnumdoc]").val().length==0){
        alert("Número doc es obligatorio");

    $("input[name=movnumdoc]").select();
    $("input[name=movnumdoc]").addClass("error");
    return  false;
        }

    if ($("input[name=procaracteristicas]").val().length==0){
        alert("Caracteristicas es obligatorio");

    $("input[name=procaracteristicas]").select();
    $("input[name=procaracteristicas]").addClass("error");
    return  false;
        }

     if ($("input[name=proserie]").val().length==0){
        alert("Serie es obligatorio");

    $("input[name=proserie]").select();
    $("input[name=proserie]").addClass("error");
    return  false;
        }

     if ($("input[name=observaciones]").val().length==0){
        alert("Observaciones es obligatorio");

    $("input[name=observaciones]").select();
    $("input[name=observaciones]").addClass("error");
    return  false;
        }
}

</script>
<style>
    .error{
        border: solid 1px brown;
    }
</style>


<!-- Proid Field -->
<div class="form-group col-sm-4">
    {!! Form::label('proid', 'Proid:') !!}
    {!! Form::select('proid',$pro, null, ['class' => 'form-control sel-status']) !!}
</div>

<!-- Div Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('div_id', 'Div Id:') !!}
     {!! Form::select('div_id',$div, null, ['class' => 'form-control sel-status']) !!}
</div>

<!-- Movfecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('movfecha', 'Fecha:') !!}
    {!! Form::date('movfecha', $f2, ['class' => 'form-control']) !!}
</div>

<!-- Movtipo Field -->
<div class="form-group col-sm-4">
    {!! Form::label('movtipo', 'Tipo:') !!}
    {!! Form::select('movtipo', ['0'=>'Ingreso','1'=>'Egreso'], null, ['class' => 'form-control']) !!}
</div>

<!-- Mov Field -->
<div class="form-group col-sm-4">
    {!! Form::label('mov', 'Mov:') !!}
    {!! Form::number('mov', null, ['class' => 'form-control']) !!}
</div>

<!-- Movtpdoc Field -->
<div class="form-group col-sm-4">
    {!! Form::label('movtpdoc', 'Tipo doc:') !!}
    {!! Form::select('movtpdoc',['0'=>'Factura','1'=>'Nota de Venta'], null, ['class' => 'form-control']) !!}
</div>

<!-- Movnumdoc Field -->
<div class="form-group col-sm-4">
    {!! Form::label('movnumdoc', 'Número doc:') !!}
    {!! Form::text('movnumdoc', null, ['class' => 'form-control input-number', 'maxlength'=>'10']) !!}
</div>

<!-- Movvalorunit Field -->
<div class="form-group col-sm-4">
    {!! Form::label('movvalorunit', 'Valor unit:') !!}
    {!! Form::number('movvalorunit', null, ['class' => 'form-control']) !!}
</div>

<!-- Procaracteristicas Field -->
<div class="form-group col-sm-4">
    {!! Form::label('procaracteristicas', 'Características:') !!}
    {!! Form::text('procaracteristicas', null, ['class' => 'form-control']) !!}
</div>

<!-- Proserie Field -->
<div class="form-group col-sm-4">
    {!! Form::label('proserie', 'Serie:') !!}
    {!! Form::text('proserie', null, ['class' => 'form-control']) !!}
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-4">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Movestado Field -->
<div class="form-group col-sm-4">
    {!! Form::label('movestado', 'Estado:') !!}
    {!! Form::select('movestado',['0'=>'Activo','1'=>'Inactivo'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('movimientos.index') !!}" class="btn btn-default">Cancelar</a>
</div>
