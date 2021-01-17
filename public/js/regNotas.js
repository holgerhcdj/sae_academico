//REGISTRO DE NOTAS
//CAMBIA LA JORANDA
$(function () {
            $("#jor_id").val('0');
            $("#esp_id").val('10');
});

$(document).on("change","select[name=jor_id]",function(){
	var url = window.location;
	$.ajax({
                    url: url + "/cur/0/"+this.value+"&"+$("#cur_id").val(), //RegNotasController@show
                    type: 'GET', 
                    dataType: 'json',
                    beforeSend: function(){
                    	$("#tbl_notas").html("");
                    },
                    success: function (datos) {

                    	dt="<option value='0'>Seleccione</option>";
                    	$(datos).each(function (){
                    		dt+='<option value='+this['cur_id']+this['paralelo']+' >'+this['cur_descripcion']+' '+this['paralelo']+'</option>';
                    	}); 
                    	$('#cur_id').html(dt);

                    }
                });

})
//CAMBIA EL CURSO
$(document).on("change","select[name=cur_id]",function(){          
            var url = window.location;

                $.ajax({
                    url: url + "/cur/1/"+$("#jor_id").val()+"&"+$(this).val(), //RegNotasController@show
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                        $("#tbl_notas").html("");
                    },
                    success: function (datos) {
                        dt="<option value='0'>Seleccione</option>";
                       $(datos).each(function (){
                           dt+='<option value='+this['mtr_id']+' >'+this['mtr_descripcion']+'</option>';
                       }); 
                       $('#mtr_id').html(dt);
                    }
                });
});
//CAMBIA MATERIA TECNICA
$(document).on("change","select[name=mtr_tec_id]",function(){          

            $("#tbl_notas").html("");
            dt=$('#mtr_tec_id option:selected').text().split('->');
            $("#n_bloques").val(dt[1]);
            var opt="";
            var x=1;
            while(x<=dt[1]){
                opt+="<option value='"+x+"' >Parcial "+x+"</option>";
                x++;
           }
           opt+="<option value='7' >Examen Final</option><option value='100' >Notas Adicionales</option>";
           $("#bloque").html(opt);            


});
//CAMBIA MATERIA
$(document).on("change","select[name=mtr_id]",function(){      

   $("#tbl_notas").html("");
   var url = window.location;
   dat=$("#cur_id").val().split('');
   if($(dat).length==5 && dat[4]=='U'){ //SI ES CURSO BGU
      obtiene_anio_lectivo(1);
   }else{
      obtiene_anio_lectivo(0);
   }
   
   var esp=$("#esp_id").val();

            if($(this).val()==1){ //si es materia tecnica
              $("#mtr_tec").show();
              $("#bloq").show();

              $.ajax({
                    url: url + "/mtr/"+esp+"/"+dat[0],//RegNotasController@mtr_tecnicas
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                        //$("#tbl_notas").html("");
                   },
                   success: function (datos) {

                     dt="<option value='0'>Seleccione</option>";
                     $(datos).each(function (){
                        $("#esp_id").val(this['esp_id']);
                        dt+='<option value='+this['id']+' >'+this['mtr_descripcion']+'->'+this['bloques']+'</option>';
                   }); 
                     $('#mtr_tec_id').html(dt);
                }
              });

         }else{

               $("#mtr_tec").hide();
              // $("#bloq").show();
         }

});      

