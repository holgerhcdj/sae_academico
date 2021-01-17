<script type="text/javascript">
     $(function () {
        documentos($("#cur_id").val());
     })
    $(document).on("click",".chk_docs",function(){
        $("#docs").val(null);
        var n=0;
        var dc='';
        $(".chk_docs").each(function(){
            if($(this).prop("checked")==true){
                n++;
                dc+=$(this).attr('id')+'&';
            }
        });
        $("#ndocs").text(n);
        $("#docs").val(dc);
        $("#ndocs2").text(n);

    })
    $(document).on("change","#mat_paralelo,#jor_id,#cur_id",function(){
        if($(this).val()!="NINGUNO"){
            valida_cupo();
        }        
    })

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
        


    function validar(){


    }


    function valida_cupo(){
        
                //     var url=window.location;
                //     var token=$('input[name=_token]').val();
                //     anlid=null;//Desde el controlador
                //     jorid=$("#jor_id").val();
                //     curid=$("#cur_id").val();
                //     parid=$("#mat_paralelo").val();
                //     $.ajax({
                //       url: url+'/0/val_paralelo',
                //       headers:{'X-CSRF-TOKEN':token},
                //       type: 'POST',
                //       dataType: 'json',
                //       data: {anl:anlid,jor:jorid,cur:curid,par:parid},
                //       beforeSend:function(){

                //       },
                //       success:function(dt){
                //         if(dt==1){
                //           alert("No hay Cupo En Este Paralelo")
                //           $("#mat_paralelo").val("NINGUNO");
                //       }

                //     }
                // });    
        }

function documentos(op){

var docs_asg=$("#docs").val().split('&');
    $("#ndocs").text(docs_asg.length-1);
    $("#ndocs2").text(docs_asg.length-1);

if(op==1){
    docs={'1':'Cedula Estudiante','2':'Cedula Representante','3':'Promoción 2do','4':'Promoción 3ero','5':'Promoción 4to','6':'Promoción 5to','7':'Promoción 6to','8':'Promoción 7mo'}
}
if(op==2){
    docs={'1':'Cedula Estudiante','2':'Cedula Representante','3':'Promoción 2do','4':'Promoción 3ero','5':'Promoción 4to','6':'Promoción 5to','7':'Promoción 6to','8':'Promoción 7mo','9':'Promoción 8vo'}
}
if(op==3){
    docs={'1':'Cedula Estudiante','2':'Cedula Representante','3':'Promoción 2do','4':'Promoción 3ero','5':'Promoción 4to','6':'Promoción 5to','7':'Promoción 6to','8':'Promoción 7mo','9':'Promoción 8vo','10':'Promoción 9vo'}
}
if(op==4){
    docs={'1':'Cedula Estudiante','2':'Cedula Representante','3':'Promoción 2do','4':'Promoción 3ero','5':'Promoción 4to','6':'Promoción 5to','7':'Promoción 6to','8':'Promoción 7mo','9':'Promoción 8vo','10':'Promoción 9no','11':'Promoción 10mo'}
}
if(op==5){
    docs={'1':'Cedula Estudiante','2':'Cedula Representante','3':'Promoción 2do','4':'Promoción 3ero','5':'Promoción 4to','6':'Promoción 5to','7':'Promoción 6to','8':'Promoción 7mo','9':'Promoción 8vo','10':'Promoción 9no','11':'Promoción 10mo','12':'Promoción 1ero Bach','13':'PPE 1ero'}
}
if(op==6){
    docs={'1':'Cedula Estudiante','2':'Cedula Representante','3':'Promoción 2do','4':'Promoción 3ero','5':'Promoción 4to','6':'Promoción 5to','7':'Promoción 6to','8':'Promoción 7mo','9':'Promoción 8vo','10':'Promoción 9no','11':'Promoción 10mo','12':'Promoción 1ero Bach','13':'Promoción 2do Bach','14':'PPE 1ero','15':'PPE 2do'}
}



var resp="";
  $.each(docs, function( key, value ) {
    var vl=0;
        $.each(docs_asg, function( k, v ){
                if(v==key){
                    vl=1;
                }
        });
        if(vl==0){
            resp+="<div class='form-group col-sm-6' >"+
            "<input type='checkbox' class='form-check-input chk_docs' id="+key+" >"+
            "<label class='form-check-label' for="+key+">"+value+"</label>"+
            "</div>"; 
        }else{
            resp+="<div class='form-group col-sm-6' >"+
            "<input type='checkbox' checked class='form-check-input chk_docs' id="+key+" >"+
            "<label class='form-check-label' for="+key+">"+value+"</label>"+
            "</div>"; 
        }
  });
$(".modal-body").html(resp);

}

