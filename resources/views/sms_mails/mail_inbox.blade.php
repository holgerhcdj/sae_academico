@extends('layouts.app')
@section('content')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
  $(function(){
    $('#cont_mail_inbox').show();
    $('#cont_mail_new').hide();
    $('#cont_mail_sent').hide();
    $('#cont_mail_read').hide();
    CKEDITOR.config.height=300;
    CKEDITOR.config.width='auto';
    CKEDITOR.replace('compose-textarea');    

 var n_noread=$(".fa-envelope").length;
 $("#ninbox_noread").text(n_noread);


  })
  $(document).on('click','#btn_redactar',function(argument) {
    $('#cont_mail_inbox').hide();
    $('#cont_mail_new').show();
    $('#cont_mail_read').hide();
    $('#cont_mail_sent').hide();
  })
  $(document).on('click','.link_mail',function(argument) {
    $('#cont_mail_inbox').hide();
    $('#cont_mail_new').hide();
    $('#cont_mail_sent').hide();
    $('#cont_mail_read').show();
  })

  $(document).on('click','#lnk_sent',function(argument) {

    $("#lnk_inbox").removeClass('active');
    $("#lnk_sent").addClass('active');

  })




$(document).on("click","#btn_buscar_estudiantes",function(){

   var url=window.location;
   var token=$("input[name=_token]").val();
   var jor=$("select[name=jor_id]").val();
   var esp=$("select[name=esp_id]").val();
   var cur=$("select[name=cur_id]").val();
   var par=$("select[name=paralelo]").val();

  $.ajax({
    url: url+'/cargar_estudiantes',
    headers:{'X-CSRF-TOKEN':token},
    type: 'POST',
    dataType: 'json',
    data: {jor_id:jor,esp_id:esp,cur_id:cur,par_id:par},
    beforeSend:function(){

    },
    success:function(dt){
      
      $("#tbl_datos").html(dt);
      $(".chk_est").prop("checked",false);

    }
  })

})

$(document).on("click",".btn_check",function(){

  if($(this).text()=="Seleccionar Todo"){
    $(".chk_est").prop("checked",true);
    $(this).text("Deseleccionar Todo");
  }else{
    $(".chk_est").prop("checked",false);
    $(this).text("Seleccionar Todo");
  }
})

$(document).on("click",".btn_add_estudiantes",function(){
  var x=0;
  var rst="";
  $(".chk_est").each(function(){
    if($(this).prop("checked")){
      rst+="<span class='bg-default cls_est' style='border:solid 1px #ccc; border-radius:5px' data='"+$(this).attr('est_id')+"' >"+$(this).attr('data')+" <i class='btn text-danger btn-xs fa fa-close btn_close_est'></i> </span>";
    }
  });
  $("#para").html(rst);
})

$(document).on("click",".btn_close_est",function(){
  if(confirm("Quitar estudiante?")){
    $(this).parent().remove();
  }
})