///BUSCAR ESTUDIANTES CON SUS NOTAS CALIFICACIONES
$(document).on("click","#btn_buscar",function(){

            j = $("#jor_id").val();
            c = $("#cur_id").val();
            m = $("#mtr_id").val();
            mt = $("#mtr_tec_id").val();
            b = $("#bloque").val();
            esp=$("#esp_id").val();
            
            if(c.length>2){
                aux_par=c.substring(2,5);
                if(aux_par=='BGU'){
                    esp=7;
                }else if(aux_par=='BSX'){
                    esp=8;
                }
            }
            cp=c.split('');
                var url = window.location;
                $.ajax({//Cargar los datos 
                    url: url + "/"+j+"&"+cp[0]+"&"+cp[1]+"&"+m+"&"+b+"&"+mt+"&"+esp, //RegNotasController@load_datos (Jor,Cur,Par,Mtr,Bloq,Mtrt,Esp)
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {

                      // if(b==7 || b==8 || b==100 ){

                      //   mensaje("info","No Habilitado","El registro de evaluaciones y notas adicionales no está habilitado");
                      //   return false;

                      // }else{

                          if( $("#mtr_id").val()==1 && $("#mtr_tec_id").val()==0 ){
                              alert('Módulo es Obligatorio');
                              return false;
                          }else if( $("#mtr_id").val()==0 ){
                              alert('Materia es Obligatoria');
                              return false;
                          }else if( $("#cur_id").val()==0 ){
                              alert('Curso es Obligatorio');
                              return false;
                          }else{

                              $(".bloqueo").css('visibility', 'visible');
                          }
                          

                      // }

                    },
                    success: function (dt,textStatus, jqXHR) {

                        $("#tbl_notas").html(dt);
                        cambia_tabs();
                        // $(".bloqueo").css('visibility', 'hidden');
                        //  txt_notas();
                        //  promedios();
                    }
                });

 });   

function cambia_tabs(){
  //Funcion para cambiar a TAB vertical/*****/////////////
    $('tr').each(function() {
        $(this).find('td').each(function(i) {
            $(this).find('input').attr('tabindex', i-1);
        });
    });
///////////////*****************///////////////////////

}

///**********GUARDAR DATOS ACCION
$(document).on('blur', '.txt_notas', function () {

  var nt=$(this).val().length;  
  if(nt>0){
    save_notas($(this));
  }
  
})
////NO PERMITE INGRESAR OTROS CARACTERES
$(document).on('input', '.txt_notas,.txt_new_notas', function () {
  this.value = this.value.replace(/[^0-9.]/g,'');
   //$(this).val($(this).val().replace(',', '.'));
})
///MOSTRAR TAREAS DE AULA VIRTUAL
$(document).on('click', '.btn_notas_aula_virtual', function(){
  $("#mdl_notas_aula_virtual").modal("show");
  $("#aux_ins_id").val($(this).attr('ins_id'));
  $("#mdl_titulo > span").text('TAREAS SEMANALES Y NUEVOS APORTES ( '+$(this).text()+' )' );
  load_tareas_cursos();
})
///PROMEDIAR NOTAS DE TAREAS DE AULA VIRTUAL
$(document).on('click', '.chk_act', function(){

    data=$(this).attr('data');
    if($(this).prop("checked")==true){
     $("."+data).addClass("chk_selected"); 
    }else{
     $("."+data).removeClass("chk_selected"); 
    }

$("."+data).each(function(){

    var row=$(this).parent();
    //var text=$(this).text();
    var cols=$(row).find(".chk_selected :input");
    var text=0;
    var x=0;
    $(cols).each(function(){
      x++;
      if( isNaN(parseFloat($(this).val())) ){
        text+=parseFloat(0);
      }else{
        text+=parseFloat($(this).val());
      }

    });
    $(row).find(".txt_prom_tmp").text( (text/x).toFixed(2) );
  })

})

///PROMEDIAR NOTAS DE TAREAS DE AULA VIRTUAL
$(document).on('click', '#btn_asg_notas', function(){

  $(".txt_prom_tmp").each(function(){
    var nt=$(this).text();
    var mat_id=$(this).attr('mat_id');
    var ins_id=$("#aux_ins_id").val();
    Swal.showLoading();
    $(".txt_notas").each(function(){
      if( $(this).attr('mat_id')==mat_id && $(this).attr('ins_id')==ins_id && nt>0 ){
        $(this).val(nt);
        $(this).select();
        //$(this).blur();
      }

    });
    Swal.hideLoading();
    $("#mdl_notas_aula_virtual").modal("hide");

  });

})

