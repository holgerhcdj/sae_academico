@extends('layouts.app')
@section('content')
<?php
//date_default_timezone_set('America/Guayaquil');
$today=date('Y-m-d H:i');

?>
    <section class="content-header">
        <h1>
            Tareas y Actividades 
        </h1>
        @if(Auth::user()->id==22 || Auth::user()->id==93 || Auth::user()->id==54 || Auth::user()->id==1)
            <form action="descargar_tareas_enviadas" method="POST">
              {{csrf_field()}}
              <button class='btn btn-success fa fa-file-excel-o'>Reporte de Coordinadores</button>
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
      // plugins: [ 'interaction', 'dayGrid','list' ],
      // locale:'es',
      // header: {
      //   left: 'prev,next today',
      //   center: 'title',
      //   right: 'timeGridWeek,timeGridDay,listWeek'
      // },

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
      // weekNumbers: true,
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
                $("#aux_tru_adjunto").val('');

                $("select[name=tar_hinicio]").val('07');
                $("#tar_ffin").val(f);
                $("select[name=tar_hfin]").val('23');
                $("select[name=tar_estado]").val(0);
                $("select[name=jor_id]").val(1);
                $("select[name=esp_id]").val(10);
                $("select[name=cur_id]").val(1);
                $("select[name=paralelo]").val('A');
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
            url:url+'/load_una_tarea',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {tar_id:tar_id},
            beforeSend:function(){
                Swal.showLoading("Cargando");
            },
            success:function(dt){

                $("input[name=tar_id]").val(dt[0]['tar_id']);
                $("input[name=tar_tipo]").val(dt[0]['tar_tipo']);
                $("input[name=tar_titulo]").val(dt[0]['tar_titulo']);
                $("textarea[name=tar_descripcion]").val(dt[0]['tar_descripcion']);
                $("#tar_adjuntos").val(dt[0]['tar_adjuntos']);


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


$(document).on("click","#lbl_adjuntos",function(){
    $("#frm_descarga_archivo").submit();
})
$(document).on("click",".btn_link_descarga",function(){
   $("#tar_adjuntos").val($(this).attr('data'));
   $("#frm_descarga_archivo").submit();
})

function add_events(c){

            var token=$("input[name=_token]").val();
            var url=window.location;
         $.ajax({
            url:url+'/load_tareas',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {tar_id:0},
            beforeSend:function(){

            },
            success:function(dt){
            var x=0;
                $(dt).each(function(){
                          c.addEvent({
                          groupId: dt[x]['tar_id'],  
                          title: dt[x]['tar_cursos']+' / '+dt[x]['tar_codigo']+' / '+dt[x]['mtr_descripcion']+' / '+dt[x]['tar_titulo'],
                          start: dt[x]['tar_finicio']+'T'+dt[x]['tar_hinicio'],
                          end: dt[x]['tar_ffin']+'T'+dt[x]['tar_hfin'],
                          //color:'#257e4a'
                      })
                          x++;
                    });

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

    if(est==''){
        $(obj).find(".tru_nota").attr("disabled",true);
        $(obj).find(".tru_observacion").attr("readonly",true);
        $(obj).find(".tru_observacion").css("background","#ccc");
    }
    if(est==3){
        $(obj).find(".tru_nota").attr("disabled",true);
        $(obj).find(".tru_observacion").attr("readonly",false);
        $(obj).find(".tru_observacion").css("background","#fff");
    }
    if(est==5){
        $(obj).find(".tru_nota").attr("disabled",false);
        $(obj).find(".tru_observacion").attr("readonly",false);
        $(obj).find(".tru_observacion").css("background","#fff");
    }

})
$(document).on("click",".btn_calificar",function(){
            var token=$("input[name=_token]").val();
            var url=window.location;
            var obj=$(this).parent().parent();
            var est=$(obj).find(".tru_estado").val();
            var tru=$(this).attr('data');
            var obs=$(obj).find(".tru_observacion").val();
            var nota=null;
            if(est==5){
               var nota=$(obj).find(".tru_nota").val();
           }

         $.ajax({
            url:url+'/calificar_tarea',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {obs:obs,nota:nota,tru:tru,est:est},
            beforeSend:function(){
                if(est==5){
                    if(!(nota>0 && nota<=10 )){
                        alert("Nota incorrecta");
                        return false;
                    }
                }
            },
            success:function(dt){
            if(dt==0){
                Swal.fire(
                  'Proceso Correcto',
                  'Se registró correctamente',
                  'success'
                  )
            }else{
                Swal.fire(
                  'Error',
                  'Processo Incorrecto',
                  'danger'
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

$(document).on("click",".btn_tru_observacion",function(){
        $('#popup').fadeIn(40);
        // return false;
})
$(document).on("click","#close",function(){
        $('#popup').fadeOut(20);
        // return false;
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
/*     height: 100%;
 */margin: 0;
    padding: 0;
    margin-left:10%;
  }

.fc-list-item-title > a{
color:#025A93 !important;    
cursor: pointer !important;
}

#tbl_datos tr:hover{
background:#C7E8FA; 
}


/*fadein-popup*/
#popup {
    left: 0;
    position: absolute;
    top: 200px;
    width: 100%;
    z-index: 10000;
}

.content-popup {
    margin:0px auto;
    margin-top:120px;
    position:relative;
    padding:10px;
    width:500px;
    min-height:250px;
    border-radius:4px;
    background-color:#FFFFFF;
    box-shadow: 0 2px 5px #666666;
}
.close {
    position: absolute;
    right: 15px;
}

</style>

  <div id='calendar'></div>
               </div>
           </div>
       </div>
   </div>

    <div id="popup" style="display: none;">
        <div class="content-popup">
            <div class="close"><a href="#" id="close"><img src="images/close.png"/></a></div>
            <div>

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
    <div class="modal-content" style="background:#fff !important ">
      <div class="modal-header">
        <h5 class="modal-title bg-primary text-center" id="exampleModalLabel">
          Tarea/Cuestionario/Evaluación
          <i class='btn btn-danger fa fa-trash pull-left btn-xs' id="btn_eliminar_tarea"  title='Eliminar Tarea'></i> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h5>
      </div>
      <div class="modal-body ">

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
            {!! Form::select('tar_tipo',['0'=>'Tarea',],null, ['class' => 'form-control']) !!}
            {!! Form::label('tar_codigo', 'Codigo:',['class'=>'input-group-addon']) !!}
            {!! Form::text('tar_codigo',null, ['class' => 'form-control','readOnly']) !!}
          </div>
        </div>
        <div class="col-md-12" style="margin-top:-10px">
          <div class="input-group">
          {!! Form::label('tar_titulo', 'Titulo de la Actividad:',['class'=>'input-group-addon']) !!}
          {!! Form::text('tar_titulo',null, ['class' => 'form-control','placeholder'=>'Título de la tarea']) !!}
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
            <input type="text" class="form-control" name="aux_tru_adjunto"  readonly style="width:90%">
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
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary pull-left']) !!}
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Salir</button>
      </div>
      {!! Form::close() !!}
    

<div class='row' id="dvi_estudiantes">
    
</div>

</div>



  </div>
</div>



@endsection