$(document).on("click","#envia_notificaciones",function(){

 var url=window.location;
 var token=$("input[name=_token]").val();
 /////////*****IMAGEN****//////////
 var inputFileImage = document.getElementById("com_adjuntos");
 var file = inputFileImage.files[0];
 var data = new FormData();
 data.append("archivo",file);
 ////////***************/////////////
 var curso=$("select[name=jor_id] option:selected").text()+"/"+$("select[name=esp_id] option:selected").text()+"/"+$("select[name=cur_id] option:selected").text()+"/"+$("select[name=paralelo] option:selected").text(); 
 var est=[];
 var ast=$("#asunto").val();
 var ms=CKEDITOR.instances['compose-textarea'].getData();
 $(".cls_est").each(function(){
   est.push($(this).attr('data'));
 });
 data.append("est",est);
 data.append("ast",ast);
 data.append("ms",ms);
 data.append("cur",curso);

      $("#message").empty(); 
      $('#loading').show();
      $.ajax({
          url: url+'/enviar_notificaciones',//SmsMailController@enviar_notificaciones  // URL a la que se envía la solicitud
      headers:{'X-CSRF-TOKEN':token},   
      dataType: 'json', 
      type: "POST",             // Tipo de solicitud que se enviará, llamado como método 
      data:  data,    // Datos enviados al servidor 
      contentType: false,           // El tipo de contenido utilizado al enviar datos al servidor. El valor predeterminado es: "application / x-www-form-urlencoded"
          cache: false,         // Para no poder solicitar que las páginas se almacenen en caché
      processData:false,        // Para enviar DOMDocument o archivo de datos no procesados, se establece en falso (es decir, los datos no deben estar en forma de cadena)
      beforeSend:function(){

        if(est.length==0){
          mensaje("error","Elija un Destinatario ");
          return false;
        }

        if(ast.length==0){
          mensaje("error","Asunto es obligatorio ");
          return false;
          $("#asunto").select();
        }

        if(ms.length==0){
          mensaje("error","Mensaje es obligatorio ");
          return false;
        }

        
      },
      success: function(dt)     // Una función a ser llamada si la solicitud tiene éxito
      {

      if(dt==0){
         mensaje("success","Enviado Correctamente","Envío Correcto ");
         window.history.go(0);
      }else{
         mensaje("error","Error al enviar "+dt);

      }

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

    });

})


function mensaje(ico,tit,txt){
    Swal.fire(tit,txt,ico)
}

$(document).on("click","#lnk_sent",function(){

    $('#cont_mail_inbox').hide();
    $('#cont_mail_new').hide();
    $('#cont_mail_sent').show();
    $('#cont_mail_read').hide();  
    return false;

})

$(document).on("click",".cls_comunicado",function(){
      var url=window.location;
      var token=$("input[name=_token]").val();
      var com_id=$(this).attr('data');

         $.ajax({
          url: url+'/load_datos_comunicado',//SmsMailController@load_datos_comunicado
          headers:{'X-CSRF-TOKEN':token},
          type: 'POST',
          dataType: 'json',
          data: {com_id:com_id},
          beforeSend:function(){


          },
          success:function(dt){
            $("#per_id").html('<strong>Asunto:</strong> '+dt[0]['com_asunto']+"("+dt[0]['com_fecha']+")<br><br> <strong> DE:</strong>"+dt[0]['com_curso']+ " <br><br>"+dt['estudiantes']);
            $("#com_mensaje").html(dt[0]['com_mensaje']);
            if(dt[0]['com_adjuntos'].length>0){
              var adj='<a href="comunicaciones/tareas/descargar_archivo/'+dt[0]['com_adjuntos']+'   "  class="btn btn-success ">Descargar</a>';
              $("#cont_adjutos").html(dt[0]['com_adjuntos']+adj);
            }
            
            $("#btn_elimina_comunicado").attr('data',dt[0]['com_id']);
          }  

      })
})

$(document).on("click","#btn_elimina_comunicado",function(){

      var url=window.location;
      var token=$("input[name=_token]").val();
      var com_id=$(this).attr('data');

         $.ajax({
          url: url+'/elimina_comunicado',//SmsMailController@elimina_comunicado
          headers:{'X-CSRF-TOKEN':token},
          type: 'POST',
          dataType: 'json',
          data: {com_id:com_id},
          beforeSend:function(){
            if(!confirm("Eliminar este comunicado?")){
              return false;
            }

          },
          success:function(dt){

            if(dt==0){
              window.history.go(0);
            }else{
               mensaje("error","Intene de nuevo porfavor");
            }
          }  

      })
})

$(document).on("click","#btn_busca_comunicaciones",function(){
  $("#frm_busca_comunicaciones").submit();
})


</script>
<style>
  .link_mail{
    cursor:pointer; 
  }
  #per_id{
    font-size:13px; 
  }
</style>


