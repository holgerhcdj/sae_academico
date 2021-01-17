<?php
$m_si=null;
$p_si=null;
$rp_si=null;
$sa_si=null;
$es_discapacidad=null;
if(isset($fichaDece->m_si)){
  $m_si=$fichaDece->m_si;
}
if(isset($fichaDece->p_si)){
  $p_si=$fichaDece->p_si;
}
if(isset($fichaDece->rp_si)){
  $rp_si=$fichaDece->rp_si;
}

if(isset($fichaDece->sa_si)){
  $sa_si=$fichaDece->sa_si;
}

if(isset($fichaDece->es_discapacidad)){
  $es_discapacidad=$fichaDece->es_discapacidad;
}

?>
<style>
    .error{
        border: solid 1px brown;
    }
</style>
<script type="text/javascript">
    $(document).on("click","input[name=m_si]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.madre').each(function(){
            $(this).attr('disabled',vl);
        });

    });
    $(document).on("click","input[name=p_si]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.padre').each(function(){
            $(this).attr('disabled',vl);
        });

    });

    $(document).on("click","input[name=sa_si]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.enfermedad').each(function(){
            $(this).attr('disabled',vl);
        });

    });

    $(document).on("click","input[name=es_discapacidad]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.discapacidad').each(function(){
            $(this).attr('disabled',vl);
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

$(function(){
var m='<?php echo $m_si?>';
var p='<?php echo $p_si?>';
var rp='<?php echo $rp_si?>';
var sa='<?php echo $sa_si?>';
var es_discapacidad='<?php echo $es_discapacidad?>';

if(m==0){
    $("input[name=m_si]").prop('checked',true);
        $('.madre').each(function(){
            $(this).attr('disabled',false);
        });

}else if(m==1){
    $("input[name=m_si]").prop('checked',false);
        $('.madre').each(function(){
            $(this).attr('disabled',true);
        });

}

if(p==0){
    $("input[name=p_si]").prop('checked',true);
        $('.padre').each(function(){
            $(this).attr('disabled',false);
        });

}else if(p==1){
    $("input[name=p_si]").prop('checked',false);
        $('.padre').each(function(){
            $(this).attr('disabled',true);
        });

}

if(rp==0){
    $("input[name=rp_si]").prop('checked',true);
        $('.representante').each(function(){
            $(this).attr('disabled',false);
        });

}else if(rp==1){
    $("input[name=rp_si]").prop('checked',false);
        $('.representante').each(function(){
            $(this).attr('disabled',true);
        });

}

if(sa==0){
    $("input[name=sa_si]").prop('checked',true);
        $('.enfermedad').each(function(){
            $(this).attr('disabled',false);
        });

}else if(sa==1){
    $("input[name=sa_si]").prop('checked',false);
        $('.enfermedad').each(function(){
            $(this).attr('disabled',true);
        });

}

if(es_discapacidad==0){
    $("input[name=es_discapacidad]").prop('checked',true);
        $('.discapacidad').each(function(){
            $(this).attr('disabled',false);
        });

}else if(es_discapacidad==1){
    $("input[name=es_discapacidad]").prop('checked',false);
        $('.discapacidad').each(function(){
            $(this).attr('disabled',true);
        });

}

})

$(document).on("change","select[name=rp_si]",function(){

    if($(this).val()==0){
        if($('input[name=m_si]').prop('checked')==true){
               var sigla='m';
               var nm='MADRE';
               var num='_num_doc';
        }else{
            alert('No existen Datos de la Madre');
            $('select[name=rp_si]').val('');
        }
    }else if($(this).val()==1){
        if($('input[name=p_si]').prop('checked')==true){
               var sigla='p'; 
               var nm='PADRE';
               var num='_nup_doc';
        }else{
            alert('No existen Datos del Padre');
            $('select[name=rp_si]').val('');
        }
       
    }

$("input[name=rp_parentezco]").val(nm);
$("input[name=rp_apellidos]").val( $("input[name="+sigla+"_apellidos]").val() );
$("input[name=rp_nombres]").val( $("input[name="+sigla+"_nombres]").val() );
$("select[name=rp_tipo_doc]").val( $("select[name="+sigla+"_tipo_doc]").val() );
$("input[name=rp_nurp_doc]").val( $("input[name="+sigla+num+"]").val() );
$("input[name=rp_edad]").val( $("input[name="+sigla+"_edad]").val() );
$("select[name=rp_est_civil]").val( $("select[name="+sigla+"_est_civil]").val() );
$("select[name=rp_instruccion]").val( $("select[name="+sigla+"_instruccion]").val() );
$("input[name=rp_profesion]").val( $("input[name="+sigla+"_profesion]").val() );
$("input[name=rp_ingresos]").val( $("input[name="+sigla+"_ingresos]").val() );
$("input[name=rp_telefono]").val( $("input[name="+sigla+"_telefono]").val() );
$("input[name=rp_celular]").val( $("input[name="+sigla+"_celular]").val() );

})


 if($("select[name=es_tipo_seguro]").val()==0){
        
        $("input[name=es_seguro]").attr('disabled',true);
        $("input[name=es_seguro]").val();

    }else if ($("select[name=es_tipo_seguro]").val()==1){
        
        $("input[name=es_seguro]").attr('disabled',true);
        $("input[name=es_seguro]").val("IESS");

    }else if ($("select[name=es_tipo_seguro]").val()==2){

        $("input[name=es_seguro]").attr('disabled',false);
        $("input[name=es_seguro]").val();
        
    }



$(document).on("change","select[name=es_tipo_seguro]",function(){

    if($(this).val()==0){
        
        $("input[name=es_seguro]").attr('disabled',true);
        $("input[name=es_seguro]").val(" ");

    }else if ($(this).val()==1){
        
        $("input[name=es_seguro]").attr('disabled',true);
        $("input[name=es_seguro]").val("IESS");

    }else if ($(this).val()==2){

        $("input[name=es_seguro]").attr('disabled',false);
        $("input[name=es_seguro]").val(" ");
        
    }
})


// BOTON GUARDAR 

function validar(){

    //DATOS DE LA MADRE

if($("input[name=m_si]").prop('checked')==true){

    if ($("input[name=m_apellidos]").val().length==0){
    alert("Apellidos de la Madre es obligatorio");
        $("#madre").addClass('in active');
        $("input[name=m_apellidos]").select();
        $("input[name=m_apellidos]").addClass("error");
    return  false;
        }

     if ($("input[name=m_nombres]").val().length==0){
    alert("Nombres de la Madre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=m_nombres]").select();
        $("input[name=m_nombres]").addClass("error");
    return  false;
        }

    if ($("input[name=m_num_doc]").val().length==0){
    alert("Número de documento de la Madre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=m_num_doc]").select();
        $("input[name=m_num_doc]").addClass("error");
    return  false;
        }

    if ($("input[name=m_edad]").val().length==0){
    alert("Edad de la Madre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=m_edad]").select();
        $("input[name=m_edad]").addClass("error");
    return  false;
        }

    if ($("input[name=m_profesion]").val().length==0){
    alert("Prodesión de la Madre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=m_profesion]").select();
        $("input[name=m_profesion]").addClass("error");
    return  false;
        }

    if ($("input[name=m_ingresos]").val().length==0){
    alert("Ingresos de la Madre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=m_ingresos]").select();
        $("input[name=m_ingresos]").addClass("error");
    return  false;
        }

    if ($("input[name=m_telefono]").val().length==0){
    alert("Teléfono de la Madre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=m_telefono]").select();
        $("input[name=m_telefono]").addClass("error");
    return  false;
        }

    if ($("input[name=m_celular]").val().length==0){
    alert("Celular de la Madre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=m_celular]").select();
        $("input[name=m_celular]").addClass("error");
    return  false;
        }
    }

    //DATOS DEL PADRE

if($("input[name=p_si]").prop('checked')==true){


    if ($("input[name=p_apellidos]").val().length==0){
    alert("Apellidos del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_apellidos]").select();
        $("input[name=p_apellidos]").addClass("error");
    return  false;
        }

     if ($("input[name=p_nombres]").val().length==0){
    alert("Nombres del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_nombres]").select();
        $("input[name=p_nombres]").addClass("error");
    return  false;
        }

    if ($("input[name=p_nup_doc]").val().length==0){
    alert("Número de documento del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_nup_doc]").select();
        $("input[name=p_nup_doc]").addClass("error");
    return  false;
        }

    if ($("input[name=p_edad]").val().length==0){
    alert("Edad del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_edad]").select();
        $("input[name=p_edad]").addClass("error");
    return  false;
        }

    if ($("input[name=p_profesion]").val().length==0){
    alert("Prodesión del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_profesion]").select();
        $("input[name=p_profesion]").addClass("error");
    return  false;
        }

    if ($("input[name=p_ingresos]").val().length==0){
    alert("Ingresos del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_ingresos]").select();
        $("input[name=p_ingresos]").addClass("error");
    return  false;
        }

    if ($("input[name=p_telefono]").val().length==0){
    alert("Teléfono del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_ingresos]").select();
        $("input[name=p_ingresos]").addClass("error");
    return  false;
        }

    if ($("input[name=p_celular]").val().length==0){
    alert("Celular del Padre es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=p_celular]").select();
        $("input[name=p_celular]").addClass("error");
    return  false;
        }

    }

    //DATOS DEL REPRESENTANTE

if($("input[name=rp_si]").prop('checked')==true){

    if ($("input[name=rp_parentezco]").val().length==0){
    alert("Parentezco del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_parentezco]").select();
        $("input[name=rp_parentezco]").addClass("error");
    return  false;
        }

    if ($("input[name=rp_apellidos]").val().length==0){
    alert("Apellidos del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_apellidos]").select();
        $("input[name=rp_apellidos]").addClass("error");
    return  false;
        }

     if ($("input[name=rp_nombres]").val().length==0){
    alert("Nombres del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_nombres]").select();
        $("input[name=rp_nombres]").addClass("error");
    return  false;
        }

    if ($("input[name=rp_nurp_doc]").val().length==0){
    alert("Número de documento del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_nurp_doc]").select();
        $("input[name=rp_nurp_doc]").addClass("error");
    return  false;
        }

    if ($("input[name=rp_edad]").val().length==0){
    alert("Edad del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_edad]").select();
        $("input[name=rp_edad]").addClass("error");
    return  false;
        }

    if ($("input[name=rp_profesion]").val().length==0){
    alert("Prodesión del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_profesion]").select();
        $("input[name=rp_profesion]").addClass("error");
    return  false;
        }

    if ($("input[name=rp_ingresos]").val().length==0){
    alert("Ingresos del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_ingresos]").select();
        $("input[name=rp_ingresos]").addClass("error");
    return  false;
        }

    if ($("input[name=rp_telefono]").val().length==0){
    alert("Teléfono del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_telefono]").select();
        $("input[name=rp_telefono]").addClass("error");
    return  false;
        }

    if ($("input[name=rp_celular]").val().length==0){
    alert("Celular del Representante es obligatorio");
    $("#madre").addClass('in active');
        $("input[name=rp_celular]").select();
        $("input[name=rp_celular]").addClass("error");
    return  false;
        }

    }


    //ESTRUCTURA FAMILIAR

if ($("input[name=ef_relacion_familiar]").val().length==0){
    alert("Relación Familiar es obligatorio");
    $("#est_familiar").addClass('in active');
        $("input[name=ef_relacion_familiar]").select();
        $("input[name=ef_relacion_familiar]").addClass("error");
    return  false;
        }

if ($("input[name=n_her_8vo]").val().length==0){
    alert("Número de hermanos 8vo es obligatorio");
    $("#est_familiar").addClass('in active');
        $("input[name=n_her_8vo]").select();
        $("input[name=n_her_8vo]").addClass("error");
    return  false;
        }

if ($("input[name=n_her_9vo]").val().length==0){
    alert("Número de hermanos 9no es obligatorio");
    $("#est_familiar").addClass('in active');
        $("input[name=n_her_9vo]").select();
        $("input[name=n_her_9vo]").addClass("error");
    return  false;
        }

if ($("input[name=n_her_10vo]").val().length==0){
    alert("Número de hermanos 10mo es obligatorio");
    $("#est_familiar").addClass('in active');
        $("input[name=n_her_10vo]").select();
        $("input[name=n_her_10vo]").addClass("error");
    return  false;
        }

if ($("input[name=n_her_1vo]").val().length==0){
    alert("Número de hermanos 1ro es obligatorio");
    $("#est_familiar").addClass('in active');
        $("input[name=n_her_1vo]").select();
        $("input[name=n_her_1vo]").addClass("error");
    return  false;
        }

if ($("input[name=n_her_2vo]").val().length==0){
    alert("Número de hermanos 2do es obligatorio");
    $("#est_familiar").addClass('in active');
        $("input[name=n_her_2vo]").select();
        $("input[name=n_her_2vo]").addClass("error");
    return  false;
        }

if ($("input[name=n_her_3vo]").val().length==0){
    alert("Número de hermanos 3ro es obligatorio");
    $("#est_familiar").addClass('in active');
        $("input[name=n_her_3vo]").select();
        $("input[name=n_her_3vo]").addClass("error");
    return  false;
        }

    //DATOS SOCIO ECONOMICO

if ($("input[name=sc_num_hab]").val().length==0){
    alert("Num.Habitaciones es obligatorio");
    $("#socio_economico").addClass('in active');
        $("input[name=sc_num_hab]").select();
        $("input[name=sc_num_hab]").addClass("error");
    return  false;
        }

    //ANTECEDENTES ESCOLARES

if ($("input[name=ae_primaria]").val().length==0){
    alert("Primaria es obligatorio");
    $("#antecedentes_escolares").addClass('in active');
        $("input[name=ae_primaria]").select();
        $("input[name=ae_primaria]").addClass("error");
    return  false;
        }

if ($("input[name=ae_repetidos]").val().length==0){
    alert("Años Repetidos es obligatorio");
    $("#antecedentes_escolares").addClass('in active');
        $("input[name=ae_repetidos]").select();
        $("input[name=ae_repetidos]").addClass("error");
    return  false;
        }

if ($("input[name=ae_causa_rep]").val().length==0){
    alert("Causa de Repetición es obligatorio");
    $("#antecedentes_escolares").addClass('in active');
        $("input[name=ae_causa_rep]").select();
        $("input[name=ae_causa_rep]").addClass("error");
    return  false;
        }

if ($("input[name=ae_inst_procedencia]").val().length==0){
    alert("Institución de Procedencia es obligatorio");
    $("#antecedentes_escolares").addClass('in active');
        $("input[name=ae_inst_procedencia]").select();
        $("input[name=ae_inst_procedencia]").addClass("error");
    return  false;
        }

if ($("input[name=ae_motivo_cambio]").val().length==0){
    alert("Motivo Cambio es obligatorio");
    $("#antecedentes_escolares").addClass('in active');
        $("input[name=ae_motivo_cambio]").select();
        $("input[name=ae_motivo_cambio]").addClass("error");
    return  false;
        }

    //ASPECTO PEDAGOGICO

if ($("input[name=ap_apoyo_nombre]").val().length==0){
    alert("Persona que Apoya es obligatorio");
    $("#aspecto_pedagogico").addClass('in active');
        $("input[name=ap_apoyo_nombre]").select();
        $("input[name=ap_apoyo_nombre]").addClass("error");
    return  false;
        }

if ($("input[name=ap_horas_estudio]").val().length==0){
    alert("Horas destinadas para el estudio es obligatorio");
    $("#aspecto_pedagogico").addClass('in active');
        $("input[name=ap_horas_estudio]").select();
        $("input[name=ap_horas_estudio]").addClass("error");
    return  false;
        }


    //ESTADO DE SALUD

if($("input[name=sa_si]").prop('checked')==true){

    if ($("input[name=es_enfermedad1]").val().length==0){
    alert("Enfermedad es obligatorio");
    $("#estado_salud").addClass('in active');
        $("input[name=es_enfermedad1]").select();
        $("input[name=es_enfermedad1]").addClass("error");
    return  false;
        }

     if ($("textarea[name=es_tratamiento1]").val().length==0){
    alert("Tratamiento es obligatorio");
    $("#estado_salud").addClass('in active');
        $("input[name=es_tratamiento1]").select();
        $("input[name=es_tratamiento1]").addClass("error");
    return  false;
        }

    }


if($("select[name=es_tipo_seguro]").val()==2){

        if($("input[name=es_seguro]").val().length<=1){
       alert("Nombre del Seguro es obligatorio");
       $("#estado_salud").addClass('in active');
        $("input[name=es_seguro]").select();
        $("input[name=es_seguro]").addClass("error");
    return  false;   
        }
    }


    //DISCAPACIDAD

if($("input[name=es_discapacidad]").prop('checked')==true){

    if ($("input[name=es_porcentage_disc]").val().length==0){
    alert("Porcentaje es obligatorio");
    $("#discapacidad").addClass('in active');
        $("input[name=es_porcentage_disc]").select();
        $("input[name=es_porcentage_disc]").addClass("error");
    return  false;
        }

    if ($("input[name=es_tipo_discapacidad]").val().length==0){
    alert("Tipo de Discapacidad es obligatorio");
    $("#discapacidad").addClass('in active');
        $("input[name=es_tipo_discapacidad]").select();
        $("input[name=es_tipo_discapacidad]").addClass("error");
    return  false;
        }

    if ($("input[name=es_vive_persona_discapacidad]").val().length==0){
    alert("Vive con persona con discapacidad es obligatorio");
    $("#discapacidad").addClass('in active');
        $("input[name=es_vive_persona_discapacidad]").select();
        $("input[name=es_vive_persona_discapacidad]").addClass("error");
    return  false;
        }

    if ($("textarea[name=es_tratamiento_disc]").val().length==0){
    alert("Tratamiento es obligatorio");
    $("#discapacidad").addClass('in active');
        $("input[name=es_tratamiento_disc]").select();
        $("input[name=es_tratamiento_disc]").addClass("error");
    return  false;
        }

    }

    if ($("select[name=estado]").val()==0){
    alert("Estado es obligatorio");
    $("#discapacidad").addClass('in active');
        $("input[name=estado]").select();
        $("input[name=estado]").addClass("error");
    return  false;
        }

    //FIN
   
}




</script>
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

    {!! Form::hidden('mat_id',$est->mat_id,null, ['class' => 'form-control ']) !!}
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#madre">Padre/Madre</a></li>
  <li ><a data-toggle="tab" href="#est_familiar">Estructura Familiar</a></li>
  <li ><a data-toggle="tab" href="#socio_economico">Datos Socio Económico</a></li>
  <li ><a data-toggle="tab" href="#antecedentes_escolares">Antecedentes Escolares y NEE</a></li>
  <li ><a data-toggle="tab" href="#aspecto_pedagogico">Aspecto Pedagógico</a></li>
  <li ><a data-toggle="tab" href="#estado_salud">Estado de Salud</a></li>
  <li ><a data-toggle="tab" href="#discapacidad">Discapacidad</a></li>
</ul>
<div class="tab-content">
            <div id="madre" class="tab-pane fade in active">
                @include('ficha_deces.padre_madre_representante')
            </div>
            <div id="est_familiar" class="tab-pane fade">
                @include('ficha_deces.estructura_familiar')
            </div>
            <div id="socio_economico" class="tab-pane fade">
                @include('ficha_deces.datos_socioeconomico')
            </div>
            <div id="antecedentes_escolares" class="tab-pane fade">
                @include('ficha_deces.antecedentes_escolares')
            </div>
            <div id="aspecto_pedagogico" class="tab-pane fade">
                @include('ficha_deces.aspecto_pedagogico')
            </div>
            <div id="estado_salud" class="tab-pane fade">
                @include('ficha_deces.estado_salud')
            </div>
            <div id="discapacidad" class="tab-pane fade">
                @include('ficha_deces.discapacidad')
            </div>

</div>