@extends('layouts.app')
@section('content')
<?php
//date_default_timezone_set('America/Guayaquil');
$today=date('Y-m-d H:i');
$d=date('Y-m-d');
$h=date('Y-m-d');

?>
    <section class="content-header">
        <h1>
            Tareas y Actividades 
            <span class="badge" style='background:#1d8bfa '>Matutina</span>
            <span class="badge" style='background:#000 '>Nocturna</span>
            <span class="badge" style='background:#778899 '>Semi-Presencial</span>
        </h1>

        <span class="pull-right" style="background:#D9B90E;padding:5px;border-radius:5px;margin-top:-10px;color:white " id="t_calificar" ></span>


        @if(Auth::user()->id==22 || Auth::user()->id==93 || Auth::user()->id==54 || Auth::user()->id==1)
            <form action="descargar_tareas_enviadas" method="POST">
              {{csrf_field()}}
              <div class='col-md-6' style='border:solid 1px #ccc;padding:5px;background:#eee ; '>
                <div class='col-md-5'>
                  <input type="date" name="fdesde" class='form-control' value="{{$d}}">
                </div>
                <div class='col-md-5'>
                  <input type="date" name="fhasta" class='form-control' value="{{$h}}">
                </div>
                <div class='col-md-2'>
                  <button class='btn btn-success fa fa-file-excel-o'>Reporte</button>
                </div>
              </div>
            </form>
        @endif    

   </section>


        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">

                <link href="{{asset('packages/core/main.css')}}" rel='stylesheet' />
                <link href="{{asset('packages/daygrid/main.css')}}" rel='stylesheet' />
                <link href="{{asset('packages/timegrid/main.css')}}" rel='stylesheet' />

                <script src="{{asset('packages/core/main.js')}}"></script>
                <script src="{{asset('packages/interaction/main.js')}}"></script>
                <script src="{{asset('packages/daygrid/main.js')}}"></script>
                <script src="{{asset('packages/timegrid/main.js')}}"></script>


                <link href="{{asset('packages/list/main.css')}}"  rel='stylesheet' />
                <script src="{{asset('packages/list/main.js')}}" ></script>
<script>
$(function(){

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale:'es',
      plugins: [ 'interaction', 'dayGrid' ],
      header: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },

      defaultDate: '{{$today}}',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      weekNumbers: true,
       droppable: false,
      select: function(arg) {

        $("#modal_tareas").modal("show");
         limpiar_datos(arg.startStr);
         calendar.unselect();

      },
      editable: true,
      events: [
      ],
      eventClick: function(arg) {
        id=arg.event.groupId;
        cargar_datos(id);
        $("#modal_tareas").modal("show");

                $("select[name=jor_id]").attr('disabled',true);
                $("select[name=esp_id]").attr('disabled',true);
                $("select[name=cur_id]").attr('disabled',true);
                $("select[name=paralelo]").attr('disabled',true);


      }      
    });
    calendar.render();
   add_events(calendar);

})

function limpiar_datos(f){

            var token=$("input[name=_token]").val();
            var url=window.location;
            $.ajax({
              url:url+'/load_codigo_tarea',
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {op:0},
              beforeSend:function(){
                //Swal.showLoading();
              },
              success:function(dt){

                $("input[name=tar_codigo]").val(dt);

              }
            })
             
                $("input[name=tar_id]").val(0);
                $("input[name=tar_tipo]").val(0);
                $("input[name=tar_titulo]").val(null);
                $("textarea[name=tar_descripcion]").val(null);
                $("file[name=tar_adjuntos]").val(null);
                $("#tar_finicio").val(f);
                $("#lbl_adjuntos").html('');
                $("#aux_tru_doc_adjunto").val('');

                $("select[name=tar_hinicio]").val('07');
                $("#tar_ffin").val(f);
                $("select[name=tar_hfin]").val('23');
                $("select[name=tar_estado]").val(0);
                $("select[name=jor_id]").val(1);
                $("select[name=esp_id]").val(10);
                $("select[name=cur_id]").val(1);
                $("select[name=paralelo]").val('A');
                $("select[name=tar_link]").val(null);
                $("#lbl_adjunto").text("");
                $("#dvi_estudiantes").html(null);

                $("select[name=jor_id]").attr('disabled',false);
                $("select[name=esp_id]").attr('disabled',false);
                $("select[name=cur_id]").attr('disabled',false);
                $("select[name=paralelo]").attr('disabled',false);
}