///NUEVO APORTE
$(document).on('click', '.btn_nuevo_aporte', function(){
///**********GUARDAR NUEVA AREA
  var ntr='AP-'+(parseInt($('#tbl_tareas').find('th .new_tarea').length)+1);
  var tx_nt=prompt("Título del nuevo aporte");

if(tx_nt.length>5){

          var token=$("input[name=_token]").val();
          var url=window.location;
          var date=new Date();
          var fact=date.getFullYear()+'-'+(parseInt(date.getMonth())+1)+'-'+date.getDate();
        var tar_id=0;
        var jor_id=$("#jor_id").val();
        var esp_id=$("#esp_id").val();
        var mtr_id=$("#mtr_id").val();
        if(esp_id!=10){
          mtr_id=$("#mtr_tec_id").val();
        }
        var aux_cur=$("#cur_id").val().split('');
        var cur_id=aux_cur[0];
        var paralelo=aux_cur[1];
        var tar_tipo=2;//Aporte
        var tar_titulo=tx_nt;
        var tar_descripcion='Nuevo aporte generado '+tx_nt;
        var tar_adjuntos=null;
        var tar_link=null;
        var tar_finicio=fact;
        var tar_hinicio='07:00';
        var tar_ffin=fact;
        var tar_hfin='23:00';
        var tar_estado=0;
        var tar_codigo=0;
        var tar_mostrar=1;
          

            $.ajax({
              url:url+'/aulaVirtuals_store',
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {op:0,
              tar_id:tar_id,
              jor_id:jor_id,
              esp_id:esp_id,
              cur_id:cur_id,
              paralelo:paralelo,
              mtr_id:mtr_id,
              tar_tipo:tar_tipo,
              tar_titulo:tar_titulo,
              tar_descripcion:tar_descripcion,
              tar_adjuntos:tar_adjuntos,
              tar_link:tar_link,
              tar_finicio:tar_finicio,
              tar_hinicio:tar_hinicio,
              tar_ffin:tar_ffin,
              tar_hfin:tar_hfin,
              tar_estado:tar_estado,
              tar_codigo:tar_codigo,                
              tar_mostrar:tar_mostrar                

            },
              beforeSend:function(){

              },
              success:function(dt){

                tar_id=dt['tar_id'];
                ncols=parseInt($('#tbl_tareas').find('th').length)-2;
                //alert(ncols.length);

                $('#tbl_tareas').find('th').eq(ncols).after(
                  `<th title='${tx_nt}' data-toggle='tooltip' class='text-center' data-placement='top' >
                  <input type='checkbox' size='5' class='chk_act new_tarea ' data='${ntr}' /><br>
                  ${ntr}
                  </th>`
                  );

                $('#tbl_tareas').find('tr').each(function () {
                  mat_id=$(this).find('.txt_prom_tmp').attr('mat_id');
                  $(this).find('td').eq(ncols).after(`<td class='${ntr}' ><input type='text' size='5' tar_id='${tar_id}' mat_id='${mat_id}' class='form-control txt_new_notas' /></td>`);
                });

              }
            })







}else if(tx_nt.length>0 && tx_nt.length<=5){
  alert('El nombre no es válido');
}
})
///************OCULTAR TAREAS*************///
$(document).on('click', '.ocultar_tarea', function(){
 
     if(confirm("Está seguro de ocultar la tarea?")){
              var cod=$(this).attr("tar_cod");
              var token=$("input[name=_token]").val();
              var url=window.location;
                $.ajax({
                  url:url+'/ocultar_tarea',
                  headers:{'X-CSRF-TOKEN':token},
                  type: 'POST',
                  dataType: 'json',
                  data: {op:0,cod:cod},
                  beforeSend:function(){

                  },
                  success:function(dt){
                    if(dt==0){
                      $("."+cod).remove(); 
                    }else{
                      mensaje("error","Error","Existió algun error porfavor vuelva a intentarlo");
                    }
                  }
                })
     }


})

