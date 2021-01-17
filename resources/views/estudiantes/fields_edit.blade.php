<?PHP ECHO "OK"?>
<style type="text/css">
    .form-group{
        margin:0px;
        border:0px solid;  
    }
    .divisor{
        background-color:#eee; 
        border:solid 1px #ccc; 
        text-align:center;
        margin-top:5px; 
        font-weight:bolder;   
    }
</style>
<script>
    $(function () {
        $("input").keypress(function () {
            if (this.id != 'est_email' && this.id != 'rep_mail') {
                $(this).val($(this).val().toUpperCase());
            } else {
                $(this).val($(this).val().toLowerCase());
            }

        });
    });



     $(function(){

    $('.input-number').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
    });

    $('.input-text').on('input', function () { 
    this.value = this.value.replace(/[^a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s-' ']/g,'');
    });

})  

  $(document).on("change","select[name=est_discapacidad]",function(){

    if($("select[name=est_discapacidad]").val()==0){
        
        $("input[name=est_porcentaje_disc]").attr('disabled',true);
        $("input[name=est_porcentaje_disc]").val("0");

    }else{

        $("input[name=est_porcentaje_disc]").attr('disabled',false);
        $("input[name=est_porcentaje_disc]").val("0");    
    }
})
</script> 
<!-- Codigo Field -->
<div class="form-group col-sm-3" hidden="hidden">
    {!! Form::label('est_codigo', 'Codigo:') !!}
    {!! Form::text('est_codigo', '00000', ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->

<!-- Tdocumento Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('est_tdocumento', 'Tipo Documento * :') !!}
    {{ Form::select('est_tdocumento', [
    '0' => 'CEDULA',
    '1' => 'PASAPORTE',
    ],null,['class' => 'form-control']) }}    
</div>
<!-- ...................................................................................................................-->
<!-- Cedula Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_cedula', 'Cedula/Pasaporte * :') !!}
    {!! Form::text('est_cedula', null, ['class' => 'form-control input-number','maxlength'=>'10','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Apellidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_apellidos', 'Apellidos * :') !!}
    {!! Form::text('est_apellidos', null, ['class' => 'form-control input-text','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_nombres', 'Nombres * :') !!}
    {!! Form::text('est_nombres', null, ['class' => 'form-control input-text','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Sexo Field -->
<!-- Sexo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_sexo', 'Sexo: ') !!}
    {{ Form::select('est_sexo', [
    '0' => 'MASCULINO',
    '1' => 'FEMENINO',
    ],null,['class' => 'form-control']) }}    
</div>
<!-- ...................................................................................................................-->
<!-- Fnac Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_fnac', 'Fecha de nacimiento (dd-mm-AAAA) * :') !!}
    <input class="form-control" required="required" name="est_fnac" type="text"  
    value="<?php  if (isset($estudiantes)) {$date = date_create($estudiantes->est_fnac);echo trim(date_format($date, 'd-m-Y'));}?>"  id="est_fnac" >
</div>
<!-- ...................................................................................................................-->
<!-- Sector Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_sector', 'Sector * :') !!}
    {!! Form::text('est_sector', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Direccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_direccion', 'Direccion * :') !!}
    {!! Form::text('est_direccion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Celular Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_celular', 'Celular:') !!}
    {!! Form::text('est_celular', null, ['class' => 'form-control input-number','maxlength'=>'10','pattern'=>'^09\d{8}$','placeholder'=>'Ej 0912345678']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Email Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_email', 'Email * :') !!}
    {!! Form::email('est_email', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Discapacidad Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_discapacidad', 'Discapacidad:') !!}
    {{ Form::select('est_discapacidad', [
    '0' => 'NINGUNO',
    '1' => 'Auditiva',
    '2' => 'Visual',
    '3' => 'Mental',
    '4' => 'Otro',
    ],null,['class' => 'form-control']) }}    

</div>
<!-- ...................................................................................................................-->
<!-- ...................................................................................................................-->
<!-- Porcentaje Disc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_porcentaje_disc', 'Porcentaje Discapacidad:') !!}
    {!! Form::text('est_porcentaje_disc', '0', ['class' => 'form-control input-number','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Tiposangre Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_tiposangre', 'Tipo Sangre:') !!}
    {!! Form::text('est_tiposangre', null, ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Proc Pais Field -->
<div class="form-group col-sm-3">
    {!! Form::label('proc_pais', 'Pais de Origen:') !!}
    {!! Form::text('proc_pais', 'ECUADOR', ['class' => 'form-control input-text']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Proc Provincia Field -->
<div class="form-group col-sm-3">
    {!! Form::label('proc_provincia', 'Provincia de Origen:') !!}
    {!! Form::text('proc_provincia', 'PICHINCHA', ['class' => 'form-control input-text']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Proc Canton Field -->
<div class="form-group col-sm-3">
    {!! Form::label('proc_canton', 'Canton de Origen:') !!}
    {!! Form::text('proc_canton', 'QUITO', ['class' => 'form-control input-text']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Proc Sector Field -->
<div class="form-group col-sm-3">
    {!! Form::label('proc_sector', 'Sector de Origen:') !!}
    {!! Form::text('proc_sector', null, ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<span class="divisor col-sm-12">DATOS DEL REPRESENTANTE</span>
<div class="form-group col-sm-3" >
    {!! Form::label('est_tdocumentor', 'Tipo:') !!}
    {{ Form::select('est_tdocumentor', [
    '0' => 'CEDULA',
    '1' => 'PASAPORTE',
    ],null,['class' => 'form-control']) }}    
</div>
<!-- Rep Cedula Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rep_cedula', 'Cedula/Pasaporte * :') !!}
    {!! Form::text('rep_cedula', null, ['class' => 'form-control input-number','maxlength'=>'10','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Rep Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rep_nombres', 'Nombres y Apellidos * :') !!}
    {!! Form::text('rep_nombres', null, ['class' => 'form-control input-text','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('est_telefono', 'Teléfono  : ') !!}
    {!! Form::text('est_telefono', null, ['class' => 'form-control input-number','placeholder'=>'Ej 022316911/2309511']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Rep Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rep_telefono', 'Celular  :') !!}
    {!! Form::text('rep_telefono', null, ['class' => 'form-control input-number','placeholder'=>'Ej 0912345678/0988877712']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Rep Mail Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rep_mail', 'e-mail * :') !!}
    {!! Form::email('rep_mail', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- ...................................................................................................................-->
<div class="form-group col-sm-3" >
    {!! Form::label('rep_parentezco', 'Parentezco:') !!}
    {!! Form::text('rep_parentezco', null, ['class' => 'form-control input-text']) !!}
</div>
<!-- Obs Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('est_obs', 'Observaciones:') !!}
    {!! Form::text('est_obs', null, ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Submit Field -->
<hr class="col-sm-12" style="margin:5px; "></hr>
<div class="form-group col-sm-10">
    @if($permisos['edit']==1)
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    @endif
</div>
<!-- ...................................................................................................................-->
<div class="form-group col-sm-2">
    <a href="{!! route('estudiantes.index') !!}" class="btn btn-danger">Cancelar</a>
</div>
<!-- ...................................................................................................................-->
