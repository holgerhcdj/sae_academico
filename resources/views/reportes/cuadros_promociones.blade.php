<?php
if($op==2){
 $filename = "Cuadro_Final.xls";
  header("Pragma: public");
  header("Expires: 0");
  header("Content-type: application/vnd.ms-excel; name='excel'");
  header("Content-Disposition: attachment; filename=$filename");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}

///$dtarr=$eqv_comportamiento->get();

$tx_tipo_cuadro="";
$colspan_materias=3;
if($quim=='FINR'){
  $tx_tipo_cuadro=" DE REMEDIAL";
  $colspan_materias=4;
}
if($quim=='FING'){
  $tx_tipo_cuadro=" DE GRACIA";
  $colspan_materias=5;
}


if($conf['cur_id']==6){
  $titulo_promocion="CERTIFICADO DE APTITUD";
}else{
  $titulo_promocion="CERTIFICADO DE PROMOCIÓN";
}

$materias_json=convierte_materias($materias);
$materias_json=array_unique($materias_json);
$materias_json=devuelve_cadena($materias_json);

function convierte_materias($materias){
 $mtr_arr=[];
foreach ($materias as $m) {
  array_push($mtr_arr,$m->mtr_area);
}
return $mtr_arr;
}

function devuelve_cadena($materias_json){
  $tx="";
  foreach ($materias_json as $mj) {
    $tx.=$mj.'&&';
  }
  return $tx;
}





function clase_valor($valor){
     $cls="";
     if($valor>=5 && $valor<7){
      $cls="cls_supl";
    }elseif($valor>0 && $valor<5){
      $cls="cls_rem";
    }  
    return $cls;
}





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



//////**********NUMEROS A LETRAS///////////////////////////////////////

// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.

function number_words($valor,$desc_moneda, $sep, $desc_decimal) {
     $arr = explode(".", $valor);
     $entero = $arr[0];
     if (isset($arr[1])) {
         $decimos = strlen($arr[1]) == 1 ? $arr[1] . '0' : $arr[1];
     }

     $fmt = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
     if (is_array($arr)) {
         $num_word = ($arr[0]>=1000000) ? "{$fmt->format($entero)} de $desc_moneda" : "{$fmt->format($entero)} $desc_moneda";
         if (isset($decimos) ) {
             $num_word .= " $sep  {$fmt->format($decimos)} $desc_decimal";
        }
     }
     return $num_word;
}

function equivalencia_comportamiento($nt_com) {
$rst="";
  switch ($nt_com) {

    case 'A': $rst="Lidera el cumplimiento de los compromisos establecidos para la sana conviviencia social";  break;
    case 'B': $rst="Cumple con los compromisos establecidos para la sana convivencia social";  break;
    case 'C': $rst="Falla ocacionalmente en el cumplimiento de los compromisos establecidos para la sana convivencia social";  break;
    case 'D': $rst="Falla reiteradamente en el cumplimiento de los compromisos establecidos para la sana convivencia social";  break;
    case 'E': $rst="No cumple con compromisos establecidos para la sana convivencia social";  break;
    
    default:
      $rst="Algún error se ha producido";
      break;
  }
return $rst;
}


function promedio_proyectos_escolares($prom){
  $eqv="-";
  $eqv_text="-";

  if($prom>=9 && $prom<=10){
    $eqv="EX";
    $eqv_text="Desmuestra destacado desempeño en cada fase del desarrollo del proyecto escolar lo que constitutye un excelente aporte a su información integral";
  }
  if($prom>=8 && $prom<9){
    $eqv="MB";
    $eqv_text="Demuestra fiabilidad en el desempeño para cada fase del desarrollo del proyecto escolar lo que constitutye un aporte a su información integral";
  }
  if($prom>=7 && $prom<8){
    $eqv="B";
    $eqv_text="Desmuestra un desempeño medianamente aceptable en cada fase del desarrollo del proyecto escolar lo que no contribuye totalmente a su formación integral";
  }
  if($prom>0 && $prom<7){
    $eqv="B";
    $eqv_text="Desmuestra un desempeño medianamente aceptable en cada fase del desarrollo del proyecto escolar lo que no contribuye totalmente a su formación integral";
    //$eqv="R";///REVISAR DESDE LAS NOTAS CORRECTAS
  }
  return array($eqv,$eqv_text);
}



////////////////**************/////////////////////////////////////////////




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Imprimible</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
  <style>
    /*CODIGO DE VISTA PREVIA*/
    html { overflow: auto; padding: 0.5in; }
    html { background: #999; cursor: default; }
    body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
    /*Ancho 8.27 - alto 11.69*/
    body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);width: 8.27in;height:auto; }
    /*CODIGO DE IMPRESION*/
      @media all {
         .saltopagina{
          display: none;
        }
      }

      @media print{
        @page { margin: 0; }
        *{ -webkit-print-color-adjust: exact; }
        html{ background: none; padding: 0; }/*PARA QUE NO APAREZCA LA URL EN LA IMPRESION*/
        body{ box-shadow: none; margin: 0; }
        #logo_institucion{
          display:block; 
        }
        .saltopagina{
          display:block;
          page-break-before:always;
        }
      }     
