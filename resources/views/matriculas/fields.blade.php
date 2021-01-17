<script>
    $(function () {
        documentos($("#cur_id").val());
        if(mat_estado.value>1){
            motivo.readOnly = false;
            motivo.required = "required";
            fecha_asistencia.required = "required";
            fecha_accion.required = "required";
        }
        txt_anio=$( "#anl_id option:selected" ).text();

        $("#lbl_anio").text('Año Lectivo :'+txt_anio);
        
                    var anl_org=$("#anl_id").val();
                    var cur=$("#cur_id").val();
                    var par=$("#mat_paralelo").val();
                    var part=$("#mat_paralelot").val();
                    var tipo=$("#est_tipo").val();
                    var plant=$("#plantel_procedencia").val();
                    var est=$("#mat_estado").val();


        $('#radioBtn a').on('click', function(){
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            if(sel==0){
                //Si pide solo actualizar
                $("#anl_id").val(anl_org);
                $("#cur_id").val(cur);
                $("#mat_paralelo").val(par);
                $("#mat_paralelot").val(part);
                $("#est_tipo").val(tipo);
                $("#plantel_procedencia").val(plant);
                $("#mat_estado").val(est);

            }else if(sel==1){
                //Si pide Matricula Provicional

                    $("#anl_id").css('border','solid 1px red');
                    $("#cur_id").css('border','solid 1px red');
                    $("#mat_paralelo").css('border','solid 1px red');
                    $("#mat_paralelot").css('border','solid 1px red');
                    $("#est_tipo").css('border','solid 1px red');
                    $("#plantel_procedencia").css('border','solid 1px red');
                    $("#mat_estado").css('border','solid 1px red');

                    $("#anl_id").val((anl_org*1)+1);

                    $("#cur_id").val(cur);
                    $("#mat_paralelo").val(par);
                    $("#mat_paralelot").val(part);
                    $("#mat_estado").val(est);
                    $("#est_tipo").val('ANTIGUO');
                    $("#plantel_procedencia").val('VIDA NUEVA');

                    valida_cupo();

            }else if(sel==2){
                    //Si pide pase de año
                    $("#anl_id").css('border','solid 1px red');
                    $("#cur_id").css('border','solid 1px red');
                    $("#mat_paralelo").css('border','solid 1px red');
                    $("#mat_paralelot").css('border','solid 1px red');
                    $("#est_tipo").css('border','solid 1px red');
                    $("#plantel_procedencia").css('border','solid 1px red');
                    $("#mat_estado").css('border','solid 1px red');

                    $("#anl_id").val((anl_org*1)+1);
                    $("#cur_id").val(((cur*1)+1));
                    $("#est_tipo").val('ANTIGUO');
                    $("#plantel_procedencia").val('VIDA NUEVA');
                    
                    valida_cupo();                    
            }

            $('#'+tog).prop('value', sel);
            $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');

        txt_anio=$( "#anl_id option:selected" ).text();
        $("#lbl_anio").text('Año Lectivo :'+txt_anio);

        });
      $('input:text[name=validar]').val($("#mat_paralelo").val());

    });

    $(document).on("change","#mat_paralelo",function(){
        if($(this).val()!="NINGUNO"){
            valida_cupo();
        }        
    })

    function valida_cupo(){
                //     var url=window.location;
                //     var token=$('input[name=_token]').val();
                //     anlid=$("#anl_id").val();
                //     jorid=$("#jor_id").val();
                //     curid=$("#cur_id").val();
                //     parid=$("#mat_paralelo").val();
                //     $.ajax({
                //       url: url+'/val_paralelo',
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


    function valida_cambio(obj) {
        var val = obj.value;
        if (val > 1) {

            motivo.readOnly = false;
            motivo.required = "required";
            fecha_asistencia.required = "required";
            fecha_accion.required = "required";
            //fecha_asistencia.value = fecha();
            fecha_accion.value = fecha();

            if(val==2){

                      var url=window.location;
                      var token=$("input[name=_token]").val();
                      var matid=$("input[name=mat_id]").val();

                      $.ajax({
                        url: url+'/revisa_asistencia',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'matid':matid},
                        beforeSend:function(){
                        },
                        success:function(dt){
                            if(dt!=0){
                                $("#fecha_asistencia").val(dt);
                                $("#fecha_asistencia").attr('readOnly','readOnly');
                            }else{
                                alert('No existen registros de asistencia');
                            }
                        }
                    })


                  }

        } else {
            motivo.readOnly = true;
            motivo.value = null;
            fecha_asistencia.value = null;
            fecha_accion.value = null;
            motivo.required = "";
            fecha_asistencia.required = "";
            fecha_accion.required = "";
        }
    }
    function fecha() {
        var f = new Date();
        m = (f.getMonth() + 1);
        if (m < 10) {
            m = '0' + (f.getMonth() + 1);
        }
        return (f.getDate() + "-" + m + "-" + f.getFullYear());
    }

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


     $(function(){

    $('.input-number').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
    });

    $('.input-text').on('input', function () { 
    this.value = this.value.replace(/[^a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s-' ']/g,'');
    });

})  


