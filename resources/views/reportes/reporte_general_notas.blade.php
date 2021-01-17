@extends('layouts.app')

@section('content')
<?php
/////////////////////PHP/////////////////***********
function calcula_comportamiento($cb1,$cb2,$cb3){
  $vb1=0;
  $vb2=0;
  $vb3=0;
  $prm_c=0;
switch ($cb1) { 
  case 'A':$vb1=5; break;
  case 'B':$vb1=4; break;
  case 'C':$vb1=3; break;
  case 'D':$vb1=2; break;
  case 'E':$vb1=1; break;
}

switch ($cb2) { 
  case 'A':$vb2=5; break;
  case 'B':$vb2=4; break;
  case 'C':$vb2=3; break;
  case 'D':$vb2=2; break;
  case 'E':$vb2=1; break;
}

switch ($cb3) { 
  case 'A':$vb3=5; break;
  case 'B':$vb3=4; break;
  case 'C':$vb3=3; break;
  case 'D':$vb3=2; break;
  case 'E':$vb3=1; break;
}
if($vb1>0 && $vb2>0 && $vb3>0 ){
  $prm_c=number_format(($vb1+$vb2+$vb3)/3);
}

if($vb1==0 && $vb2>0 && $vb3>0 ){
  $prm_c=number_format(($vb1+$vb2+$vb3)/2);
}
if($vb1==0 && $vb2==0 && $vb3>0 ){
  $prm_c=number_format(($vb1+$vb2+$vb3));
}

if($vb1>0 && $vb2==0 && $vb3>0 ){
  $prm_c=number_format(($vb1+$vb2+$vb3)/2);
}

if($vb1>0 && $vb2==0 && $vb3==0 ){
  $prm_c=number_format(($vb1+$vb2+$vb3));
}

if($vb1>0 && $vb2>0 && $vb3==0 ){
  $prm_c=number_format(($vb1+$vb2+$vb3)/2);
}

if($vb1==0 && $vb2>0 && $vb3==0 ){
  $prm_c=number_format(($vb1+$vb2+$vb3));
}


switch ($prm_c) { 
  case 5: return 'A' ;break;
  case 4: return 'B' ;break;
  case 3: return 'C' ;break;
  case 2: return 'D' ;break;
  case 1: return 'E' ;break;
  default: return '-';
}



}


function promedio_total_materias($prom)
{
   $valor=0;
$aux_c=0;
for ($i=0; $i < strlen($prom) ; $i++) { 
  if($prom[$i]!='-'){
    $aux_c++;
    switch ($prom[$i]) { 
      case 'A':$valor+=5; break;
      case 'B':$valor+=4; break;
      case 'C':$valor+=3; break;
      case 'D':$valor+=2; break;
      case 'E':$valor+=1; break;
    }   

  }

}

//dd(round(($valor)/$aux_c));
if($aux_c>0){
    switch ( round(($valor)/$aux_c) ) { 
      case 5:$valor='A'; break;
      case 4:$valor='B'; break;
      case 3:$valor='C'; break;
      case 2:$valor='D'; break;
      case 1:$valor='E'; break;
    } 
}else{
  $valor='-';
}

  return $valor;
}


?>

<!-- ////////***********JAVASCRIPT*******/////////////// -->
<script>
  $(function(){

      var prm_gen=0; var c=0;
    $(".promedio").each(function(){
      var mtr='m'+$(this).attr('id');
      var t=0;
      c++;
          $("td[mtr_id="+mtr+"]").each(function(){
            t+=parseFloat($(this).text());
          });
      var prm=(t/$("#tot_est").val());
      $(this).text((prm).toFixed(2));    
      prm_gen+=parseFloat(prm);
    });
    $("#prom_final").text((prm_gen/c).toFixed(2));

    datos_periodo( $("select[name=esp_id]").val() );

  })