/*CODIGO PROPIO DEL DOCUMENTO*/
    *{
      font-family:'Arial';
    }
    table{
       border-collapse:collapse;  
       font-size:10px; 
       width:100%;       
    }
    #logo_mineduc{
      width:220px; 
    }
   #footer{
    font-size:10px; 
    text-align:center;  
   }
  
   #header_principal{
    /*font-size:9px;  */
   }
   #header_secondary{
    font-size:10px;  
   }
   th,td{
    padding:3px 2px 3px 8px ; 
   }

  </style>

<script>
  
$(function(){
var mtr_json='{!!$materias_json!!}';
mtr_json=mtr_json.split('&&');

$(".mtr_estudiante").each(function(){

    for (var i = 0; i < mtr_json.length; i++) {
      mtr_formated=mtr_json[i].replace(/ /g, "");
      combina_filas( $("."+mtr_formated+$(this).attr('data')) );
    }

})


})

function combina_filas(obj){

nrow=$(obj).length;
var c=0;
$(obj).each(function(){
  c++;
  if(c==1){
    $(this).attr("rowspan",nrow);
  }else{
    $(this).remove();

  }

})



}

</script>


</head> 
<body>
                  <?php 
                    $x=1;
                    $prm80=0;
                    $prfq1=0;
                  ?> 
                  @foreach($datos as $d)
                  <?php
                  $dt_est=explode('&',$d->estudiante);
                  $x++;
                  ?>
                  <br>
                  <br>
                  <img src="http://181.211.10.10/img/logo_mineduc.png" alt="logo mineduc" id="logo_mineduc" >
                  <div id="header_principal">
                    <h5 style="text-align:center;margin-top:0px ">COORDINACIÓN ZONAL 9</h5>
                    <h5 style="text-align:center;margin-top:-10px ">{{$conf['distrito']}}</h5>
                    <h5 style="text-align:center;margin-top:-10px ">{{$conf['institucion']}} - {{$conf['amie']}}</h5>
                    <h5 style="text-align:center;margin-top:-10px ">{{$titulo_promocion}}</h5>
                    <h5 style="text-align:center;margin-top:-10px ">AÑO LECTIVO: {{$conf['anio_lectivo']}}</h5>
                    <h5 style="text-align:center;margin-top:-10px ">JORNADA: {{$conf['jornada']}}</h5>
                    <span class="mtr_estudiante" hidden data="{{$dt_est[1]}}" >{{$dt_est[1]}}</span>
                  </div>
                  <div id="header_secondary" >
                    <p>De conformidad con lo prescrito en el Art. 197 del Reglamento General a la Ley Orgánica de 
                     Educación Intercultural y demás normativas vigentes, certifica que el/la estudiante
                     <strong>{{ $dt_est[0] }}</strong> estudiante del <strong>{{$conf['curso'].' '.$conf['titulo'].' EN '.$conf['esp_descripcion_general'].' PARALELO '.$conf['paralelo']}}</strong> obtuvo las siguientes calificaciones durante el presente año lectivo.
                   </p>
                 </div>

                  <table border="1">

                    <tr> <th rowspan="2">AREAS</th><th rowspan="2">ASIGANTURAS</th><th colspan="2">CALIFICACIONES</th> </tr>
                    <tr> <th>NÚMERO</th><th>LETRAS</th> </tr>

                    <?php $prm_est=0; $prm_disc_mat="";$rowspan=0;$tx_area="";?>
                        @foreach($materias as $m)
                        <?php 
///////*************PROMEDIO QUIMESTRAL*****************///////////
                             $tx_p1="pb".$m->mtr_id."1";
                             $tx_p2="pb".$m->mtr_id."2";
                             $tx_p3="pb".$m->mtr_id."3";
                             $tex_q1="pb".$m->mtr_id."7";
                             $nt_p1=number_format($d->$tx_p1,2);
                             $nt_p2=number_format($d->$tx_p2,2);
                             $nt_p3=number_format($d->$tx_p3,2);
                             $ex_q1=number_format($d->$tex_q1,2);
                             $prm80=(($nt_p1+$nt_p2+$nt_p3)/3)*0.8;
                             $prfq1=number_format($prm80+($ex_q1*0.2),2);

                             $tx_p4="pb".$m->mtr_id."4";
                             $tx_p5="pb".$m->mtr_id."5";
                             $tx_p6="pb".$m->mtr_id."6";
                             $tex_q2="pb".$m->mtr_id."8";
                             $nt_p4=number_format($d->$tx_p4,2);
                             $nt_p5=number_format($d->$tx_p5,2);
                             $nt_p6=number_format($d->$tx_p6,2);
                             $ex_q2=number_format($d->$tex_q2,2);
                             $prm80=(($nt_p4+$nt_p5+$nt_p6)/3)*0.8;
                             $prfq2=number_format($prm80+($ex_q2*0.2),2);

                             $prmq=number_format(($prfq1+$prfq2)/2,3);
                             $prmq=substr($prmq,0,-1);



                                 $cls_prmq="";
                                 if($prmq==0){
                                  $prmq='-';
                                }elseif($prmq>=5 && $prmq<7){
                                  $cls_prmq="cls_supl";
                                }elseif($prmq>0 && $prmq<5){
                                  $cls_prmq="cls_rem";
                                }
