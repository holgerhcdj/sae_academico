<?php
if($op==2){
    ////EXCEL DEL PRIMER QUIMESTRE CUADROS FINALES SOLO TÉCNICO QUIM 1
    $filename = "Cuadros Quimestre.xlsx";
    header("Pragma: public");
    header("Expires: 0");
    header("Content-type: application/vnd.ms-excel; name='excel'");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
$quim_text="PRIMER QUIMESTRE";
if($quim_number==2){
  $quim_text="SEGUNDO QUIMESTRE";
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

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Imprimible</title>
  <style>
    /*CODIGO DE VISTA PREVIA*/
    html { overflow: auto; padding: 0.5in; }
    html { background: #999; cursor: default; }
    body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
    /*Ancho 8.27 - alto 11.69*/
    body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);width: 8.27in;height:11.69in; }
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
       border-collapse: collapse;        
    }
    #logo_mineduc{
      position:absolute; 
      width:220px; 
    }
    #logo_institucion{
      position:absolute; 
      width:60px; 
      right:20%; 
    }
    .materias{
      width:25px; 
    }
    .materias span{
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      height:120px;
      font-weight:bolder;  
    }
    #tbl_datos th, #tbl_datos td{
      font-size:8px; 
      border:solid 1px; 
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
   .th_head{
    text-align:left; 
    font-size:10px; 
   }
   #footer{
    font-size:9px; 
    text-align:center;  
   }
   #header_principal{
    font-size:10px;  
   }
   #header_secondary{
    font-size:9px;  
   }

  </style>