function cargar_datos(tar_id){

            var token=$("input[name=_token]").val();
            var url=window.location;
         $.ajax({
            url:url+'/load_una_tarea', //AulaVirtualController@load_una_tarea
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {tar_id:tar_id},
            beforeSend:function(){
                Swal.showLoading("Cargando");
            },
            success:function(dt){

                $("input[name=tar_id]").val(dt[0]['tar_id']);
                $("select[name=tar_tipo]").val(dt[0]['tar_tipo']);
                $("input[name=tar_titulo]").val(dt[0]['tar_titulo']);
                $("textarea[name=tar_descripcion]").val(dt[0]['tar_descripcion']);
                $("#tar_adjuntos").val(dt[0]['tar_adjuntos']);
                $("input[name=tar_link]").val(dt[0]['tar_link']);

                if(dt[0]['tar_adjuntos']!=null){
                  dt[0]['tar_adjuntos']="<span class='btn btn-default' style='color:#0061D8'   >"+dt[0]['tar_adjuntos']+"</span>";

                }
                $("#lbl_adjuntos").html(dt[0]['tar_adjuntos']);
                $("#tar_finicio").val(dt[0]['tar_finicio']);
                $("select[name=tar_hinicio]").val(dt[0]['tar_hinicio'].substring(0,2));
                $("#tar_ffin").val(dt[0]['tar_ffin']);
                $("select[name=tar_hfin]").val(dt[0]['tar_hfin'].substring(0,2));
                $("select[name=tar_estado]").val(dt[0]['tar_estado']);
                $("input[name=tar_codigo]").val(dt[0]['tar_codigo']);
                $("select[name=esp_id]").val(dt[0]['esp_id']);
                var enc=dt[0]['tar_aux_cursos'].split('-');
                $("select[name=jor_id]").val(enc[0]);
                $("select[name=cur_id]").val(enc[2]);
                $("select[name=paralelo]").val(enc[3]);
                $("#dvi_estudiantes").html(dt[1]);
                $("select[name=tar_mostrar]").val(dt[0]['tar_mostrar']);
                carga_materias($("select[name=jor_id]").val(),$("select[name=esp_id]").val(),$("select[name=cur_id]").val(),dt[0]['mtr_id']);
                Swal.hideLoading("Okk");

            },
                error : function(jqXHR, textStatus, errorThrown) {

                   if (jqXHR.status === 0) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (jqXHR.status == 404) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (jqXHR.status == 500) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (textStatus === 'parsererror') {
                    mensaje("error","Error en Conexión de red","Requested JSON parse failed.");
                    $(obj).val(0);
                } else if (textStatus === 'timeout') {
                    mensaje("error","Error en Conexión de red","Time out error.");
                    $(obj).val(0);
                } else if (textStatus === 'abort') {
                    mensaje("error","Error en Conexión de red","Ajax request aborted.");
                    $(obj).val(0);
                } else {
                    mensaje("error","Error en Conexión de red",'Uncaught Error: ' + jqXHR.responseText);
                    $(obj).val(0);
                }

            }              
        }) 

}


$(document).on("click","#lbl_adjuntos ",function(){
    $("#frm_descarga_archivo").submit();
})

$(document).on("click",".btn_link_descarga",function(){
   $("#tar_adjuntos").val($(this).attr('data'));
   $("#frm_descarga_archivo").submit();
})

$(document).on("click",".btn_descarga_file_modal",function(){
   $("#tar_adjuntos").val( $("#aux_text_tru_doc_adjunto").val() );
   $("#frm_descarga_archivo").submit();
})