///**************************************////
/////*****GRABAR NUEVAS NOTAS ******//////
$(document).on('blur', '.txt_new_notas', function(){

          var mat_id=$(this).attr('mat_id');
          var tar_id=$(this).attr('tar_id');
          var nota=$(this).val();
          var token=$("input[name=_token]").val();
          var obj=$(this);
          var url=window.location;
          
            $.ajax({
              url:url+'/guarda_notas_aportes',
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {mat_id:mat_id,tar_id:tar_id,nota:nota},
              beforeSend:function(){

                      if(nota>0 && nota<=10){

                      }else {

                        if(nota.length>0){
                          mensaje("error","Dato Incorrecto","La NOTA debe ser entre 1 y 10");
                          $(obj).val(null);
                        }

                         return false;

                      }                
              },
              success:function(dt){
                if(dt!=0){
                mensaje("error","Dato Incorrecto","La NOTA no se guardó favor revisar");  
                }
                //$("#bloque").html(dt);
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
})

///**********GUARDAR DATOS FUNCIÓN
function save_notas(obj){

matid=$(obj).attr('mat_id');
insid=$(obj).attr('ins_id');
regid=$(obj).attr('reg_id');
nota=$(obj).val();
mtrid=$("#mtr_id").val();
periodo=$("#bloque").val();
mtrtid=$("#mtr_tec_id").val();
nblq=0;
if(mtrtid!=0){
  dt=$('#mtr_tec_id option:selected').text().split('->');
  nblq=dt[1];
}
/////******SOLO PARA NOTAS ADICIONALES ******//////
if(periodo==100){
   periodo=$(obj).attr('blq');
}
/////********************************/////////////
          var token=$("input[name=_token]").val();
          var url=window.location;
            $.ajax({
              url:url+'/guardar_notas',
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {matid:matid,insid:insid,nota:nota,mtrid:mtrid,mtrtid:mtrtid,periodo:periodo,regid:regid,nblq:nblq},
              beforeSend:function(){

                      if(nota.length>=0){

                        if( !(nota>=0 && nota<=10) ){
                            mensaje("error","Dato Incorrecto","La NOTA debe ser entre 1 y 10");
                          $(obj).val(0);
                          return false;
                        }

                      }else {

                        return false;

                      }


              },
              success:function(r){

                if(r>0){
                  $(obj).attr('reg_id',r);
                  promedio_parcial_estudiante(obj);
                }
                  asigna_class(obj,nota);

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
////////*******ASIGNA CLASE DE ACUERDO A LA NOTA
function asigna_class(obj,nt){
  var cls="";
  if(nt>=5 && nt<7){
     cls="supletorio";
  }
  if(nt<5){
     cls="remedial";
  }

 $(obj).removeClass("supletorio");
 $(obj).removeClass("remedial");
 $(obj).addClass(cls);
}
///**MENSAJES
function mensaje(ico,tit,txt){
    Swal.fire(tit,txt,ico)
}

///**CARGAR EL AÑO LECTIVO SEGÚN EL CURSO
function obtiene_anio_lectivo(op){

          var token=$("input[name=_token]").val();
          var url=window.location;

            $.ajax({
              url:url+'/obtiene_anio_lectivo',
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {op:op},
              beforeSend:function(){

              },
              success:function(dt){

               $("#anl_id").val(dt);

               load_parciales(dt)

              }
            })                  
}

///CARGA LOS PARCIALES SEGUN EL AÑO LECTIVO O PERIODO
function load_parciales(anl){

          var token=$("input[name=_token]").val();
          var url=window.location;
            $.ajax({
              url:url+'/load_parciales',
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {anl:anl},
              beforeSend:function(){
              },
              success:function(dt){
                $("#bloque").html(dt);
              }
            })                  
}

///****PROMEDIA LOS INSUMOS
function promedio_parcial_estudiante(obj){

   var row=$(obj).parent().parent();
   var txtnotas=$(row).find(".txt_notas");
   var suma=0;
   var c=0;
  $(txtnotas).each(function(){
     suma+=parseFloat(($(this).val()*1));
  })
  $(row).find(".txt_prom_parcial").val( (suma/$(txtnotas).length).toFixed(2) );

}
///****TRAER TAREAS POR CURSO
function load_tareas_cursos(){
  
  var token=$("input[name=_token]").val();
  jor_id=$("#jor_id").val();
  esp_id=$("#esp_id").val();
  mtr_id=$("#mtr_id").val();
  if(esp_id!=10 && esp_id!=7 && esp_id!=8){
    mtr_id=$("#mtr_tec_id").val();
  }
  aux_cur=$("#cur_id").val().split('');
  cur_id=aux_cur[0];
  par=aux_cur[1];
  btn_buscar='search';

          var url=window.location;
            $.ajax({
              url:url+'/student_folder_search',
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {op:0,jor_id:jor_id,esp_id:esp_id,cur_id:cur_id,paralelo:par,mtr_id:mtr_id,btn_buscar:btn_buscar},
              beforeSend:function(){
                Swal.showLoading();
              },
              success:function(dt){
                  Swal.hideLoading();
                  $("#mdl_content").html(dt);
              }
            }); 

}