// $(document).on("click","select[name=mat_estado]",function(){
//     if($(this).val()==){

//     }
// })

</script>
<style>
#radioBtn .notActive{
    color: #3276b1;
    background-color: #fff;
}
    
</style>
<?php
$hide='hidden';
if(Auth::user()->id==24 || Auth::user()->id==21 || Auth::user()->id==1){//Paty Lucy y Papi
    $hide='';
}
?>
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

<!-- Est Id Field -->
<div style="text-align:center;background:#122b40;color:white;border-radius:10px;font-size:18px;     " class="form-group panel-heading col-sm-12">
    {!! Form::hidden('est_id',$est->id , ['class' => 'form-control']) !!}
    {!! Form::label('estudiante', $est->est_apellidos." ".$est->est_nombres) !!}
    @if(isset($matriculas))
    {!! Form::hidden('mat_id',$matriculas->id , ['class' => 'form-control']) !!}
    @endif
    <label id="lbl_anio" style="float:right;color:#D0D800  " ></label>
</div>

<!-- Anl Id Field -->
<div class="form-group col-sm-6" {{$hide}} >
    {!! Form::label('anl_id', 'Año Lectivo/Periodo BGU') !!}
    {!! Form::select('anl_id',$anios,null,['class'=>'form-control']) !!}
</div>
<div class="form-group col-sm-12"  >
    
</div>
<div class="form-group col-sm-3"  >
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
    {!! Form::select('cur_id',$cursos,null,['class'=>'form-control']) !!}    
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

<div class="form-group col-sm-3" hidden >
    {!! Form::text('validar', null, ['class' => 'form-control']) !!}
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
    {!! Form::label('plantel_procedencia', 'Plantel de Procedencia:') !!}
    {!! Form::text('plantel_procedencia', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable', Auth::user()->name, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('mat_obs', 'Observaciones:') !!}
    {!! Form::text('mat_obs', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('mat_estado', 'Estado:') !!}
    {{ Form::select('mat_estado', ['Inscrito','Matriculado','Retirado','Anulado','Otro'],null,['class' => 'form-control','onchange'=>'valida_cambio(this)']) }}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('motivo', 'Motivo:') !!}
    {!! Form::text('motivo', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('fecha_asistencia', 'Fecha ultima de asistencia (dd-mm-YY):') !!}
    {!! Form::date('fecha_asistencia', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('fecha_accion', 'Retiro del sistema (dd-mm-YY):') !!}
    {!! Form::text('fecha_accion', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
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
    {!! Form::text('fac_razon_social', null, ['class' => 'form-control input-text','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('fac_ruc', 'CI/RUC') !!}
    {!! Form::text('fac_ruc', null, ['class' => 'form-control input-number','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('fac_direccion', 'Direccion') !!}
    {!! Form::text('fac_direccion', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('fac_telefono', 'Telefono') !!}
    {!! Form::text('fac_telefono', null, ['class' => 'form-control input-number','readonly'=>'readonly']) !!}
</div>

<div class="form-group col-sm-3">
    <button type="button" class="btn btn-warning" style="margin-top:25px" data-toggle="modal" data-target="#est_documentos">
        Documentos:<span class="badge" id="ndocs2"></span>
  </button>
  {!! Form::hidden('docs',null, ['class' => 'form-control','id'=>'docs']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
   @if($permisos['edit']==1) 
    {!! Form::submit('Aceptar', ['class' => 'btn btn-primary','onclick' => "return confirm('Los Datos son correctos?')",'id'=>'save']) !!}
   @endif
  <?php
    if($permisos['edit']==1){
        ?>

            <div id="radioBtn" style="margin-left:20% " class="btn-group  mx-5">
                <a class="btn btn-success btn-sm active" data-toggle="pase_anio" data-title="0">Sólo Actualizar</a>
                <a class="btn btn-success btn-sm notActive" data-toggle="pase_anio" data-title="1">Matrícula Provisional</a>
                <a class="btn btn-success btn-sm notActive" data-toggle="pase_anio" data-title="2">Pase de Año</a>
            </div>
            <input type="hidden" name="pase_anio" value="0" id="pase_anio">
 <?php
    }
  ?>
    <a href="{!! route('estudiantes.index') !!}" class="btn btn-danger pull-right">Cancelar</a>

</div>