function add_events(c){

            var token=$("input[name=_token]").val();
            var url=window.location;
            var t_calif=0;

         $.ajax({
            url:url+'/load_tareas', //AulaVirtualController@load_tareas
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {tar_id:0},
            beforeSend:function(){
              Swal.showLoading();
            },
            success:function(dt){
            var x=0;
                $(dt).each(function(){
                  var jr=dt[x]['tar_cursos'].split('-');
                  var clr='#1d8bfa';
                  if(jr[0]=='NO'){
                      clr='#000 ';
                  }
                  if(jr[0]=='SM'){
                      clr='#778899';
                  }

                  if(dt[x]['new_tar']>0){
                      clr='#CFAF01';
                      t_calif+=(dt[x]['new_tar']*1);
                  }
                  var tipo="";
                  var brd_clr="";
                  switch(dt[x]['tar_tipo']){
                    case 1:  tipo="Tarea";  break;
                    case 2:  tipo="Evaluacion";  break;
                    case 3:  tipo="Trabajo/Opcional";  break;
                    case 4:  tipo="Proyecto Integrador"; brd_clr='brown';  break;
                  }

                  //var mostrar="(👀)";
                  //var mostrar="😳";
                  var mostrar="-";
                  if(dt[x]['tar_mostrar']==0){
                       mostrar="❌";
                  }

                          c.addEvent({
                          groupId: dt[x]['tar_id'],  
                          title: mostrar+'/'+dt[x]['tar_cursos']+' / '+tipo+' / '+dt[x]['tar_codigo']+' / '+ dt[x]['mtr_descripcion']+' / '+dt[x]['tar_titulo'],
                          start: dt[x]['tar_finicio']+'T'+dt[x]['tar_hinicio'],
                          end: dt[x]['tar_ffin']+'T'+dt[x]['tar_hfin'],
                          color:clr,
                          borderColor:brd_clr
                      })
                          x++;
                    });
                $("#t_calificar").html("<i class='badge' style='background:brown'>"+t_calif+"</i> Tareas por Calificar");
                Swal.hideLoading();

            }
        }); 
}

$(document).on("click","#btn_eliminar_tarea",function(){
    $("input[name=aux_tar_id]").val($("input[name=tar_id]").val());
    if(confirm('Seguro de eliminar esta tarea?')){
        $("#frm_tareas").submit();
    }
})

$(document).on("change",".tru_estado",function(){
    var est=$(this).val();
    var obj=$(this).parent().parent();
    //$(obj).find(".btn_calificar").hide();
    $(obj).find(".tru_nota").val(null);
    $(obj).find(".tru_nota").attr("disabled",true);

    $("#btn_aceptar_modal2").attr('data',null);
    if(est==''){
        $(obj).find(".tru_nota").attr("disabled",true);
    }
    if(est==3){
        $(obj).find(".tru_nota").attr("disabled",true);
        var tru_id=$(this).attr('data');
        var truobs=$(this).attr('truobs');
        var truadj=$(this).attr('truadj');
        $("#btn_aceptar_modal2").attr('data',tru_id);
        $("#aux_tru_observacion").val(truobs);
        $("#aux_text_tru_doc_adjunto").val(truadj);
        $("#aux_tru_doc_adjunto").val(null);
        $("#exampleModal").modal("show");
    }
    if(est==5){
      $(obj).find(".btn_calificar").show();
        $(obj).find(".tru_nota").attr("disabled",false);

    }


});