///////*************NOTAS ADICIONALES*****************///////////
                             $tx_exs="pb".$m->mtr_id."100";
                             $nt_exs=number_format($d->$tx_exs,2);
                             $nt_exs==0?$nt_exs=null:'';

                             $cls_exs=null;
                             $cls_exs=clase_valor($nt_exs);

                             $tx_exr="pb".$m->mtr_id."101";
                             $nt_exr=number_format($d->$tx_exr,2);
                             $nt_exr==0?$nt_exr=null:'';

                             $cls_exr=null;
                             $cls_exr=clase_valor($nt_exr);

                             $tx_exg="pb".$m->mtr_id."102";
                             $nt_exg=number_format($d->$tx_exg,2);
                             $nt_exg==0?$nt_exg=null:'';

                             $cls_exg=null;
                             $cls_exg=clase_valor($nt_exg);

///////*************PROMEDIOS FINALES*****************///////////
                             $prm_final=$prmq;
                             if($prmq<7){
                                  if($nt_exs>=7 || $nt_exr>=7 || $nt_exg>=7 ){
                                       $prm_final=number_format(7,2);
                                  }
                             }
                             $cls_prmfin=null;
                             $cls_prmfin=clase_valor($prm_final);
                             $prm_est+=$prm_final;

///////*************NOTAS COMPORTAMIENTO*****************///////////
                            
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
                            $prom_c=calcula_comportamiento_q1($cb1,$cb2,$cb3);
                            $prm_disc_mat.=$prom_c;

                            $area_formateada=str_replace(' ', '',$m->mtr_area).$dt_est[1];

                        ?>
                       <tr>
                        <td class="{{$area_formateada}}">{{$m->mtr_area}}</td>
                        <td style="text-transform:uppercase;">{{$m->mtr_descripcion}}</td><td class="{{$cls_prmfin}}" style="text-align:center;" >{{$prm_final}}</td>  <td style="text-transform:uppercase;">{{number_words($prm_final,"","COMA","")}}</td> 
                      </tr>  
                        @endforeach
                        <?php
                        $prm_tot_est=number_format(($prm_est)/count($materias),3);
                        $prm_tot_est=substr($prm_tot_est,0,-1);
                        $prm_disc_mat=promedio_total_materias($prm_disc_mat);
                        ?>
                        <tr><th colspan="2" style="text-align:left; ">PROMEDIO GENERAL</th> <th style="text-align:center;" >{{$prm_tot_est}}</th> <th style="text-transform:uppercase;text-align:left; ">{{number_words($prm_tot_est,"","COMA","")}}</th></tr>
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
                            $prom_cinsp=calcula_comportamiento_q1($cb1,$cb2,$cb3);


                        ?>
                        @if($conf['cur_id']<4)
                            <tr>
                              <th colspan="2" style="text-align:left; ">EVALUACÓN DE PROYECTOS ESCOLARES</th>
                              <td style="text-align:center;">{{ promedio_proyectos_escolares($prm_tot_est)[0] }}</td> 
                              <td style="text-align:left;">{{ promedio_proyectos_escolares($prm_tot_est)[1] }}</td> 
                            </tr>
                        @endif

                        <tr>
                          <th colspan="2" style="text-align:left; ">EVALUACÓN DEL COMPORTAMIENTO</th>
                          <td style="text-align:center;">{{$prom_cinsp}}</td> 
                          <td>{{ equivalencia_comportamiento($prom_cinsp) }}</td>
                        </tr>
              </table> 
              @if($conf['cur_id']<6)
                <p style="font-size:11px ">Por tanto es promovido/a al <strong>&nbsp;{{$conf['cur_siguiente']}}</strong> para constancia suscriben en la unidad de acto el/la Director/a-Rector/a con el Secretario/a General del plantel que certifica.</p>
                @else
                <p style="font-size:11px ">Para constancia suscriben en la unidad de acto el/la Director/a-Rector/a con el Secretario/a General del plantel que certifica.</p>

              @endif  

              <br>
              <div id="footer">
                <br>
                <br>
                <span style="border-top:solid 1px;">{{$conf['rector']}}</span> 
                <span style="margin-left:28%;border-top:solid 1px;">{{$conf['secretaria']}}</span>
                <br>
                <span style="font-weight:bolder; ">RECTOR</span> 
                <span style="margin-left:50%;font-weight:bolder; ">SECRETARIA</span>
              </div>
              <div class="saltopagina"></div>
             @endforeach


</body>
</html>