<!-- Modal enviar-->
<div class="modal fade" id="modal_cursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CURSOS / ESTUDIANTES </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <div class="col-md-3">
          {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-3">
          {!! Form::select('esp_id',$esp,null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-3">
          {!! Form::select('cur_id',$cur,null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-2">
          {!! Form::select('paralelo',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G','H'=>'H',],null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-1">
          <i class="fa fa-search btn btn-primary" id="btn_buscar_estudiantes" ></i>
        </div>


        <table class="table" >
          <thead>

          <tr>
              <td>#</td>            
              <td>Estudiante</td>            
              <td class="text-right"> 
                   <i class="btn btn-default fa fa-check btn_check">Seleccionar Todo</i> 
              </td>            
          </tr>

          </thead>
          <tbody id="tbl_datos">
            
          </tbody>

                <tr>
                  <th colspan="3">
                    <i class="btn btn-success btn_add_estudiantes " data-dismiss="modal" >Agregar Seleccionados</i>
                    <i class="btn btn-danger pull-right" data-dismiss="modal"  >Salir</i>
                  </th>
                </tr>

        </table>

      </div>
    </div>
  </div>
</div>

    <section class="content-header">
      <h1>
        Comunicaciones
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <span class="btn btn-primary btn-block margin-bottom" id="btn_redactar">Redactar</span>
          @include('sms_mails.mail_menu')
        </div>

<!-- MAIL NEW -->
        <div class="col-md-9" id="cont_mail_new">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Nueva Comunicación</h3>
                  <i class="btn btn-success fa fa-plus-square" id="btn_add_grupo" data-toggle="modal" data-target="#modal_cursos" >Agregar Curso o Estudiante</i>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group" name="para" id="para">
                
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Asunto:" name="asunto" id="asunto">
              </div>
              <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" style="height: 300px">
                    </textarea>
              </div>
              <div class="form-group">
                <div class="btn btn-default btn-file">
                  <i class="fa fa-paperclip"></i> Adjunto
                  <form  id="frm_adjuntos" method="POST" enctype="multipart/form-data" >
                    <input type="file" name="com_adjuntos" id="com_adjuntos">
                  </form>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-left">
                <button type="submit" class="btn btn-primary"  id="envia_notificaciones"  ><i class="fa fa-envelope-o"></i> Enviar</button>
              </div>
              <button type="reset" class="btn btn-danger pull-right"><i class="fa fa-times"></i> Salir</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
<!-- END MAIL NEW -->


<!-- MAIL INBOX -->

            <h3 style="margin-top:-20px " >Bandeja de Entrada</h3>
        <div class="col-md-9" id="cont_mail_inbox">
          <div class="box box-primary">

            <form action="comunicaciones" method="POST" id="frm_busca_comunicaciones">
              {{csrf_field()}}
                <div class="row" style="width:100% ">
                  <div class="form-group col-sm-9">
                    <div class="input-group">
                      {!! Form::label('desde', 'Desde:',['class'=>'input-group-addon']) !!}
                      {!! Form::date('desde',$d,['class' => 'form-control']) !!}
                      {!! Form::label('hasta', 'Hasta:',['class'=>'input-group-addon']) !!}
                      {!! Form::date('hasta',$h,['class' => 'form-control']) !!}
                      {!! Form::label('estudiante', 'Estudiante:',['class'=>'input-group-addon']) !!}
                      {!! Form::text('estudiante',null,['class' => 'form-control','style'=>'width:250px']) !!}
                      <input type="hidden" name="op" value="0">
                      <i class='input-group-addon btn btn-primary' id="btn_busca_comunicaciones">Buscar</i>

                    </div>
                  </div>
                </div>
              </form>

            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    @foreach($com_inbox as $ci)
                  <tr>
                    <td class="mailbox-star">
                      @if($ci->cmu_estado==0)
                        <i class='fa fa-envelope'></i>
                      @else
                        <i class='fa fa-envelope-o'></i>
                      @endif
                    </td>
                    <td class="mailbox-name cls_comunicado" data='{{$ci->com_id}}'><span class="text-info link_mail">{{$ci->est_apellidos.' '.$ci->est_nombres}}</span></td>

                    <td class="mailbox-subject"><b>{{$ci->com_asunto}}</b>
                      {{substr($ci->com_mensaje,0,100)}}
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date">{{$ci->com_fecha.' '.substr($ci->com_hora,0,5)}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>

                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <!-- PIE DE BANDEJA -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
<!-- END MAIL INBOX -->


<!-- MAIL SENDING -->
        <div class="col-md-9" id="cont_mail_sent">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Bandeja de salida</h3>
              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    <?php $x=1;?>
                    @foreach($com_sent as $cs)
                    <tr>
                      <td class="mailbox-star">{{$x++}}</td>
                      <td class="mailbox-name cls_comunicado" data='{{$cs->com_id}}'><span class="text-info link_mail">{{$cs->com_curso}}</span></td>
                      <td class="mailbox-subject"><b>{{$cs->com_asunto}}</b>{{ strip_tags(substr($cs->com_mensaje,0,20)) }}... </td>
                      @if($cs->com_adjuntos!='')
                      <td class="mailbox-attachment"><i class="fa fa-paperclip" aria-hidden="true"></i> {{$cs->com_adjuntos}} </td>
                      @else
                      <td class="mailbox-attachment">...</td>
                      @endif
                      <td class="mailbox-date">{{$cs->com_fecha.' '.$cs->com_hora}}</td>
                    </tr>
                    @endforeach
                   </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <!-- PIE DE BANDEJA -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
<!-- END MAIL SENDING -->

<!-- MAIL READ -->
        <div class="col-md-9" id="cont_mail_read">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="per_id" ></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3 id="com_asunto"></h3>
                <h5>
                  <span class="mailbox-read-time pull-right" id="com_fecha" > </span>
                </h5>
              </div>
              <div class="mailbox-read-message" id="com_mensaje">


              </div>
              <div id="cont_adjutos" class="alert alert-info">

              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <!-- <button type="button" id="btn_elimina_comunicado"  class="btn btn-default"><i class="fa fa-trash-o text-danger"></i> Eliminar</button> -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
<!-- END MAIL READ -->


      </div>
</section>
@endsection