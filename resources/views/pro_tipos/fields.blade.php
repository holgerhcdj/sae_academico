<script type="text/javascript">
	function validar(){

     if ($("input[name=descripcion]").val().length==0){
               alert("Descripcion es obligatorio");
               $("input[name=descripcion]").select();
               $("input[name=descripcion]").addClass("error");
               return  false;
        }

    // if ($("input[name=observacion]").val().length==0){
    //         	alert("Observacion es obligatorio");
    //             $("input[name=observacion]").select();
    //             $("input[name=observacion]").addClass("error");
    //             return  false;
    // }
    
}

</script>
<style>
	.error{
        border: solid 1px brown;
    }
</style>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::text('observacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
   {!! Form::select('estado',['0'=>'Activo','1'=>'Inactivo'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('proTipos.index') !!}" class="btn btn-default">Cancelar</a>
</div>