$(document).on("click",".btn_calificar",function(){

            var token=$("input[name=_token]").val();
            var url=window.location;
            var obj=$(this).parent().parent();

            var trc=$('#tar_codigo').val();
            var est=$(obj).find(".tru_estado").val();
            var tru=$(this).attr('data');
            var obs=$("#aux_tru_observacion").val();
            var adj=$("#aux_tru_doc_adjunto");

            // var nota=null;
            // if(est==5){
          var nota=$(obj).find(".tru_nota").val();
            // }

         var frmData = new FormData;

         frmData.append("adj",$(adj)[0].files[0]);
         frmData.append("est",est);
         frmData.append("tru",tru);
         frmData.append("obs",obs);
         frmData.append("nota",nota);
         frmData.append("trc",trc);

         $.ajax({
            url:url+'/calificar_tarea',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: frmData,
            processData: false,
            contentType: false,
            cache: false,            
            beforeSend:function(){

              if(est!=""){

                if(est==5){
                  if(!(nota>0 && nota<=10 )){
                    alert("Nota incorrecta");
                    return false;
                  }
                }

              }else{

                Swal.fire(
                  'Elija una acción',
                  'Debe seleccionar una opción',
                  'error'
                  )
                return false;
              }

            },
            success:function(dt){

              if(dt==0){
                alert('error');
              }else{
                var obj_est=$(".tru_estado[data="+dt[0]['tru_id']+"]");
                $(obj_est).parent().parent().find(".lbl_estado").removeClass('text-scondary');
                $(obj_est).parent().parent().find(".lbl_estado").removeClass('label label-warning');
                $(obj_est).parent().parent().find(".lbl_estado").removeClass('label label-danger');
                $(obj_est).parent().parent().find(".lbl_estado").removeClass('label label-info');
                $(obj_est).parent().parent().find(".lbl_estado").removeClass('label label-success');

                if(dt[0]['tru_estado']==3){
                  aux_tru_estado="ENV-CORREGIR";
                  $(obj_est).parent().parent().find(".lbl_estado").addClass('label label-danger');
                }
                if(dt[0]['tru_estado']==5){
                  aux_tru_estado="CALIFICADO";
                  $(obj_est).parent().parent().find(".lbl_estado").addClass('label label-success');
                }



                $(obj_est).parent().parent().find(".lbl_estado").text(aux_tru_estado);

                $(obj_est).attr('truobs',dt[0]['tru_observacion']);
                $(obj_est).attr('truadj',dt[0]['tru_doc_adjunto']);
                Swal.fire(
                  'Proceso Correcto',
                  'Se registró correctamente',
                  'success'
                  )
              }


            }
        }); 

})

$(document).on("change","select[name=jor_id],select[name=esp_id],select[name=cur_id]",function(){
  carga_materias($("select[name=jor_id]").val(),$("select[name=esp_id]").val(),$("select[name=cur_id]").val(),0);
})

function carga_materias(j,e,c,m){
  var token=$("input[name=_token]").val();
  var url=window.location;
  var jor=j;
  var esp=e;
  var cur=c;
  var mt=m;


         $.ajax({
            url:url+'/load_modulo_materia',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {jor:jor,esp:esp,cur:cur,mt:mt},
            beforeSend:function(){

            },
            success:function(dt){
              $("select[name=mtr_id]").html(dt);

            }
        }); 
}

$(document).on("submit","#frm_guardar",function(e){

  if( $("input[name=tar_titulo]").val().length==0 ){
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Título es obligatorio'
    })
    $("input[name=tar_titulo]").select();
    e.preventDefault();
  }
  if( $("textarea[name=tar_descripcion]").val().length==0 ){
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Descripción es obligatorio'
    })
    $("textarea[name=tar_descripcion]").select();
    e.preventDefault();
  }

})


$(document).on("click","#btn_cerrar_modal2",function(){

  $("#exampleModal").modal("hide");

})

$(document).on("click","#btn_aceptar_modal2",function(){

   var tru_id=$(this).attr('data');
     $("#exampleModal").modal("hide");
   var obj_btn=$(".btn_calificar[data="+tru_id+"]");
     $(obj_btn).click();

})


$(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });
  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
  });

$(document).on("input",".tru_nota",function(){
  $(this).val($(this).val().replace(/[^0-9.]/,'')); 
})


</script>
<style>


  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

  .label{
    font-weight:border; 
  }
  th,td{
    padding:0px 0px 0px 7px; 
   }

  .modal_dialog{
    width: 80%;
    height: 100%;
    margin: 0;
    padding: 0;
    margin-left:10%;
  }

  .modal_dialog,.modal-body{
    height:100%;
    overflow-y:auto;  
  }

.fc-list-item-title > a{
color:#025A93 !important;    
cursor: pointer !important;
}

#tbl_datos tr:hover{
background:#C7E8FA; 
}

.cls_download:hover{
  background:#73D1F8; 
}
</style>

  <div id='calendar'></div>
               </div>
           </div>
       </div>
   </div>

<form action="aulaVirtuals.destroy" method="POST" id="frm_tareas" >
    {{ csrf_field() }}
    {!! Form::hidden('aux_tar_id',null,['class' => 'form-control']) !!}