$(function(){
  var x=0;
  var prm_tot=0;
   $(".cls_materias").each(function(){
    var prm=0;
    var j=0;
    x++;
        $( ".prom"+$(this).attr('data') ).each(function(){
          if($.isNumeric($(this).text())) {
                j++;
                prm+=parseFloat($(this).text());
          }

        });
        prm_tot+=parseFloat((prm/j).toFixed(2));
        $(".promedio"+$(this).attr('data')).text( (prm/j).toFixed(2) );
   })

   $(".prom_total").text( (prm_tot/x).toFixed(2) );

})


  $(document).on("submit","#frm_datos",function(){
    if($("#opcion").val()==1){
       $("#datos_excel").val( $("#tbl_datos").html() );
    }
  })



  $(document).on("click",".opciones",function(){
    vl=($(this).attr('data'));

    if(vl==1){
      $(".cls_insumo").hide();
      $(".cls_materias").attr("colspan",1);
      $(".cls_materias").css("font-size",11);

    }else{

      $(".cls_insumo").show();
      $(".cls_materias").attr("colspan",7);
      $(".cls_materias").css("font-size",14);
    }
  })


    var tipo=0;
    var txnota=0;

function desabilita_txt(){
  if('{{$op}}'==1){
    $("#p1").attr('disabled',true);
    $("#p2").attr('disabled',true);
    $("#p3").attr('disabled',true);
    $("#exq1").attr('disabled',true);
  }else{
    $("#p4").attr('disabled',true);
    $("#p5").attr('disabled',true);
    $("#p6").attr('disabled',true);
    $("#exq2").attr('disabled',true);
  }
    $("#prmq1").attr('disabled',true);
}



$(document).on("dblclick",".btn_prom",function(){ 
  desabilita_txt();
var op='{{$op}}';
    $("#btn_modal_notas").click();
    $("#est").text($(this).attr('est'));
if(op==1){
    $("#p1").val($(this).attr('p1'));
    $("#p2").val($(this).attr('p2'));
    $("#p3").val($(this).attr('p3'));
    $("#exq1").val($(this).attr('exq1'));
}else{
    $("#p4").val($(this).attr('p1'));
    $("#p5").val($(this).attr('p2'));
    $("#p6").val($(this).attr('p3'));
    $("#exq2").val($(this).attr('exq1'));
}

    $("#prmq1").val($(this).attr('prmq1'));
    $("#mat_id").val($(this).attr('mat_id'));
    $("#mtr_id").val($(this).attr('mtr_id'));

})

$(document).on("click","input[name=chk_notas]",function(){
desabilita_txt();

  if($(this).prop("checked")){
    $("#"+$(this).val()).attr("disabled",false);
  }else{
    $("#"+$(this).val()).attr("disabled",true);
  }

})


$(document).on("input","input[name=txt_notas]",function(){
    this.value = this.value.replace(/[^0-9.]/g,'');
})

