@extends('layouts.app')
@section('content')
<?php
function calcula_comportamiento_q1($cb1,$cb2,$cb3){
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

       for ($i=0; $i < count($prom) ; $i++) {

        switch ($prom[$i]) {
          case 'A':$valor+=5; break;
          case 'B':$valor+=4; break;
          case 'C':$valor+=3; break;
          case 'D':$valor+=2; break;
          case 'E':$valor+=1; break;
        }

      }

      switch ($valor) {
        case 5: $vl='A' ;break;
        case 4: $vl='B' ;break;
        case 3: $vl='C' ;break;
        case 2: $vl='D' ;break;
        case 1: $vl='E' ;break;
        default: $vl='B';
      }

      return $vl;
}

function truncar($numero, $digitos)
{
    $truncar = 10**$digitos;
    return intval($numero * $truncar) / $truncar;
}

?>


<script>
$(document).on("submit","#frm_datos",function(){

  if(opcion.value==0){
    $(this).attr('target',"_TOP");
  }
})

$(document).on("click",".btn_elimina_notas_quimestre",function(){

          var token=$("input[name=_token]").val();
          var url=window.location;
          var matid=$(this).attr('mat_id');
          var quim=$("select[name=periodo]").val();

            $.ajax({
              url:url+'/elimina_notas_quimestres', ///RegnotasControlle
              headers:{'X-CSRF-TOKEN':token},
              type: 'POST',
              dataType: 'json',
              data: {matid:matid,quim:quim},
              beforeSend:function(){

                if(confirm("Está seguro de eliminar las notas")){
                  if(prompt("Código de seguridad")!='1714'){
                    return false;
                  }
                }else{
                  return false;
                }

              },
              success:function(r){
                if(r==0){
                  alert('Eliminado correctamente');
                }

              }

          })



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
    background:#CA7171;
    color:white;
    color:#000;
  }
  .cls_supl{
    background:#CACC62;
    color:#000;
  }
  .rotar {
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    margin-left:40%;
  }
  tr:hover{
    background:#BEE3EF !important;
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
</style>


<section class="content-header">
  <h1 class="bg-primary text-center" >Reporte de Notas Finales </h1>

<form action="reporte_cuadros_finales" method="POST" id="frm_datos" target="_blank" >
  {{csrf_field()}}

        <div class="input-group">
          <span class="input-group-addon">
            <input type="hidden" id="opcion" name="opcion" >
            {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
          </span>
          <span class="input-group-addon">
            {!! Form::select('esp_id',$esp,null, ['class' => 'form-control']) !!}
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
            'Q1'=>'Primer Quimestre',
            'Q2'=>'Segundo Quimestre',
            'FIN'=>'Cuadro Final Supletorio',
            'FINR'=>'Cuadro Final Remedial',
            'FING'=>'Cuadro Final Gracia',
            'PROM'=>'Promociones',

            ],null, ['class' => 'form-control']) !!}
          </span>
          <span class="input-group-addon">
            <button class="btn btn-info fa fa-search" name="btn_buscar" onclick="opcion.value=0" value="btn_buscar"> Mostrar</button>
            <button class="btn btn-default fa fa-print " name="btn_buscar" onclick="opcion.value=1" value="btn_excel"> Imprimir</button>
            <button class="btn btn-success fa fa-file-excel-o " name="btn_buscar" onclick="opcion.value=2" value="btn_excel"> Descargar</button>
          </span>
        </div>
</form>
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="table-responsive">
                @if($qm=='Q1')

                    @if($ep!=7)
                      @include("reportes.cuadros_q1")
                    @else
                      @include("reportes.cuadros_q1_bgu")
                    @endif

                @elseif($qm=='Q2')
                  @include("reportes.cuadros_q2")
                @else
                  @include("reportes.cuadros_final")
                @endif
               </div>
           </div>
       </div>
   </div>
@endsection