</script>
<?php
if(isset($estudiantes)){
    $f_nac=$estudiantes->est_fnac;
}else{
    $f_nac=date("Y-m-d");
}
?>
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


<!-- Modal -->
<div class="modal fade" id="est_documentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            <span>Documentos</span>
            <span id="ndocs" style="border:solid 1px #ccc;padding-left:5px;padding-right:5px;text-align:center;color:brown;font-weight:bolder" ></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </h5>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- Codigo Field -->
<div class="form-group col-sm-3" hidden="hidden">
    {!! Form::label('est_codigo', 'Codigo:') !!}
    {!! Form::text('est_codigo', '00000', ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Tdocumento Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('est_tdocumento', 'Tipo:') !!}
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
    {{ Form::date('est_fnac',$f_nac, array('class' => 'form-control')) }}

    <!-- <input class="form-control" required="required" name="est_fnac" type="text" value="<?php if(isset($estudiantes)){$date = date_create($estudiantes->est_fnac);echo trim(date_format($date, 'd-m-Y'));}?>" id="est_fnac"  > -->
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
    {!! Form::text('est_porcentaje_disc', '0', ['class' => 'form-control input-number
input-number','required'=>'required']) !!}
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
    {!! Form::text('proc_pais', 'ECUADOR', ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Proc Provincia Field -->
<div class="form-group col-sm-3">
    {!! Form::label('proc_provincia', 'Provincia de Origen:') !!}
    {!! Form::text('proc_provincia', 'PICHINCHA', ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Proc Canton Field -->
<div class="form-group col-sm-3">
    {!! Form::label('proc_canton', 'Canton de Origen:') !!}
    {!! Form::text('proc_canton', 'QUITO', ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<!-- Proc Sector Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('proc_sector', 'Sector de Origen:') !!}
    {!! Form::text('proc_sector', null, ['class' => 'form-control']) !!}
</div>
<!-- ...................................................................................................................-->
<span class="divisor col-sm-12">DATOS DEL REPRESENTANTE</span>
<!-- Rep Cedula Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('est_tdocumentor', 'Tipo:') !!}
    {{ Form::select('est_tdocumentor', [
    '0' => 'CEDULA',
    '1' => 'PASAPORTE',
    ],null,['class' => 'form-control']) }}    
</div>

<div class="form-group col-sm-3">
    {!! Form::label('rep_cedula', 'Cedula/Pasaporte * :') !!}
    {!! Form::text('rep_cedula', null, ['class' => 'form-control','maxlength'=>'10','required'=>'required']) !!}
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
<!-- Obs Field -->
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
<span class="divisor col-sm-12">DATOS DE LA MATRÍCULA</span>
<!-- Jor Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('jor_id', 'Jornada:') !!}
    {!! Form::select('jor_id',$jornadas,null,['class'=>'form-control']) !!}    
</div>
<!-- Esp Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('esp_id', 'Especialidad:') !!}
    {!! Form::select('esp_id',$especialidades,null,['class'=>'form-control']) !!}    
</div>
<div class="form-group col-sm-3">
    {!! Form::label('proc_id', 'De Sección:') !!}
    {!! Form::select('proc_id',$sucursales,null,['class'=>'form-control']) !!}    
</div>
<div class="form-group col-sm-3">
    {!! Form::label('dest_id', 'A Sección:') !!}
    {!! Form::select('dest_id',$sucursales,null,['class'=>'form-control']) !!}    
</div>
<!-- Cur Id Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('cur_id', 'Curso:') !!}
    {!! Form::select('cur_id',$cursos,null,['class'=>'form-control','onchange'=>'documentos(this.value)']) !!}    
</div>
<!-- Mat Paralelo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('mat_paralelo', 'Paralelo Cultural:') !!}
    {{ Form::select('mat_paralelo', [
    'NINGUNO' => 'NINGUNO',
    'A' => 'A',
    'B' => 'B',
    'C' => 'C',
    'D' => 'D',
    'E' => 'E',
    'F' => 'F',
    'G' => 'G',
    'H' => 'H',
    'I' => 'I',
    'J' => 'J',
    ],null,['class' => 'form-control']) }}    

</div>
<div class="form-group col-sm-3">
    {!! Form::label('mat_paralelot', 'Paralelo Técnico:') !!}
    {{ Form::select('mat_paralelot', [
    'NINGUNO' => 'NINGUNO',
    'A' => 'A',
    'B' => 'B',
    'C' => 'C',
    'D' => 'D',
    'E' => 'E',
    'F' => 'F',
    'G' => 'G',
    'H' => 'H',
    'I' => 'I',
    'J' => 'J',
    ],null,['class' => 'form-control']) }}    
</div>
<div class="form-group col-sm-3">
    {!! Form::label('est_tipo', 'Tipo:') !!}
    {{ Form::select('est_tipo', [
    'ANTIGUO' => 'ANTIGUO',
    'NUEVO' => 'NUEVO'
    ],null,['class' => 'form-control']) }}    
</div>

<div class="form-group col-sm-3">
    {!! Form::label('mat_estado', 'Estado:') !!}
    {{ Form::select('mat_estado', ['Inscrito','Matriculado'],null,['class' => 'form-control']) }}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('plantel_procedencia', 'Plantel de Procedencia:') !!}
    {!! Form::text('plantel_procedencia', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable', Auth::user()->name, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('mat_obs', 'Observaciones:') !!}
    {!! Form::text('mat_obs', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3" >
    {!! Form::label('facturar', 'Factura?:') !!}
    {{ Form::select('facturar', [
    '' => 'FACTURA SI/NO',
    '0' => 'NO',
    '1' => 'SI',
    ],null,['class' => 'form-control']) }}    
</div>

<!-- facturar -->
<div class="form-group col-sm-3">
    {!! Form::label('fac_razon_social', 'Razon Social') !!}
    {!! Form::text('fac_razon_social', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('fac_ruc', 'CI/RUC') !!}
    {!! Form::text('fac_ruc', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('fac_direccion', 'Direccion') !!}
    {!! Form::text('fac_direccion', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('fac_telefono', 'Telefono') !!}
    {!! Form::text('fac_telefono', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>

<!-- Encuesta -->
<div class="form-group col-sm-3">
    {!! Form::label('enc_tipo', 'Se enteró por?') !!}
    {!! Form::select('enc_tipo',[
    ''=>'Seleccione',
    '0'=>'Publicidad',
    '1'=>'Referencia',
    '2'=>'Casa Abierta',
    '3'=>'Otros',
    ],null, ['class' => 'form-control','id'=>'enc_tipo']) !!}
    
</div>

<!-- Encuesta -->
<div class="form-group col-sm-3">
    {!! Form::label('enc_detalle', 'Especifique') !!}
    {!! Form::text('enc_detalle',null, ['class' => 'form-control','required','id'=>'enc_detalle']) !!}
</div>

<!-- Submit Field -->
<hr class="col-sm-12" style="margin:5px; "></hr>

<div class="form-group col-sm-4">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary','id'=>'save']) !!}
</div>

<div class="form-group col-sm-4 text-center">
    <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#est_documentos" >
        Documentos:<span class="badge" id="ndocs2"></span>
  </button>
  {!! Form::hidden('docs',null, ['class' => 'form-control','id'=>'docs']) !!}
</div>
<!-- ...................................................................................................................-->
<div class="form-group col-sm-4">
    <a href="{!! route('estudiantes.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
<!-- ...................................................................................................................-->
<script>
//    $('#est_fnac').datepicker({
//        format: "yyyy-mm-dd",
//        language: "es",
//        autoclose: true,
//        calendarWeeks: true,
//        todayBtn: true
//    });
</script>    


