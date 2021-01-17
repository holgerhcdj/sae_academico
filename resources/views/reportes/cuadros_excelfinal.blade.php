<?php
//dd('okk');
if($op==2){
 $filename = "Cuadro_Final.xls";
  header("Pragma: public");
  header("Expires: 0");
  header("Content-type: application/vnd.ms-excel; name='excel'");
  header("Content-Disposition: attachment; filename=$filename");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
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



function promedio_proyectos_escolares($prom){
  $eqv="-";

  if($prom>=9 && $prom<=10){
    $eqv="EX";
  }
  if($prom>=8 && $prom<9){
    $eqv="MB";
  }
  if($prom>=7 && $prom<8){
    $eqv="B";
  }
  if($prom>0 && $prom<7){
    $eqv="B";
    //$eqv="R";///REVISAR DESDE LAS NOTAS CORRECTAS
  }
  return $eqv;
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

/*  html { overflow: auto; padding: 0.5in; }
    html { background: #999; cursor: default; }
    body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
    body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);width:11.26in;height:auto; }
*/

    /*CODIGO DE IMPRESION*/

      @media print{
        @page { margin: 0; }
        *{ -webkit-print-color-adjust: exact; }
        html{ background: none; padding: 0; }/*PARA QUE NO APAREZCA LA URL EN LA IMPRESION*/
        body{ box-shadow: none; margin: 0; }
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
      width:280px;
    }
    #logo_institucion{
      position:absolute;
      width:60px;
      right:20%;
    }
    .materias{
      /*width:25px; */
    }
    .materias span{
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      height:70px;
      font-weight:bolder;
    }
    #tbl_datos th, #tbl_datos td{
      font-size:7px;
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
    font-size:6px;
   }
   #footer{
    font-size:7px;
    text-align:center;
   }
   #header_principal{
    font-size:9px;
   }
   #header_secondary{
    font-size:8px;
   }


.rotated-when-printed {
  /*
    -moz-transform:rotate(90deg);
    -webkit-transform:rotate(90deg);
    -o-transform:rotate(90deg);
*//*    filter:DXImageTransform.Microsoft.Matrix(sizingMethod='auto expand',M11=6.123233995736766e-17,M12=-1,M21=1,M22=6.123233995736766e-17) */

}

  </style>
</head>
<body>
<div class="rotated-when-printed">

    <img src="http://181.211.10.10/img/logo_mineduc.png" alt="logo mineduc" id="logo_mineduc" >
    <br>
  @if($cur==6)

    <div id="header_principal">
      <h4 style="text-align:center;margin-top:0px ">COORDINACIÓN ZONAL 9</h4>
      <h4 style="text-align:center;margin-top:-10px ">{{$conf['distrito']}}</h4>
      <h4 style="text-align:center;margin-top:-10px ">{{$conf['institucion'].' '.$conf['amie']}}</h4>
      <h4 style="text-align:center;margin-top:-10px ">CUADRO FINAL DE CALIFICACIONES {{$tx_tipo_cuadro}}</h4>
      <h4 style="text-align:center;margin-top:-10px ">{{'AÑO LECTIVO '.$conf['anio_lectivo']}}</h4>
      <h4 style="text-align:center;margin-top:-10px ">RÉGIMEN SIERRA</h4>
    </div>

    <div id="header_secondary" >
      <table style="width:100% " >
        <tr> <th class="th_head" colspan="10">TÍTULO:</th><td>{{$conf['titulo']}}</td> <th class="th_head" colspan="6">CURSO:</th><td colspan="6">{{$conf['curso']}}</td> </tr>
         <tr><th class="th_head" colspan="10">TIPO DE TÍTULO:</th><td>BACHILLER</td>  <th class="th_head" colspan="6">PARALELO:</th><td colspan="6">{{$conf['paralelo']}}</td>  </tr>
        <tr><th class="th_head" colspan="10">ESPECIALIDAD:</th><td>{{$conf['esp_descripcion_general']}}</td> <th class="th_head" colspan="6">JORNADA:</th><td colspan="6">{{$conf['jornada']}}</td> </tr>
      </table>
    </div>

@else
    <div id="header_principal">
            <h4 style="text-align:center;margin-top:-12px ">COORDINACIÓN ZONAL 9</h4>
            <h4 style="text-align:center;margin-top:-12px ">{{$conf['distrito']}}</h4>
            <h4 style="text-align:center;margin-top:-12px ">{{$conf['institucion']}} - {{$conf['amie']}}</h4>
            <h4 style="text-align:center;margin-top:-12px ">AÑO LECTIVO {{$conf['anio_lectivo']}}</h4>
            <h4 style="text-align:center;margin-top:-12px ">CUADROS FINAL DE CALIFICACIONES</h4>
            @if($cur<4)
               <h5 style="text-align:left;width:75%">NIVEL: {{$conf['curso']}} <i style="width:250px;color:white   ">------------------------------------------</i> Paralelo: '{{$conf['paralelo']}}'  </h5>
            @else
               <h5 style="text-align:left;width:75%">NIVEL: {{$conf['curso'].' '.$conf['titulo'].' EN '.$conf['esp_descripcion_general']}} <i style="width:250px;color:white   ">------------------------------------------</i> Paralelo: '{{$conf['paralelo']}}'  </h5>
            @endif
            <h5 style="text-align:left;margin-top:-12px ">JORNADA: {{$conf['jornada']}} </h5>
    </div>