</form>
<!-- Modal -->
<div class="modal fade modal-fullscreen" id="modal_tareas"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal_dialog" role="document">
    <div class="modal-content" style="background:#fff !important">
      <div class="modal-header">
        <h5 class="modal-title bg-primary text-center" id="exampleModalLabel">
          Tarea/Cuestionario/Evaluación
          <i class='btn btn-danger fa fa-trash pull-left btn-xs' id="btn_eliminar_tarea"  title='Eliminar Tarea' data-toggle="tooltip" data-placement="button" ></i> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h5>
      </div>
      <div class="modal-body" >

        <form action="descargar_archivo_aula" method="POST" id="frm_descarga_archivo"  >
            {{csrf_field()}}
            <input type="hidden" name="txt_tar_adjuntos" id="tar_adjuntos">
        </form>

        {!! Form::open(['route' => 'aulaVirtuals.store','enctype'=>'multipart/form-data','id'=>'frm_guardar' ]) !!}
        <div class="form-group col-sm-12">
          <div class="input-group">
            <label for="jor_id" class='input-group-addon'></label>
            {!! Form::select('jor_id',$jor,null, ['class' => 'form-control input-group-addon']) !!}
            {!! Form::hidden('tar_id',0,['class' => 'form-control ']) !!}
            <label for="esp_id" class='input-group-addon'></label>
            {!! Form::select('esp_id',$esp,null, ['class' => 'form-control input-group-addon']) !!}
            <label for="cur_id" class='input-group-addon'></label>
            {!! Form::select('cur_id',$cur,null, ['class' => 'form-control ']) !!}
            <label for="paralelo" class='input-group-addon'></label>
            {!! Form::select('paralelo',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G','H'=>'H',],null, ['class' => 'form-control']) !!}
            <label for="mtr_id" class='input-group-addon'></label>
            {!! Form::select('mtr_id',$mtr,null, ['class' => 'form-control']) !!}
          </div>
        </div>  

      <div class='row'>
          <hr size="20">
      </div>

      <div class="form-group col-sm-12">
          <div class="input-group">
            {!! Form::label('tar_tipo', 'Tipo de Actividad:',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_tipo',['0'=>'Tarea','1'=>'Evaluacion','2'=>'Aporte Adicional','3'=>'Tarea/Opcional','4'=>'Proyecto Integrador'],null, ['class' => 'form-control']) !!}
            {!! Form::label('tar_codigo', 'Codigo:',['class'=>'input-group-addon']) !!}
            {!! Form::text('tar_codigo',null, ['class' => 'form-control','readOnly']) !!}
          </div>
        </div>

          <div class="col-md-8" style="margin-top:-10px">
            <div class="input-group">
            {!! Form::label('tar_titulo', 'Titulo de la Actividad:',['class'=>'input-group-addon']) !!}
            {!! Form::text('tar_titulo',null, ['class' => 'form-control','placeholder'=>'Título de la tarea']) !!}
          </div>
          </div>

          <div class="col-md-4" style="margin-top:-10px">
            <div class="input-group">
            {!! Form::label('tar_mostrar', 'Visible:',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_mostrar',['1'=>'SI','0'=>'NO'],null,['class' => 'form-control']) !!}
          </div>
          </div>

        <div class="col-md-12">
          {!! Form::textarea('tar_descripcion',null, ['class' => 'form-control','rows'=>'2']) !!}
        </div>

        <div class="form-group col-sm-6">
          <div class="input-group">
            {!! Form::label('tar_finicio', 'Inicia:',['class'=>'input-group-addon']) !!}
            {!! Form::date('tar_finicio',null, ['class' => 'form-control','id'=>'tar_finicio','readOnly']) !!}
            {!! Form::label('tar_hinicio', 'Hora:',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_hinicio',[
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12',
            '13'=>'13',
            '14'=>'14',
            '15'=>'15',
            '16'=>'16',
            '17'=>'17',
            '18'=>'18',
            '19'=>'19',
            '20'=>'20',
            '21'=>'21',
            '22'=>'22',
            '23'=>'23',
            ],null, ['class' => 'form-control ']) !!}
            {!! Form::hidden('tar_minini','00',['class' => 'form-control ']) !!}
          </div>
        </div>
        <div class="form-group col-sm-6">
          <div class="input-group">
            {!! Form::label('tar_ffin', 'Finaliza:',['class'=>'input-group-addon']) !!}
            {!! Form::date('tar_ffin',null, ['class' => 'form-control ','id'=>'tar_ffin']) !!}
            {!! Form::label('tar_hfin', 'Hora:',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_hfin',[
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12',
            '13'=>'13',
            '14'=>'14',
            '15'=>'15',
            '16'=>'16',
            '17'=>'17',
            '18'=>'18',
            '19'=>'19',
            '20'=>'20',
            '21'=>'21',
            '22'=>'22',
            '23'=>'23',
            ],null, ['class' => 'form-control ']) !!}
            {!! Form::hidden('tar_minfin','00',['class' => 'form-control ']) !!}
          </div>
        </div>

        <div class="col-md-4">

          <div class="input-group">
            <label class="input-group-btn">
              <span class="btn btn-default" style="height:34px;">
                Adjuntar: <input type="file" name="tar_adjuntos" style="display:none;" multiple>
              </span>
            </label>
            <input type="text" class="form-control" name="aux_tar_adjuntos"  readonly style="width:90%">
          </div>

        </div>
        <div class="col-md-4" id="lbl_adjuntos" >
            
        </div>
        <div class="col-md-4">
          {!! Form::text('tar_link',null, ['class' => 'form-control','placeholder'=>'Link de Video']) !!}
        </div>
        <div class="col-md-4" hidden >
          {!! Form::select('tar_estado',['0'=>'Activo','1'=>'InActivo',],null, ['class' => 'form-control']) !!}
        </div>
        <div class='col-md-12'>
          <hr>
        </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary pull-left" data-toggle="tooltip" data-placement="top" title="Puede enviar la tareas a estudiantes que no la han recibido guardandole nuevamente">
          <i class="fa fa-floppy-o"></i> Guardar / <i class="fa fa-refresh"></i> Actualizar
        </button>

      {!! Form::close() !!}
      <form action="cumplimiento_tareas" method="POST" id='frm_rep_cumplimineto'>
        {{csrf_field()}}
        <input type="hidden" id="cumpl_tar_id" name="cumpl_tar_id">
        <i class='btn btn-success fa fa-file-excel-o btn_cumplimiento'>Cumplimiento de Tareas</i>
      </form>  

    </div>



<div class='row' id="dvi_estudiantes">
    
</div>

</div>



  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-top:20% ">
    <div class="modal-content cnt_modal2 container-fluid">
        <label for="">Respuesta:</label>
        <textarea id="aux_tru_observacion"  cols="30" rows="3" class='form-control' ></textarea>
        <div class="input-group" style="margin-top:10px ">
          <label class="input-group-btn">
            <span class="btn btn-default" style="margin-top:-5px ">
              Adjuntar: <input type="file" id="aux_tru_doc_adjunto" style="display:none ;" multiple>
            </span>
          </label>
          <input type="text" class="form-control" id="aux_text_tru_doc_adjunto" readonly style="width:100%">
          <label class="input-group-btn"></label>

          <span class='btn btn-default btn_descarga_file_modal' style="margin-top:-30px" >Descargar</span>

        </div>
        <button type="button" id="btn_aceptar_modal2" class="btn btn-primary">Guardar</button>
        <button type="button" id="btn_cerrar_modal2" class="btn btn-danger pull-right">Cerrar</button>
    </div>
  </div>
</div>

<script>
  $(document).on("click",".btn_transferir_notas",function(){

    var cur=$("select[name=cur_id]").val();
    if(cur==6){

                Swal.fire(
                  "No puede trasferir notas a 3ero de Bachillerato módulo bloqueado",
                  'Solicite informacion a su coordinador',
                  'error'
                  )

    }else{

              $("#parcial").val('0');
              $("#insumo").val('0');
              var url=window.location;
              var trid=$("input[name=tar_id]").val();
              var token=$("input[name=_token]").val();
              var bl=$('select[name="mtr_id"] option:selected').text().split('->')[1];
              var x=0;
              var option_parciales="<option value='0' >Seleccione Parcial</option>";
              if(bl==undefined){
                bl=6;
              }

              while(x<bl){
                x++;
                option_parciales+="<option value='"+x+"' >Parcial "+x+"</option>";
              }

                  $.ajax({
                    url:url+'/load_parciales_modulo',
                    headers:{'X-CSRF-TOKEN':token},
                    type: 'POST',
                    dataType: 'json',
                    data: {trid:trid},
                        beforeSend:function(){
                                  
                         },
                        success:function(dt){
                          $(".mdl_materia").text(dt['mtr_descripcion']);

                         }
                    }) 

              $("#modal_transferir_notas").modal("show");
              $("#parcial").html(option_parciales);

    }



  })


  function transferir_notas(trid,par,ins,blq,audt){


    var token=$("input[name=_token]").val();
    var url=window.location;
    $.ajax({
      url:url+'/transferir_notas',
      headers:{'X-CSRF-TOKEN':token},
      type: 'POST',
      dataType: 'json',
      data: {trid:trid,par:par,ins:ins,blq:blq,audt:audt},
          beforeSend:function(){
           },
          success:function(dt){

                Swal.fire(
                  dt,
                  'Datos transferidos',
                  'info'
                  )

           }
      }) 


  }

  $(document).on("click","#btn_trans_notas_guardar",function(){

        var trid=$("input[name=tar_id]").val();
        var par=$("#parcial").val();
        var ins=$("#insumo").val();
        var cod=$("#tar_codigo").val();
        var aux_ins=ins;
        if(ins==8){
            aux_ins=5;
        }

        var bl=$('select[name="mtr_id"] option:selected').text().split('->')[1];

        if(par!=0){
          if(ins!=0){
            
            $("#modal_transferir_notas").modal("hide");

            var audt='Tarea: '+cod+' Parcial '+par+' Insumo '+aux_ins+'  '+$(".mdl_materia").text();

            Swal.fire({
              title: '<div class="text-left">Parcial: '+par+'<br> Insumo: '+aux_ins+' <br> '+$(".mdl_materia").text()+'</div> <br> Datos Correctos? ',
              text: "Los datos se pasarán al modulo de notas",
              icon: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, Transferir',
              cancelButtonText: 'Cancelar'
            }).then( (result) => {
              if (result.value) {
                if(bl==undefined){
                  bl=6;
                }
                transferir_notas(trid,par,ins,bl,audt);
              }
            });
          }else{
                Swal.fire(
                  'Insumo Incorrecto',
                  'Debe elegir un Insumo',
                  'error'
                  )          
              }
        }else{

                Swal.fire(
                  'Parcial Incorrecto',
                  'Debe elegir un parcial',
                  'error'
                  )          
        }

  })
  $(document).on("click","#btn_trans_notas_cerrar",function(){
    $("#modal_transferir_notas").modal("hide");
  })

  $(document).on("click",".btn_cumplimiento",function(){
    var trid=$("input[name=tar_id]").val();
    $("#cumpl_tar_id").val(trid);
    $("#frm_rep_cumplimineto").submit();
  })  

  $(document).on("click",".btn_desc_adjuntos_tareas",function(){
    var trid=$("input[name=tar_id]").val();
    $("#desc_tar_id").val(trid);
    $("#frm_descarga_adjuntos").submit();
  })


</script>

<!-- Modal -->
<div class="modal fade" id="modal_transferir_notas"  tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document" style="margin-top:20% ">
    <div class="modal-content cnt_modal_transferir_notas container-fluid">

      <div class="modal-body" style="background:#fff !important">
        <h4>Transferir datos al Módulo/Materia: <strong class='mdl_materia' > </strong></h4>
        
          <div class="input-group">
            <span  class='input-group-addon' style='padding:0px '  ></span>
            <select name="parcial" id="parcial" class='form-control'>
              <option value="0">Seleccione Parcial</option>
            </select>
            <span  class='input-group-addon' style='padding:0px ' ></span>
            <select name="insumo" id="insumo" class='form-control'>
              <option value="0">Seleccione Insumo</option>
              <option value="1">Insumo 1</option>
              <option value="2">Insumo 2</option>
              <option value="3">Insumo 3</option>
              <option value="4">Insumo 4</option>
              <option value="8">Insumo 5</option>
            </select>
          </div>


          <div class="modal-footer">

            <button type="button" id="btn_trans_notas_guardar" class="btn btn-primary pull-left  fa fa-random ">  Transferir </button>
            <button type="button" id="btn_trans_notas_cerrar" class="btn btn-danger pull-right">Salir</button>

          </div>


      </div>

    </div>
  </div>
</div>


@endsection