$(document).on("click","#btn_guardar_notas",function(){

   $("input[name=chk_notas]").each(function(){
    if(  $(this).prop("checked")==true && $("#"+$(this).val()).prop("disabled")==false ){
      tipo=$(this).val();
      txnota=$("#"+$(this).val()).val();
    }
   })

            url=window.location;
            token=$("input[name=_token]").val();
            dat={mat_id:$("#mat_id").val(),
                 mtr_id:$("#mtr_id").val(),
                 tp:tipo,
                 nt:txnota,
                 esp_id:$("select[name=esp_id]").val(),
                }

            $.ajax({
                url: url+'/modifica_notas',//RegNotasController@modifica_notas
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {'dt[]':dat},
                beforeSend:function(){

                     if(txnota>10){

                        Swal.fire({
                          type: 'error',
                          title: 'Nota Incorrecta',
                          text: 'Error'
                      });
                        
                        return false;
                     }

                },
                success:function(dt){

                     if(dt==0){

                      Swal.fire(
                        'Processo Correcto',
                        'Para verificar los cambios presione F5',
                        'success'
                        )

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

            })  
});

function datos_periodo(esp){


            url=window.location;
            token=$("input[name=_token]").val();

            $.ajax({
                url: url+'/configuracion_anio_lectivo',//RegNotasController@configuracion_anio_lectivo
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {esp:esp},
                beforeSend:function(){

                },
                success:function(dt){
                  $("select[name=periodo]").html(dt);
                }

            })  

}

$(document).on("change","select[name=esp_id]",function(){
  datos_periodo($(this).val());
})



</script>

<style>
  .active{
    background:#069ABA !important; 
    color:white !important; 
    font-weight:bolder; 
  }
  th,td{
    border:solid 1px #ccc; 
  }
  .ins{
    padding:10px; 
  }
  .cls_success{
    background:#3C8C07; 
  }  
  .remedial{
    background:#d9534f; 
    color:white; 
  }
  .supletorio{
    background:#f0ad4e; 
  }
  .rotar {
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    margin-left:40%; 
  }    
  tr:hover{
    background:#53BCDE !important; 
  }
  .resumen:hover{
    background:#fff !important; 
  } 
.progress-bar-vertical {
  width: 50px;
  min-height: 200px;
  display: flex;
  align-items: flex-end;
  margin-right: 20px;
  float: left;
  background:#ccc; 
}
.progress-bar-vertical .progress-bar {
  width: 100%;
  height: 0;
  -webkit-transition: height 0.6s ease;
  -o-transition: height 0.6s ease;
  transition: height 0.6s ease;
}  
.btn_prom{
  /*cursor:pointer;*/
}
.btn_prom:hover{
  cursor:pointer;
  text-decoration:underline;
  background:#337ab7;  
  color:#fff;
  font-weight:bolder;  
}


/**************************style checkbox*********************/

/* Hiding the checkbox, but allowing it to be focused */
.badgebox
{
    opacity: 0;
}
.badgebox + .badge
{
    /* Move the check mark away when unchecked */
    text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
  width: 27px;
}
.badgebox:focus + .badge
{
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */
    
    /* Adding a light border */
    box-shadow: inset 0px 0px 5px;
    /* Taking the difference out of the padding */
}
.badgebox:checked + .badge
{
    /* Move the check mark back when checked */
  text-indent: 0;
}
/*************************************************************/

</style>


<!-- *************************** -->
<!-- MODAL DE NOTAS -->
<!-- *************************** -->

<script>
$(function(){

  var div;
  var br_nota=0;
   $(".cls_materias").each(function(){
    div=$(".barra"+$(this).attr('data')).parent();
    br_nota=parseFloat($(".promedio"+$(this).attr('data')).text());
    $(".barra"+$(this).attr('data')).text(  (br_nota*10).toFixed(2)+'%'  );
    $(div).css("height", (br_nota*10).toFixed(2)+'%' );

    if(br_nota>7){
      // $(div).css("background",'#04A704');
       $(div).addClass("cls_success");
    }
    if(br_nota>=5 && br_nota<7){
      // $(div).css("background",'#D2B232');
      $(div).addClass("cls_supl");
    }
    if(br_nota>=1 && br_nota<5){
      // $(div).css("background",'#A52A2A');
      $(div).addClass("cls_rem");
    }

   });

    div=$(".barra_prom_total").parent();
    br_nota=parseFloat($(".prom_total").text());
    $(".barra_prom_total").text(  (br_nota*10).toFixed(2)+'%'  );
    $(div).css("height", (br_nota*10).toFixed(2)+'%' );

var tx_enc=$("select[name=jor_id] option:selected").text()+" / "+$("select[name=esp_id] option:selected").text()+" / "+$("select[name=cur_id] option:selected").text()+" / "+$("select[name=paralelo] option:selected").text()+" / "+$("select[name=periodo] option:selected").text();

  $("#txt_encabezado").text(tx_enc);
  
})

$(document).on("submit","#frm_datos",function(){
  const op=$("#opcion").val();
  if(op>=2){
     $(this).prop('target','_blank');
  }else{
     $(this).prop('target','_top');
 }



})  
</script>



<button type="button" style="display:none "  class="btn btn-primary" id="btn_modal_notas" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table>
            <tr>
                <input type="hidden" id="mat_id">
                <input type="hidden" id="mtr_id">
              <th id="est" colspan="5" class="text-center" >
              </th>
            </tr>
            <tr>
              @if($op==1)
              <th> <input  type="radio" name="chk_notas" value="p1" > P1</th>
              <th> <input  type="radio" name="chk_notas" value="p2" > P2</th>
              <th> <input  type="radio" name="chk_notas" value="p3" > P3</th>
              <th> <input  type="radio" name="chk_notas" value="exq1" > EXQ1</th>
              @else
              <th> <input  type="radio" name="chk_notas" value="p4" > P4</th>
              <th> <input  type="radio" name="chk_notas" value="p5" > P5</th>
              <th> <input  type="radio" name="chk_notas" value="p6" > P6</th>
              <th> <input  type="radio" name="chk_notas" value="exq2" > EXQ2</th>
              @endif

              <th>PROM</th>
            </tr>
            <tr>
              @if($op==1)
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="p1" > </td>
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="p2" > </td>
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="p3" > </td>
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="exq1" > </td>
              @else
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="p4" > </td>
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="p5" > </td>
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="p6" > </td>
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="exq2" > </td>
              @endif
              <td> <input type="text" class="form-control" disabled name="txt_notas" id="prmq1" > </td>
            </tr>

          </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_guardar_notas" class="btn btn-primary pull-left">Guardar</button>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

<!-- *************************** -->
<!-- MAIN  -->
<!-- *************************** -->

<section class="content-header">
  <h1 class="bg-primary text-center" >Reporte General de Notas</h1>

<form action="reporte_general_notas" method="POST" id="frm_datos"  >
  {{csrf_field()}}

        <div class="text-left" >

          <div class="btn-group btn-group-toggle"  data-toggle="buttons">
            <label class="btn btn-default opciones  active" data="0" >
              <input type="radio" name="ins_general" value="0" autocomplete="off" checked> Promedios + Insumos
            </label>
            <label class="btn btn-default opciones " data="1" >
              <input type="radio" name="ins_general" value="1" autocomplete="off"> Sólo Promedios
            </label>
          </div>

<!--           <label for="primary" class="btn btn-primary">Primary <input type="checkbox" id="primary" class="badgebox"><span class="badge">&check;</span></label>
          <label for="info" class="btn btn-info">Info <input type="checkbox" id="info" class="badgebox"><span class="badge">&check;</span></label>
          <label for="success" class="btn btn-success">Success <input type="checkbox" id="success" class="badgebox"><span class="badge">&check;</span></label>
          <label for="warning" class="btn btn-warning">Warning <input type="checkbox" id="warning" class="badgebox"><span class="badge">&check;</span></label>
          <label for="danger" class="btn btn-danger">Danger <input type="checkbox" id="danger" class="badgebox"><span class="badge">&check;</span></label>
 -->



        </div>


        <div class="input-group">
          <span class="input-group-addon">
            <input type="hidden" id="datos_excel" name="datos_excel"  >
            <input type="hidden" id="opcion" name="opcion" >
            {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
          </span>  
          <span class="input-group-addon">
            {!! Form::select('esp_id',$cmb_esp,null, ['class' => 'form-control']) !!}
          </span>
          <span class="input-group-addon">
            {!! Form::select('cur_id',$cur,null, ['class' => 'form-control']) !!}
          </span>  
          <span class="input-group-addon">
            {!! Form::select('paralelo',[
            'A'=>'A',
            'B'=>'B',
            'C'=>'C',
            'D'=>'D',
            'E'=>'E',
            'F'=>'F',
            'G'=>'G',
            'H'=>'H',
            'I'=>'I',
            'J'=>'J',
            ],null, ['class' => 'form-control']) !!}
          </span>  
          <span class="input-group-addon">
            {!! Form::select('periodo',[],null, ['class' => 'form-control']) !!}
          </span>          
          <span class="input-group-addon" style="padding:0px;margin:0px" >
            <button class="btn_opcion btn btn-info" name="btn_buscar" onclick="opcion.value=0" value="btn_buscar"   ><i class="fa fa-search"></i> </button>
            <button class="btn_opcion btn btn-success" name="btn_buscar" onclick="opcion.value=1" value="btn_excel"   ><i class="fa fa-file-excel-o"></i> </button>
            <button class="btn_opcion btn btn-warning" name="btn_buscar" onclick="opcion.value=2" value="btn_bajo_supl"   ><i class="fa fa-meh-o"></i> Bajo Rendimiento </button>
<!--             <button class="btn_opcion btn btn-danger" name="btn_buscar" onclick="opcion.value=3" value="btn_bajo_rem"   ><i class="fa fa-frown-o"></i> Menor a 5 </button>
            <button class="btn_opcion btn btn-default" name="btn_buscar" onclick="opcion.value=4" value="btn_none"   ><i class="fa fa-times-circle-o"></i> Sin Nota </button>
 -->          </span>
        </div>
</form>        
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="table-responsive">
                {!! $resultado !!}
               </div>
           </div>
       </div>
   </div>
@endsection