@endif


                  <table id="tbl_datos" >
                    <colgroup>
                      <col span='2'  ></col>
                      <?php $xcol=0;?>
                      @foreach($materias as $m)
                        @if($xcol%2==0)
                          <col span="{{$colspan_materias}}" style="background:#eee" ></col>
                        @else
                          <col span="{{$colspan_materias}}" style="background:white" ></col>
                        @endif
                        <?php $xcol++; ?>
                      @endforeach
                    </colgroup>

                  <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">APELLIDOS Y NOMBRES</th>
                    @foreach($materias as $m)
                    <th class="materias" colspan="{{$colspan_materias}}" ><span>{{$m->mtr_descripcion}}</span></th>
                    @endforeach

                    @if($cur<4)
                    <th rowspan="2" class="materias" style="width:30px; " ><span> PROYECTOS EDUCATIVOS </span></th>
                    @endif

                    <th rowspan="2" class="materias" style="width:15px "><span>PROMEDIO</span></th>
                    <th rowspan="2" class="materias" style="width:15px "><span>COMPORTAMIENTO</span></th>
                    <th rowspan="2"><span>OBSERVACIONES</span></th>
                  </tr>

                  <tr>
                    @foreach($materias as $m)
                    <th>P.Q</th>
                    <th>E.S</th>
                    @if($quim=='FINR')
                    <th>E.R</th>
                    @endif

                    @if($quim=='FING')
                    <th>E.R</th>
                    <th>E.G</th>
                    @endif

                    <th>P.F</th>
                    @endforeach
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
                             $nt_exs==0?$nt_exs=null:$nt_exs=$nt_exs;

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

                             /////***********DEPENDE DE LA NOTA REMEDIAL O GRACIA **************/////
                             $obs_nota="Aprobado";
                             if($prm_final<7){
                               $obs_nota="Examen Remedial";
                             }

                             if($quim=='FINR' && $prm_final<7){
                               $obs_nota="Examen Gracia";
                             }

                             if($quim=='FING' && $prm_final<7){
                               $obs_nota="Pierde el año";
                             }

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
                        @if($dt_est[2]==2) <!-- SI SE HA RETIRADO EL ESTUDIANTE -->

                            <td style="text-align:center;" >-</td>
                            <td style="text-align:center;" >-</td>
                            @if($quim=='FINR')
                            <td style="text-align:center;" >-</td>
                            @endif

                            @if($quim=='FING')
                                <td style="text-align:center;" >-</td>
                                <td style="text-align:center;" >-</td>
                            @endif
                            <td style="text-align:center;" >-</td>

                        @else
                            <td class="{{$cls_prmq}}" style="text-align:center;" >{{$prmq}}</td>
                            <td class="{{$cls_exs}}" style="text-align:center;" >{{$nt_exs}}</td>
                            @if($quim=='FINR')
                            <td class="{{$cls_exr}}" style="text-align:center;" >{{$nt_exr}}</td>
                            @endif
                            @if($quim=='FING')
                                <td class="{{$cls_exr}}" style="text-align:center;" >{{$nt_exr}}</td>
                                <td class="{{$cls_exg}}" style="text-align:center;" >{{$nt_exg}}</td>
                            @endif
                            <td class="{{$cls_prmfin}}" style="text-align:center;" >{{$prm_final}}</td>
                        @endif

                        @endforeach
                        <?php

                        $prm_tot_est=number_format(($prm_est)/count($materias),3);
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

                            $prom_proyectos_escolares=promedio_proyectos_escolares($prm_tot_est);

                        ?>
                        @if($dt_est[2]==2) <!-- SI SE HA RETIRADO EL ESTUDIANTE -->
                              @if($cur<4)
                              <td style="text-align:center;">-</td>
                              @endif
                        <td style="text-align:center;">-</td>
                        <td style="text-align:center;">-</td>
                        @else
                              @if($cur<4)
                              <td style="text-align:center;">{{$prom_proyectos_escolares}}</td>
                              @endif
                        <td style="text-align:center;" class="{{$cls_prm_tot_est}}">{{$prm_tot_est}}</td>
                        @endif
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
                            //$prom_cinsp_fin=calcula_comportamiento_q1($prm_disc_mat,$prom_cinsp,'A');///REVISAR EL PROMEDIO DE COMPORTYAMIENTO ENTRE INSPECCION Y MATERIAS
                            ///ojo este codigo no vale se debe revisar
                            $prm_tot_est>=8?$aux_comp='A':$aux_comp='B';
                            $prom_cinsp_fin=calcula_comportamiento_q1('B',$aux_comp,'A');///REVISAR EL PROMEDIO DE COMPORTYAMIENTO ENTRE INSPECCION Y MATERIAS


                        ?>
                        @if($dt_est[2]==2) <!-- SI SE HA RETIRADO EL ESTUDIANTE -->
                          <td>RETIRADO: {{$dt_est[3]}}</td>
                        @else
                           <td style="text-align:center;">{{$prom_cinsp_fin}}</td>
                          <td style="text-align:center;">{{$obs_nota}}</td>
                        @endif

                  </tr>
                  @endforeach
              </table>
    <br>

@if($cur==6)
    <div id="footer">
    <span style="">ELABORADO POR:</span> <span style="margin-left:40%">AVALADO POR:</span>
    <br>
    <br>
    <span style="border-top:solid 1px;">{{$conf['secretaria']}}</span> <span style="margin-left:28%;border-top:solid 1px;">{{$conf['rector']}}</span>
    <br>
    <br>
    <span style="font-weight:bolder; ">SECRETARIA</span> <span style="margin-left:45%;font-weight:bolder; ">RECTOR</span>
@else
    <div id="footer">
    <br>
    <br>
    <span style="border-top:solid 1px;">{{$conf['rector']}}</span> <span style="margin-left:28%;border-top:solid 1px;">{{$conf['secretaria']}}</span>
    <br>
    <br>
    <span style="font-weight:bolder; ">RECTOR</span> <span style="margin-left:40%;font-weight:bolder; ">SECRETARIA</span>
@endif

</div>

</body>
</html>