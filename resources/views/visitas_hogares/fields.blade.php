<?php

if(isset($visitasHogares)){
    $fa=$visitasHogares->fecha;
    $hi=$visitasHogares->h_inicio;
    $hf=$visitasHogares->h_fin;
    $sel=$visitasHogares->mat_id;
    $path=asset("img_visitas/".$visitasHogares->img_casa);
    $datos=$visitasHogares->est_apellidos.' '.$visitasHogares->est_nombres.' / '.$visitasHogares->jor_descripcion.' / '.$visitasHogares->cur_descripcion.' / '.$visitasHogares->mat_paralelo.' / '.$visitasHogares->esp_descripcion;
}else{
    $fa=date('Y-m-d');
    $hi=date('H:i a');
    $hf=date('H:i a');
    $sel='0';
    $path=null;
    $datos=null;
}

?>


<script type="text/javascript">
$(function(){
 $('.input-number').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
    });
    $("select[name=mat_id]").val('<?php echo $sel?>');
 })

// $(document).on("change","#mat_id",function(){
// //alert('okk');
// });


$(document).ready(function() {
  $(".sel-status").select2();

    if($("#cree_jesus").val()==0){
        $("#cree_porque").attr('disabled',true);        
        $("#cree_porque").val(null);        
    }else{
        $("#cree_porque").attr('disabled',false);        
        }

    if($("#usted_bautizado").val()==0){
        $("#porque_bautizado").attr('disabled',true);        
        $("#porque_bautizado").val(null);
    }else{
        $($("#porque_bautizado").attr('disabled',false));
    }

    if($("#se_congrega").val()==1){
        $("#congregra_frecuencia").attr('disabled',true);        
        $("#congregra_frecuencia").val(null);
        $("#lugar_congrega").attr('disabled',true);        
        $("#lugar_congrega").val(null);
    }else{
        $($("#congregra_frecuencia").attr('disabled',false));
        $($("#lugar_congrega").attr('disabled',false));
    }

    if($("#miembro_activo").val==1){
        $("#ministerio").attr('disabled',true);        
        $("#ministerio").val(null);
        
    }else{
        $($("#ministerio").attr('disabled',false));
    }

});


$(document).on("change","#cree_jesus",function(){

    if($("#cree_jesus").val()==0){
        $("#cree_porque").attr('disabled',true);        
        $("#cree_porque").val(null);        
    }else{
        $("#cree_porque").attr('disabled',false);        

    }
});

$(document).on("change","#usted_bautizado", function(){

    if($("#usted_bautizado").val()==0){
        $("#porque_bautizado").attr('disabled',true);        
        $("#porque_bautizado").val(null);
    }else{
        $($("#porque_bautizado").attr('disabled',false));
    }

});

$(document).on("change","#se_congrega", function(){

    if($("#se_congrega").val()==1){
        $("#congregra_frecuencia").attr('disabled',true);        
        $("#congregra_frecuencia").val(null);
        $("#lugar_congrega").attr('disabled',true);        
        $("#lugar_congrega").val(null);
    }else{
        $($("#congregra_frecuencia").attr('disabled',false));
        $($("#lugar_congrega").attr('disabled',false));
    }
});

$(document).on("change","#miembro_activo",function(){

    if($("#miembro_activo").val()==1){
        $("#ministerio").attr('disabled',true);        
        $("#ministerio").val(null);
    }else{
        $($("#ministerio").attr('disabled',false));
    }
});


