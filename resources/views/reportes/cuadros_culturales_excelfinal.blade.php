<?php
//CULTURAL // BGU // BÁSICA FLEXIBLE
$filename = 'FIN-'.$dt_enc_xls['jor'].'-'.str_replace(' ', '',$dt_enc_xls['esp']).'-'.$dt_enc_xls['cur'].'-'.$dt_enc_xls['par'].".xls";
header("Pragma: public");
header("Expires: 0");
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$txt_esp=$dt_enc_xls['esp'];
if($txt_esp=='BGU'){
  $txt_esp="DE BACHILLERATO GENERAL UNIFICADO";
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
?>

 <head>
  <meta charset="UTF-8">
  <style>
    img{
      position:absolute;
    }

    .materias span{
      writing-mode: vertical-lr;
      transform: rotate(180deg);
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

  </style>
</head> 
<img src="http://181.211.10.10/img/logo_mineduc.png" alt="logo mineduc" >

                <table>
                    <tr>
                      <th  colspan="{{(count($materias)*5)+2}}" style="text-align:center;font-size:18px;font-family:Cambria">
                          COORDINACIÓN ZONAL 9
                    </th>
                    </tr>
                    <tr>
                      <th  colspan="{{(count($materias)*5)+2}}" style="text-align:center;font-size:18px;font-family:Cambria  ">DISTRITO EDUCATIVO 17D07 - QUITUMBE</th>
                    </tr>
                    <tr>
                      <th  colspan="{{(count($materias)*5)+2}}" style="text-align:center;font-size:15px;font-family:Cambria">INSTITUCIÓN EDUCATIVA VIDA NUEVA I - 17H02926 </th>
                    </tr>
                    <tr>
                      <th  colspan="{{(count($materias)*5)+2}}" style="text-align:center;font-size:13px;font-family:Cambria">AÑO LECTIVO 2019-2020 </th>
                    </tr>
                    <tr>

                      @if($qm=='Q1')
                          <th  colspan="{{(count($materias)*5)+2}}" style="text-align:center;font-size:10px;" >CUADROS DEL 1ER QUIMESTRE</th>
                      @elseif($qm=='Q2')
                          <th  colspan="{{(count($materias)*5)+2}}" style="text-align:center;font-size:10px;" >CUADROS DEL 2DO QUIMESTRE</th>
                      @else
                          <th  colspan="{{(count($materias)*5)+2}}" style="text-align:center;font-size:10px;" >CUADROS DEL FINALES</th>
                      @endif                      

                    </tr>
                    <tr>
                      <th>NIVEL:</th>
                      <th colspan="10" style="text-align:left;">{{$dt_enc_xls['cur'].' '.$txt_esp}}</th>
                    </tr>
                    <tr>
                      <th>JORNADA:</th>
                      <th style="text-align:left;" >{{$dt_enc_xls['jor']}}</th>
                      <th>PARALELO:</th>
                      <th style="text-align:left;" >{{$dt_enc_xls['par']}}</th>
                    </tr>
                  <colgroup>
                    <col span="2">
                    <?php $x=1;$clsh=""; ?>
                          @foreach($materias as $m)
                          <?php 
                          $x++; 
                          if($x%2==0){
                            //$clsh="bg-info";
                            $clsh="";
                          }else{
                            $clsh="";
                          }
                          ?>
                          <col span="1" class="{{$clsh}}" >
                          @endforeach  
                          <col >                  
                          <col span="3" class="bg-info">                  
                  </colgroup>
                  </table>

                  <table border="1">
                  <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Estudiante</th>
                    @foreach($materias as $m)
                    <th class="materias" colspan="5" ><span>{{$m->mtr_descripcion}}</span></th>
                    @endforeach
                    <th>Promedio</th>
                    <th>Comportamiento</th>
                  </tr>
                  <tr>
                    @foreach($materias as $m)
                    <th>P.Q</th>
                    <th>E.S</th>
                    <th>E.R</th>
                    <th>E.G</th>
                    <th>P.F</th>
                    @endforeach
                    <th></th>
                    <th></th>
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

///////*************PROMEDIO QUIMESTRAL*****************///////////
                        if($dt_enc_xls['esp']=='BGU'){

                             $tx_p1="pb".$m->mtr_id."1";
                             $tx_p2="pb".$m->mtr_id."2";
                             $tex_q1="pb".$m->mtr_id."7";
                             $nt_p1=number_format($d->$tx_p1,2);
                             $nt_p2=number_format($d->$tx_p2,2);
                             $ex_q1=number_format($d->$tex_q1,2);
                             $prm80=(($nt_p1+$nt_p2)/2)*0.8;
                             $prfq1=number_format($prm80+($ex_q1*0.2),2);

                             $tx_p3="pb".$m->mtr_id."3";
                             $tx_p4="pb".$m->mtr_id."4";
                             $tex_q2="pb".$m->mtr_id."8";
                             $nt_p3=number_format($d->$tx_p3,2);
                             $nt_p4=number_format($d->$tx_p4,2);
                             $ex_q2=number_format($d->$tex_q2,2);
                             $prm80=(($nt_p3+$nt_p4)/2)*0.8;
                             $prfq2=number_format($prm80+($ex_q2*0.2),2);

                        }else{

                         $tx_p1="pb".$m->mtr_id."1";
                         $tx_p2="pb".$m->mtr_id."2";
                         $tx_p3="pb".$m->mtr_id."3";
                         $tex_q1="pb".$m->mtr_id."7";
                         $nt_p1=number_format($d->$tx_p1,2);
                         $nt_p2=number_format($d->$tx_p2,2);
                         $nt_p3=number_format($d->$tx_p3,2);
                         $ex_q1=number_format($d->$tex_q1,2);

                         $prm80=(($nt_p1+$nt_p2+$nt_p3)/3)*0.8;
                         $prfq1=number_format($prm80+(($ex_q1)*0.2),2);


                         $tx_p1="pb".$m->mtr_id."4";
                         $tx_p2="pb".$m->mtr_id."5";
                         $tx_p3="pb".$m->mtr_id."6";
                         $tex_q1="pb".$m->mtr_id."8";
                         $nt_p1=number_format($d->$tx_p1,2);
                         $nt_p2=number_format($d->$tx_p2,2);
                         $nt_p3=number_format($d->$tx_p3,2);
                         $ex_q1=number_format($d->$tex_q1,2);

                         $prm80=(($nt_p1+$nt_p2+$nt_p3)/3)*0.8;
                         $prfq2=number_format($prm80+(($ex_q1)*0.2),2);
                        }

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
                                       $prm_final=7;
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


                        ?>
                        <td class="{{$cls_prmq}}" style="text-align:right;" >{{$prmq}}</td>
                        <td class="{{$cls_exs}}" style="text-align:right;" >{{$nt_exs}}</td>  
                        <td class="{{$cls_exr}}" style="text-align:right;" >{{$nt_exr}}</td>  
                        <td class="{{$cls_exg}}" style="text-align:right;" >{{$nt_exg}}</td>  
                        <td class="{{$cls_prmfin}}" style="text-align:right;" >{{$prm_final}}</td>  

                        @endforeach
                        <?php
                        $prm_tot_est=number_format( ($prm_est)/count($materias),3 );
                        $prm_tot_est=substr($prm_tot_est,0,-1);

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
                        <td>{{$prom_cinsp}}</td>
                  </tr>
                  @endforeach
              </table> 
<br>
                  <table>
                    <tr>
                      <td colspan="5" style="text-align:center; ">ALEJANDRO CAISATOA CASAMEN</td>
                      <td colspan="3"></td>
                      <td colspan="5" style="text-align:center; ">LUCIA COLLAGUAZO CAMPAÑA</td>
                    </tr>
                    <tr>
                      <td colspan="5" style="text-align:center; ">RECTOR</td>
                      <td colspan="3"></td>
                      <td colspan="5" style="text-align:center; ">SECRETARIA</td>
                    </tr>
                  </table>

