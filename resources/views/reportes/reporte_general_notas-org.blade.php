@extends('layouts.app')

@section('content')
<?php

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

    datos_periodo($("select[name=esp_id]").val());

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

  var dt=`<option value="1">Parcial 1</option>
          <option value="2">Parcial 2</option>
          <option value="3">Parcial 3</option>
          <option value="Q1">Primer Quimestre</option>
          <option value="4">Parcial 4</option>
          <option value="5">Parcial 5</option>
          <option value="6">Parcial 6</option>
          <option value="Q2">Segundo Quimestre</option>`;
    if(esp==7){
      dt=`<option value="1">Parcial 1</option>
          <option value="2">Parcial 2</option>
          <option value="Q1">Primer Quimestre</option>
          <option value="3">Parcial 3</option>
          <option value="4">Parcial 4</option>
          <option value="Q2">Segundo Quimestre</option>`;
    }

    $("select[name=periodo]").html(dt);


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
  .cls_rem{
    background:brown; 
    color:white; 
  }
  .cls_supl{
    background:#C5C805; 
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

<form action="reporte_general_notas" method="POST" id="frm_datos" >
  {{csrf_field()}}

<div class="text-center">
  <div class="btn-group btn-group-toggle"  data-toggle="buttons">
    <label class="btn btn-default opciones  active" data="0" >
      <input type="radio" name="ins_general" value="0" autocomplete="off" checked> Promedios + Insumos
    </label>
    <label class="btn btn-default opciones " data="1" >
      <input type="radio" name="ins_general" value="1" autocomplete="off"> Sólo Promedios
    </label>
  </div>
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
            {!! Form::select('periodo',[
            '1'=>'Parcial 1',
            '2'=>'Parcial 2',
            '3'=>'Parcial 3',
            'Q1'=>'Primer Quimestre',
            '4'=>'Parcial 4',
            '5'=>'Parcial 5',
            '6'=>'Parcial 6',
            'Q2'=>'Segundo Quimestre',

            ],null, ['class' => 'form-control']) !!}
          </span>          
          <span class="input-group-addon">
            <button class="btn btn-primary" name="btn_buscar" onclick="opcion.value=0" value="btn_buscar">Buscar</button>
            <button class="btn btn-success" name="btn_buscar" onclick="opcion.value=1" value="btn_excel">Excel</button>
          </span>
        </div>
</form>        
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="table-responsive">

                @if($op==0)
                  <table class="table table-hover" id="tbl_datos" style="width:auto; ">
                  <colgroup>
                    <col span="2">
                    <?php $x=1;$clsh=""; ?>
                    @foreach($materias as $m)
                    <?php 
                    $x++; 
                    if($x%2==0){
                      $clsh="bg-info";
                    }else{
                      $clsh="";
                    }
                    ?>
                    <col span="7" class="{{$clsh}}" >
                    @endforeach                    
                  </colgroup>
                  <tr>
                    <th colspan="2">Estudiante</th>
                    @foreach($materias as $m)
                    <th colspan="7" class="text-center cls_materias">{{$m->mtr_descripcion}}</th>
                    @endforeach
                  </tr>
                  <tr>
                    <th>#</th>
                    <th style="color:#fff;" >--------------------------------------------------------</th>
                    @foreach($materias as $m)
                    <th class="ins cls_insumo">Ins1</th>
                    <th class="ins cls_insumo">Ins2</th>
                    <th class="ins cls_insumo">Ins3</th>
                    <th class="ins cls_insumo">Ins4</th>
                    <th class="ins cls_insumo">Ins5</th>
                    <th class="ins cls_insumo">Ins6</th>
                    <th>Prom</th>
                    @endforeach
                    <?php 
                    $x=1;
                    ?>
                    @if(!empty($datos))             

                    @foreach($datos as $d)
                    <tr>
                      <td>{{$x++}}</td>
                      <td>{{$d->estudiante}}</td>
                      <?php $c=0;$aux_prom=0;?>
                      @foreach($enc_nota as $enc)
                      <?php 
                      $c++;
                      $nota=number_format($d->$enc,2);
                      $aux_prom+=$nota;

                      if(empty($d->$enc)){
                        $nota="-";
                      }
                      $cls_nota="";
                      if($nota>=1 && $nota<5){
                        $cls_nota="cls_rem";
                      }
                      if($nota>=5 && $nota<7){
                        $cls_nota="cls_supl";
                      }
                      ?>
                      @if($c==6)
                      <?php 
                      if($nota=='-'){
                        $div=5;
                      }else{
                        $div=6;

                      }
                      $cls_prom="";
                      if(($aux_prom/$div)>=1 && ($aux_prom/$div)<5 ){
                        $cls_prom="cls_rem";
                      }
                      if( ($aux_prom/$div)>=5 && ($aux_prom/$div)<7 ){
                        $cls_prom="cls_supl";
                      }
                      ?>
                      <td class="text-right {{$cls_nota}} cls_insumo">{{$nota}}</td>
                      <td class="text-right {{$cls_prom}} ">{{number_format($aux_prom/$div,2)}}</td>
                      <?php 
                      $c=0;
                      $aux_prom=0;
                      ?>
                      @else
                      <td class="text-right {{$cls_nota}} cls_insumo ">{{$nota}}</td>
                      @endif
                      @endforeach
                    </tr>
                    @endforeach

<!-- PROMEDIOS -->

                    <tr>
                      <th colspan="2">Promedio</th>
                      <?php $i=0;$prom_nota=0;$nt_prom=0;?>
                      @foreach($enc_nota as $enc)
                      <?php 
                      $i++;
                      $nt_prom=number_format($promedios[0]->$enc,2);
                      $cls_prom="";
                      if(($nt_prom)>=1 && ($nt_prom)<5 ){
                        $cls_prom="cls_rem";
                      }
                      if( ($nt_prom)>=5 && ($nt_prom)<7 ){
                        $cls_prom="cls_supl";
                      }

                      $prom_nota+=$nt_prom;
                      if(empty($promedios[0]->$enc)){
                        $nt_prom='-';
                      }
                      ?>

                      @if($i==6)
                      <?php 
                      if($nt_prom=='-'){
                        $div=5;
                      }else{
                        $div=6;
                      }
                      $cls_prom="";
                      if(($prom_nota/$div)>=1 && ($prom_nota/$div)<5 ){
                        $cls_prom="cls_rem";
                      }
                      if( ($prom_nota/$div)>=5 && ($prom_nota/$div)<7 ){
                        $cls_prom="cls_supl";
                      }

                      ?>
                      <th class="cls_insumo">{{$nt_prom}}</th>
                      <th class="text-right {{$cls_prom}}">{{number_format(($prom_nota/$div),2)}}</th>
                      <?php $i=0;$prom_nota=0; ?>
                      @else
                      <th class="text-right {{$cls_prom}} cls_insumo">{{$nt_prom}}</th>
                      @endif
                      @endforeach
                    </tr>

<!-- FIN PROMEDIOS -->
                    
                    @else
                    <tr><th colspan="10" class="bg-danger">NO EXISTEN DATOS</th></tr>                  
                    @endif
                  </table>
                @else

                <table class="table table-hover" id="tbl_datos" style="width:auto; ">
                    <tr>
                      <th class="text-center" colspan="{{(count($materias)*6)+2}}">UNIDAD EDUCATIVA TÉCNICA VIDA NUEVA</th>
                    </tr>
                    <tr>
                      <th class="" colspan="{{(count($materias)*6)+2}}">REPORTE DE NOTAS QUIMESTRAL POR FIGURA PROFESIONAL</th>
                    </tr>
                    <tr>
                      <th class="" colspan="{{(count($materias)*6)+2}}" id="txt_encabezado" ></th>
                    </tr>
                  <colgroup>
                    <col span="2">
                    <?php $x=1;$clsh=""; ?>
                          @foreach($materias as $m)
                          <?php 
                          $x++; 
                          if($x%2==0){
                            $clsh="bg-info";
                          }else{
                            $clsh="";
                          }
                          ?>
                          <col span="6" class="{{$clsh}}" >
                          @endforeach  
                          <col class="bg-success">                  
                          <col span="3" class="bg-info">                  
                  </colgroup>
                  <tr>
                    <th colspan="2">Estudiante</th>
                    @foreach($materias as $m)
                    <th colspan="6" class="text-center cls_materias" data="{{$m->mtr_id}}" >{{$m->mtr_descripcion}}</th>
                    @endforeach
                    <th>PROM</th>
                    <th colspan="3">COMPORTAMIENTO</th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th style="color:#fff;" >--------------------------------------------------------</th>
                    @foreach($materias as $m)
                    @if($op==1)
                      @if($esp==7)
                        <th class="ins cls_insumo">P1</th>
                        <th class="ins cls_insumo">P2</th>
                        <th class="ins cls_insumo">-</th>
                      @else
                        <th class="ins cls_insumo">P1</th>
                        <th class="ins cls_insumo">P2</th>
                        <th class="ins cls_insumo">P3</th>
                      @endif
                      <th class="ins cls_insumo">EXQ1</th>
                      <th>PRM_Q1</th>
                    @else

                      @if($esp==7)
                        <th class="ins cls_insumo">P3</th>
                        <th class="ins cls_insumo">P4</th>
                        <th class="ins cls_insumo">-</th>
                      @else
                        <th class="ins cls_insumo">P4</th>
                        <th class="ins cls_insumo">P5</th>
                        <th class="ins cls_insumo">P6</th>
                      @endif

                      <th class="ins cls_insumo">EXQ2</th>
                      <th>PRM_Q2</th>
                    @endif
                    <th class="ins cls_insumo cls_comp">COMP</th>
                    @endforeach
                    <th>TOT</th>
                    <th>Mat(70%)</th>
                    <th>Insp(30%)</th>
                    <th>PROM</th>
                  </tr> 
                  <?php 
                    $x=1;
                    $prm80=0;
                    $prfq1=0;
                  ?> 
                  @foreach($datos as $d)
                  <?php
                  $dt_est=explode('&',$d->estudiante);
                  ?>
                  <tr>
                    <td>{{$x++}}</td>
                    <td>{{ $dt_est[0] }}</td>
                    <?php $prm_est=0; $prm_disc_mat="";?>
                        @foreach($materias as $m)
                        <?php 
                            if($op==1){//Primer Quimestre

                              if($esp==7){///si es BGU
                                 $tx_p1="pb".$m->mtr_id."1";
                                 $tx_p2="pb".$m->mtr_id."2";
                                 $tx_p3="pb".$m->mtr_id."5";
                                 $tex_q1="pb".$m->mtr_id."7";
                              }else{
                                 $tx_p1="pb".$m->mtr_id."1";
                                 $tx_p2="pb".$m->mtr_id."2";
                                 $tx_p3="pb".$m->mtr_id."3";
                                 $tex_q1="pb".$m->mtr_id."7";
                              }

                            }else{ //Segundo Quimestre

                              if($esp==7){///si es BGU
                                 $tx_p1="pb".$m->mtr_id."3";
                                 $tx_p2="pb".$m->mtr_id."4";
                                 $tx_p3="pb".$m->mtr_id."6";

                              }else{
                                 $tx_p1="pb".$m->mtr_id."4";
                                 $tx_p2="pb".$m->mtr_id."5";
                                 $tx_p3="pb".$m->mtr_id."6";
                              }                              

                                 $tex_q1="pb".$m->mtr_id."8";
                            }

                             $nt_p1=number_format($d->$tx_p1,2);
                             $nt_p2=number_format($d->$tx_p2,2);
                             $nt_p3=number_format($d->$tx_p3,2);
                             $ex_q1=number_format($d->$tex_q1,2);

                            if($esp==7){
                               $prm80=(($nt_p1+$nt_p2)/2)*0.8;
                             }else{
                               $prm80=(($nt_p1+$nt_p2+$nt_p3)/3)*0.8;
                            }

                             $prfq1=number_format($prm80+($ex_q1*0.2),2);

                            $cls_p1="";
                            if($nt_p1==0){
                              $nt_p1='-';
                            }elseif($nt_p1>=5 && $nt_p1<7){
                              $cls_p1="cls_supl";
                            }elseif($nt_p1>0 && $nt_p1<5){
                              $cls_p1="cls_rem";
                            }                            

                            $cls_p2="";
                            if($nt_p2==0){
                              $nt_p2='-';
                            }elseif($nt_p2>=5 && $nt_p2<7){
                              $cls_p2="cls_supl";
                            }elseif($nt_p2>0 && $nt_p2<5){
                              $cls_p2="cls_rem";
                            }

                            $cls_p3="";
                            if($nt_p3==0){
                              $nt_p3='-';
                            }elseif($nt_p3>=5 && $nt_p3<7){
                              $cls_p3="cls_supl";
                            }elseif($nt_p3>0 && $nt_p3<5){
                              $cls_p3="cls_rem";
                            }

                            $cls_q1="";
                            if($ex_q1==0){
                              $ex_q1='-';
                            }elseif($ex_q1>=5 && $ex_q1<7){
                              $cls_q1="cls_supl";
                            }elseif($ex_q1>0 && $ex_q1<5){
                              $cls_q1="cls_rem";
                            }

                            $cls_prfq1="";
                            if($prfq1==0){
                              //$prfq1='-';
                            }elseif($prfq1>=5 && $prfq1<7){
                              $cls_prfq1="cls_supl";
                            }elseif($prfq1>0 && $prfq1<5){
                              $cls_prfq1="cls_rem";
                            }
                            
                            $prm_est+=$prfq1;

                            $tx_cb1="pb".$m->mtr_id."1";
                            $tx_cb2="pb".$m->mtr_id."2";
                            $tx_cb3="pb".$m->mtr_id."3";
                            $cb1=null;
                            $cb2=null;
                            $cb3=null;
                            if(isset($datos_c[($x-2)]->$tx_cb1)){
                              $cb1=$datos_c[($x-2)]->$tx_cb1;
                            }
                            if(isset($datos_c[($x-2)]->$tx_cb2)){
                              $cb2=$datos_c[($x-2)]->$tx_cb2;
                            }
                            if(isset($datos_c[($x-2)]->$tx_cb3)){
                              $cb3=$datos_c[($x-2)]->$tx_cb3;
                            }

                            $prom_c=calcula_comportamiento($cb1,$cb2,$cb3);
                            $prm_disc_mat.=$prom_c;
                            $prm_disc_mat;

                        ?>
                        <td class="ins cls_insumo {{$cls_p1}} ">{{$nt_p1}}</td>
                        <td class="ins cls_insumo {{$cls_p2}} ">{{$nt_p2}}</td>
                        <td class="ins cls_insumo {{$cls_p3}} ">{{$nt_p3}}</td>
                        <td class="ins cls_insumo {{$cls_q1}} ">{{$ex_q1}}</td>
                        <td class="{{$cls_prfq1}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $dt_est[0] }}" >
                          <span class="btn_prom {{'prom'.$m->mtr_id}}" est="{{$dt_est[0].' / '.$m->mtr_descripcion}}" mat_id="{{$dt_est[1]}}" mtr_id="{{$m->mtr_id}}" p1="{{$nt_p1}}" p2="{{$nt_p2}}" p3="{{$nt_p3}}" exq1="{{$ex_q1}}" prmq1="{{$prfq1}}" >
                              {{$prfq1}}
                          </span>
                        </td>
                        <td class="cls_insumo {{'comp'.$m->mtr_id.'-'.$dt_est[1]}}" >{{$prom_c }}</td>
                        @endforeach
                        <?php
                        $prm_tot_est=number_format(($prm_est)/count($materias),2);

                            $cls_prm_tot_est="";
                            if($prm_tot_est==0){
                              $prm_tot_est='-';
                            }elseif($prm_tot_est>=5 && $prm_tot_est<7){
                              $cls_prm_tot_est="cls_supl";
                            }elseif($prm_tot_est>0 && $prm_tot_est<5){
                              $cls_prm_tot_est="cls_rem";
                            }
                            $prm_disc_mat=promedio_total_materias($prm_disc_mat);

                        ?>
                        <td class="{{$cls_prm_tot_est}}">{{$prm_tot_est}}</td>
                        <td>{{$prm_disc_mat}}</td>
                        <?php  

                            $cb1=null;
                            $cb2=null;
                            $cb3=null;
                            if(isset($datos_c[($x-2)]->pb31)){
                              $cb1=$datos_c[($x-2)]->pb31;
                            }
                            if(isset($datos_c[($x-2)]->pb32)){
                              $cb2=$datos_c[($x-2)]->pb32;
                            }
                            if(isset($datos_c[($x-2)]->pb33)){
                              $cb3=$datos_c[($x-2)]->pb33;
                            }

                            $prom_cinsp=calcula_comportamiento($cb1,$cb2,$cb3);

                            $prm_comp_fin='-';
                            $prm_comp_fin=calcula_comportamiento($prm_disc_mat,$prom_cinsp,'');
                        ?>
                        <td>{{$prom_cinsp}}</td>
                        <td>{{$prm_comp_fin}}</td>
                  </tr>
                  @endforeach

                  <tr class="resumen">
                    <th colspan="2"></th>
                    @foreach($materias as $m)
                    <th class="cls_insumo" colspan="4"></th>
                    <th class="{{'promedio'.$m->mtr_id}}"></th>
                    <th class="cls_insumo" ></th>
                    @endforeach
                    <th class="prom_total" style="font-size:18px;font-weight:bolder;color:#AB0707   "></th>
                  </tr>

                  <tr class="resumen">
                    <th colspan="2"></th>
                    @foreach($materias as $m)
                    <th class="cls_insumo" colspan="4"></th>
                    <th class="td_barra">
                        <div class="progress progress-bar-vertical" >
                          <div class="progress-bar"  role="progressbar" >
                            <span class="{{'barra'.$m->mtr_id}}"></span>
                          </div>
                        </div>
                    </th>
                    <th class="cls_insumo" ></th>
                    @endforeach
                    <th>
                        <div class="progress progress-bar-vertical" >
                          <div class="progress-bar"  role="progressbar" >
                            <span class="barra_prom_total"></span>
                          </div>
                        </div>                      
                    </th>
                  </tr>
                  </table> 
                @endif

               </div>
           </div>
       </div>
   </div>
@endsection