function validar(){
     if ($("select[name=mat_id]").val()==0){
    alert(" Estudiante es obligatorio");

    $("select[name=mat_id]").select();
    $("select[name=mat_id]").addClass("error");
    return  false;
        }

     if($("#h_inicio").val()>=$("#h_fin").val()){
        alert('La hora de inicio no puede ser mayor a la hora final');
        $("#h_inicio").select();
        $("#h_inicio").css('border','solid 1px brown');
       return false;
     }

    if($("#cree_jesus").val()==1 && $("#cree_porque").val().length==0 ){
        alert('Campo Requerido');
        $("#cree_porque").select();
        $("#cree_porque").css('border','solid 1px brown');
        return false;
    }

    if($("#usted_bautizado").val()==1 && $("#porque_bautizado").val().length==0 ){
        alert('Campo Requerido');
        $("#porque_bautizado").select();
        $("#porque_bautizado").css('border','solid 1px brown');
        return false;
    }

    if($("#se_congrega").val()==0 && $("#congregra_frecuencia").val().length==0 ){
        alert('Campos Requeridos');
        $("#congregra_frecuencia").select();
        $("#congregra_frecuencia").css('border','solid 1px brown');
        $("#lugar_congrega").css('border','solid 1px brown');
        return false;
    }

    if($("#miembro_activo").val()==0 && $("#ministerio").val().length==0){
        alert('Campo Requerido');
        $("#ministerio").select();
        $("#ministerio").css('border','solid 1px brown');
        return false;
    }

}

            $(function(){
                $("select[name=mat_id]").change(function(){
                   var token=$("input[name=_token]").val();
                   var url=window.location;
                   var matid=$("select[name=mat_id]").val();;
                   
                   $.ajax({
                    url:url+'/buscar_visita_hogares',
                    headers:{'X-CSRF-TOKEN':token},
                    type: 'POST',
                    dataType: 'json',
                    data: {matid:matid},
                    beforeSend:function(){

                    },
                    success:function(dt){
                        $("input[name=numero]").val(dt);
                    }
                })

               });
            })

            $(document).on('click','.btn_select',function(){
                var matid=$(this).attr('data');
                var obj=$(this).parent().parent();
                $("select[name=mat_id]").val(matid);
                //alert($(obj).find('.es_nombres').text());
                $(".est_datos").html($(obj).find('.es_nombres').text()+' '+$(obj).find('.es_jornadas').text());

            })

$(document).on('click','#btn_search',function(){
                     var url=window.location;
                     var token=$("input[name=_token]").val();
                     var est=$("input[name=estudiante]").val();
                    $.ajax({
                        url:url+'/buscar_estudiantes',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {est:est},
                        beforeSend:function(){

                        },
                        success:function(dt){
                                $("#tbl_estudiantes").html(dt);
                        }
                    })    
});

</script>

<style>
    .img_casa{
        width:200px; 
        height:200px; 
        border:solid 5px #000;
        border-radius:8px; 
        padding:2px; 
    }
    .titles{
        text-align: center;
        background: silver; 
        font-weight: bold;
    }
    .error{
        border: solid 1px brown;
    }    
    .file_img_casa{
        width:250px;
        height:250px !important;  
    }
</style>

<div class="modal fade" id="modal_estudiantes" tabindex="-1" role="dialog" aria-labelledby="modal_es" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <h5 class="modal-title bg-primary" id="modal_es" style="padding:7px; ">
            Elija un Estudiante
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </h5>
      <div class="modal-body">
        <table  class="table">
            <th>N</th>
            <th>Estudiante</th>
            <th></th>
            <tbody id="tbl_estudiantes">

                
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<div class="form-group col-sm-2">
    {!! Form::label('tipo', 'Tipo de Visita:') !!}
    {!! Form::select('tipo',[
        '0' => 'Regular',
        '1' => 'Especial',
        ],null, ['class' => 'form-control', 'required']) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('numero', 'Numero de visita:') !!}
    {!! Form::text('numero',null, ['class' => 'form-control input-number','readonly'=> 'readonly']) !!}
</div>
<!-- Fecha Field -->
<div class="form-group col-sm-2">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha',$fa, ['class' => 'form-control']) !!}
</div>
<!-- H Inicio Field -->
<div class="form-group col-sm-2">
    {!! Form::label('h_inicio', 'Hora de Inicio:') !!}
    {!! Form::time('h_inicio',$hi, ['class' => 'form-control', 'required']) !!}
</div>

<!-- H Fin Field -->
<div class="form-group col-sm-2">
    {!! Form::label('h_fin', 'Hora de Fin:') !!}
    {!! Form::time('h_fin',$hf, ['class' => 'form-control', 'required']) !!}
</div>

<div class="col-sm-12">
    <h4 class="bg-info text-center titulo text-info" >Datos Principales</h4>
</div>

<!-- Mat Id Field -->
<div class="form-group col-sm-4">
  <div class="input-group">
    {!! Form::text('estudiante',null, ['class' => 'form-control ']) !!}
    <span class="input-group-addon btn btn-primary" id="btn_search" data-toggle="modal" data-target="#modal_estudiantes" ><i class="fa fa-search">Buscar</i></span>
