<script type="text/javascript">

$(document).ready(function() {
  $(".sel-status").select2();
});

    function validar(){

     if ($("input[name=div_codigo]").val().length==0){
        alert("Código es obligatorio");

    $("input[name=div_codigo]").select();
    $("input[name=div_codigo]").addClass("error");
    return  false;
        }

    if ($("input[name=div_descripcion]").val().length==0){
        alert("Descripción es obligatorio");

    $("input[name=div_descripcion]").select();
    $("input[name=div_descripcion]").addClass("error");
    return  false;
        }

    if ($("input[name=div_siglas]").val().length==0){
        alert("Siglas es obligatorio");

    $("input[name=div_siglas]").select();
    $("input[name=div_siglas]").addClass("error");
    return  false;
        }

}

</script>
<style>
    .error{
        border: solid 1px brown;
    }
</style>
<!-- Ger Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_id', 'Gerencia:') !!}
   {!! Form::select('ger_id',$ger, null, ['class' => 'form-control']) !!}
</div>

<!-- Div Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('div_descripcion', ' Descripcion:') !!}
    {!! Form::text('div_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Div Codigo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('div_codigo', 'Codigo:') !!}
    {!! Form::text('div_codigo', null, ['class' => 'form-control']) !!}
</div>
<!-- Div Siglas Field -->
<div class="form-group col-sm-3">
    {!! Form::label('div_siglas', ' Siglas:') !!}
    {!! Form::text('div_siglas', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('estado', 'Estado:') !!}
   {!! Form::select('estado',['0'=>'Activo','1'=>'Inactivo'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('erpDivisions.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