</head>
<body>

    <img src="http://181.211.10.10/img/logo_mineduc.png" alt="logo mineduc" id="logo_mineduc" >
    <img src="http://181.211.10.10/SAE-VN/academico/public/img/escudo.png" alt="logo institucion" id="logo_institucion" hidden>
    <div id="header_principal">
      <h4 style="text-align:center;">{{$conf['distrito']}}</h4>
      <h4 style="text-align:center;">CUADRO DE PROMEDIOS DEL {{$quim_text}}</h4>
      <h3>1.-DATOS DE IDENTIFICACIÓN</h3>
    </div>

    <div id="header_secondary">
      <table >
        <tr><th class="th_head" colspan="2">NOMBRE DEL COLEGIO:</th><td colspan="6">{{$conf['institucion']}}</td></tr>
        <tr><th class="th_head" colspan="2">AÑO LECTIVO:</th><td colspan="6">{{$conf['anio_lectivo']}}</td></tr>
        <tr><th class="th_head" colspan="2">JORNADA:</th><td colspan="6">{{$conf['jornada']}}</td></tr>
        <tr><th class="th_head" colspan="2">AMIE:</th><td colspan="6">{{$conf['amie']}}</td></tr>
        <tr><th class="th_head" colspan="2">TÍTULO:</th><td colspan="6">{{$conf['titulo']}}</td></tr>
        <tr><th class="th_head" colspan="2">TIPO DE TÍTULO:</th><td colspan="6">BACHILLER</td></tr>
        <tr><th class="th_head" colspan="2">CURSO:</th><td colspan="6">{{$conf['curso']}}</td></tr>
        <tr><th class="th_head" colspan="2">ESPECIALIDAD:</th><td colspan="6">{{$conf['esp_descripcion_general']}}</td></tr>
        <tr><th class="th_head" colspan="2">PARALELO:</th><td colspan="6">{{$conf['paralelo']}}</td></tr>
      </table>
    </div>



                  <table  id="tbl_datos">
                  <tr>
                    <th style="font-weight:bolder;"><span>#</span></th>
                    <th style="font-weight:bolder;"><span>Apellidos y Nombres</span></th>
                    @foreach($materias as $m)
                    <th class="materias" ><span>{{$m->mtr_descripcion}}</span></th>
                    @endforeach
                    <th class="materias"><span> Promedio </span></th>
                    <th class="materias"><span>Comportamiento </span></th>
                    <th class="materias"><span>Observaciones </span></th>
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
                        if($quim_number==1){
                           $tx_p1="pb".$m->mtr_id."1";
                           $tx_p2="pb".$m->mtr_id."2";
                           $tx_p3="pb".$m->mtr_id."3";
                           $tex_q1="pb".$m->mtr_id."7";
                        }else{
                           $tx_p1="pb".$m->mtr_id."4";
                           $tx_p2="pb".$m->mtr_id."5";
                           $tx_p3="pb".$m->mtr_id."6";
                           $tex_q1="pb".$m->mtr_id."8";
                         }

                             $nt_p1=number_format($d->$tx_p1,2);
                             $nt_p2=number_format($d->$tx_p2,2);
                             $nt_p3=number_format($d->$tx_p3,2);
                             $ex_q1=number_format($d->$tex_q1,2);

                             $prm80=(($nt_p1+$nt_p2+$nt_p3)/3)*0.8;
                             
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
                              $prfq1='-';
                            }elseif($prfq1>=5 && $prfq1<7){
                              $cls_prfq1="cls_supl";
                            }elseif($prfq1>0 && $prfq1<5){
                              $cls_prfq1="cls_rem";
                            }
                            if($quim_number==1){ ////NOTAS DEL COMPORTAMIENTO
                              $tx_cb1="pb".$m->mtr_id."1";
                              $tx_cb2="pb".$m->mtr_id."2";
                              $tx_cb3="pb".$m->mtr_id."3";
                            }else{
                              $tx_cb1="pb".$m->mtr_id."4";
                              $tx_cb2="pb".$m->mtr_id."5";
                              $tx_cb3="pb".$m->mtr_id."6";
                            }

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

                            $prm_est+=$prfq1;

                            $prm_disc_mat.=$prom_c;

                        ?>
                        <td class="{{$cls_prfq1}}" style="text-align:center;" >
                              {{$prfq1}}
                        </td>
                        @endforeach
                        <?php
                          $prm_tot_est=number_format( truncar(($prm_est)/count($materias),2),2 );

                            $cls_prm_tot_est="";
                            if($prm_tot_est==0){
                              $prm_tot_est='-';
                            }elseif($prm_tot_est>=5 && $prm_tot_est<7){
                              $cls_prm_tot_est="cls_supl";
                            }elseif($prm_tot_est>0 && $prm_tot_est<5){
                              $cls_prm_tot_est="cls_rem";
                            }

                            $prm_disc_mat=promedio_total_materias($prm_disc_mat);///REVISAR EL PROMEDIO DE COMPORTYAMIENTO ENTRE INSPECCION Y MATERIAS

                        ?>
                        <td class="{{$cls_prm_tot_est}}" style="text-align:center;" >{{$prm_tot_est}}</td>
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
                            $prom_cinsp=calcula_comportamiento_q1($cb1,$cb2,$cb3);///REVISAR EL PROMEDIO DE COMPORTYAMIENTO ENTRE INSPECCION Y MATERIAS

                            $prom_cinsp_fin=calcula_comportamiento_q1($prm_disc_mat,$prom_cinsp,'A');///REVISAR EL PROMEDIO DE COMPORTYAMIENTO ENTRE INSPECCION Y MATERIAS


                        ?>
                        <td style="text-align:center;" >{{$prom_cinsp_fin}}</td>
                        @if($dt_est[2]==2) <!-- SI SE HA RETIRADO EL ESTUDIANTE -->
                          <td>RETIRADO: {{$dt_est[3]}}</td>
                        @else
                          <td></td>
                        @endif
                  </tr>
                  @endforeach
              </table> 
    <br>
    <br>
    <br>
    <div id="footer">
    <span style="">ELABORADO POR:</span> <span style="margin-left:40%">AVALADO POR:</span>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <span style="border-top:solid 1px;">{{$conf['secretaria']}}</span> <span style="margin-left:28%;border-top:solid 1px;">{{$conf['rector']}}</span>
    <br>
    <br>
    <span style="font-weight:bolder; ">SECRETARIA</span> <span style="margin-left:40%;font-weight:bolder; ">RECTOR</span>
  </div>


</body>
</html>