</div>
</div>  

<div class="form-group col-sm-8 bg-warning text-warning" style="margin-top:0px; ">
    <div class="est_datos" style="height:35px;padding:7px;font-size:20px;font-weight:bold;">{{$datos}}</div>
</div>
<!-- Mat Id Field -->
<div class="form-group col-sm-4" hidden >
    {!! Form::label('mat_id', 'Estudiante:') !!}
    {!! Form::select('mat_id',$estudiantes,null, ['class' => 'form-control ', 'required']) !!}
</div>
<!-- Usu Id Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',Auth::User()->id, ['class' => 'form-control']) !!}
</div>

<div class="row container">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('sector', 'Sector:') !!}
            {!! Form::text('sector', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('barrio', 'Barrio:') !!}
            {!! Form::text('barrio', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('calles', 'Calles:') !!}
            {!! Form::text('calles', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('punto_ref', 'Punto Referencia:') !!}
            {!! Form::text('punto_ref', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <div class="col-sm-6">
            <label for="img_casa">Imagen de la casa</label>    
            <img src="{{$path}}" class="img_casa"  >
            <div>
                {!! Form::file('img_casa', null, ['class' => 'file_img_casa','accept'=>'image/*']) !!}
            </div>
    </div>

</div>
<!-- Punto Ref Field -->
<div class="form-group col-sm-4" hidden>
    {!! Form::label('croquis', 'Croquis:') !!}
    {!! Form::text('croquis', null, ['class' => 'form-control']) !!}
</div>

<!-- Genograma Field -->
<div class="form-group col-sm-4" hidden>
    {!! Form::label('genograma', 'Genograma:') !!}
    {!! Form::text('genograma', null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    <h4 class="titles">Antecedentes</h4>
</div>   

<!-- Ant Familiares Field -->
<div class="form-group col-sm-4">
    {!! Form::label('ant_familiares', 'Antecedentes Familiares:') !!}
    {!! Form::textarea('ant_familiares', null, ['class' => 'form-control', 'rows' => '1', 'required']) !!}
</div>

<!-- Ant Academicas Field -->
<div class="form-group col-sm-4">
    {!! Form::label('ant_academicas', 'Antecedentes Academicas:') !!}
    {!! Form::textarea('ant_academicas', null, ['class' => 'form-control', 'rows' => '1', 'required']) !!}
</div>

<!-- Ant Conductuales Field -->
<div class="form-group col-sm-4">
    {!! Form::label('ant_conductuales', 'Antecedentes Conductuales:') !!}
    {!! Form::textarea('ant_conductuales', null, ['class' => 'form-control', 'rows' => '1', 'required']) !!}
</div>

<div class="col-sm-12">
    <h4 class="titles">Servicios Básicos</h4>
</div>

<!-- Agua Field -->
<div class="form-group col-sm-3">
    {!! Form::label('agua', 'Agua:') !!}
    {!! Form::select('agua',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Luz Field -->
<div class="form-group col-sm-3">
    {!! Form::label('luz', 'Luz:') !!}
    {!! Form::select('luz',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('telefono', 'Teléfono:') !!}
    {!! Form::select('telefono',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Internet Field -->
<div class="form-group col-sm-3">
    {!! Form::label('internet', 'Internet:') !!}
    {!! Form::select('internet',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Tvcable Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tvcable', 'Tvcable:') !!}
    {!! Form::select('tvcable',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Otros Field -->
<div class="form-group col-sm-3">
    {!! Form::label('otros', 'Otros:') !!}
    {!! Form::text('otros', null, ['class' => 'form-control']) !!}
</div>

<!-- Tipo Vivienda Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tipo_vivienda', 'Tipo de Vivienda:') !!}
    {!! Form::select('tipo_vivienda',[

        '0' => 'Propia',
        '1' => 'Arrendada',
        '2' => 'Prestada',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Tipo Construccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tipo_construccion', 'Tipo de Construccion:') !!}
    {!! Form::text('tipo_construccion', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="col-sm-12">
    <h4 class="titles">Aspecto Espiritual</h4>
</div>

<!-- Vida Cristo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('vida_cristo', '¿Entregó su vida a Cristo?') !!}
    {!! Form::select('vida_cristo',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Necesita Ayuda Field -->
<div class="form-group col-sm-3">
    {!! Form::label('necesita_ayuda', 'Necesita Ayuda:') !!}
    {!! Form::select('necesita_ayuda',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    
</div>


<!-- Cree Jesus Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cree_jesus', '¿Cree que Jesús es el Hijo Unigénito de Dios?') !!}
    {!! Form::select('cree_jesus',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Cree Porque Field -->
<!--Validar y permitir en cualquier respuesta (Jesus hijo unigénito...)-->
<div class="form-group col-sm-3">
    {!! Form::label('cree_porque', '¿Porqué?:') !!} 
    {!! Form::text('cree_porque', null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    
</div>

<!--Bautizado Field-->
<div class="form-group col-sm-3">
    {!! Form::label('usted_bautizado', '¿Es bautizado?:') !!}
    {!! Form::select('usted_bautizado',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Porque Bautizado Field -->
<!--Validar y permitir solo si es negativa (Bautizado)-->
<div class="form-group col-sm-3">
    {!! Form::label('porque_bautizado', '¿Porqué?') !!}
    {!! Form::text('porque_bautizado', null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    
</div>

<!-- Se Congrega Field -->
<div class="form-group col-sm-3">
    {!! Form::label('se_congrega', '¿Actualmente se congrega?:') !!}
    {!! Form::select('se_congrega',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Congregra Frecuencia Field -->
<!--Validar y permitir solo si es afirmativa (Actualmente congrega)-->
<div class="form-group col-sm-3">
    {!! Form::label('congregra_frecuencia', '¿Con qué frecuencia?') !!}
    {!! Form::text('congregra_frecuencia',null, ['class' => 'form-control']) !!}
</div>

<!-- Lugar Congrega Field -->
<!--Validar y permitir en cualquier respuesta (Congrega frecuentemente)-->
<div class="form-group col-sm-3">
    {!! Form::label('lugar_congrega', '¿Dónde se congrega?') !!}
    {!! Form::text('lugar_congrega', null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    
</div>

<!-- Miembro Activo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('miembro_activo', '¿Es un miembro activo de su congregación?:') !!}
    {!! Form::select('miembro_activo',[

        '0' => 'Sí',
        '1' => 'No',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Ministerio Field -->
<!--Validar y permitir solo si es afirmativa (miembro activo)-->
<div class="form-group col-sm-3">
    {!! Form::label('ministerio', '¿En qué Ministerio?') !!}
    {!! Form::text('ministerio', null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    
</div>

<!-- Libros Manuales Field -->
<div class="form-group col-sm-6">
    {!! Form::label('libros_manuales', '¿Qué libros y/o manuales utiliza para su crecimiento espiritual?:') !!}
    {!! Form::text('libros_manuales', null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    
</div>

<!-- Religion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('religion', 'Religión:') !!}
    {!! Form::text('religion', null, ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    
</div>

<!-- Peticion Oracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('peticion_oracion', 'Petición de Oración:') !!}
    {!! Form::textarea('peticion_oracion', null, ['class' => 'form-control', 'rows' => '1' ]) !!}
</div>

<div class="col-sm-12">
    
</div>

<!-- Porcion Biblica Field -->
<div class="form-group col-sm-6">
    {!! Form::label('porcion_biblica', 'Porción Bíblica:') !!}
    {!! Form::textarea('porcion_biblica', null, ['class' => 'form-control', 'rows' => '1']) !!}
</div>

<div class="col-sm-12">
    <h4 class="titles">Recomendaciones</h4>
</div>

<!-- Recomendaciones Familia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recomendaciones_familia', 'Recomendaciones a la Familia:') !!}
    {!! Form::textarea('recomendaciones_familia', null, ['class' => 'form-control', 'rows' => '4']) !!}
</div>

<!-- Recomendaciones Colegio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recomendaciones_colegio', 'Recomendaciones al Colegio:') !!}
    {!! Form::textarea('recomendaciones_colegio', null, ['class' => 'form-control', 'rows' => '4']) !!}
</div>

<div class="col-sm-12">
    
</div>


<!-- Estado Field -->
<div class="form-group col-sm-4">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',[

        '0' => 'Activo',
        '1' => 'Inactivo',

        ] ,null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('visitasHogares.index') !!}" class="btn btn-default">Cancelar</a>
</div>
