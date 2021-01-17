<?php
//$filename = 'Q1-'.$dt_enc_xls['jor'].'-'.str_replace(' ', '',$dt_enc_xls['esp']).'-'.$dt_enc_xls['cur'].'-'.$dt_enc_xls['par'].".xls";
$filename = 'Reporte_cumplimineto'.date('Y/m/d').'.xls';
header("Pragma: public");
header("Expires: 0");
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
<head>
  <meta charset="UTF-8">
</head>

<style>
  .xlprogress{
    width:150px; 
  }
  .xlprogress-bar-success{
    background:#5cb85c; 
  }
  .xlprogress-bar-warning{
    background:#F0D74E; 
  }
  .xlprogress-bar-danger{
    background:#E90F09; 
  }
  .text-right{
    text-align:right; 
  }
  img{
    position:absolute;
    margin-left:10px;  
    margin-top:5px;  
  }
</style>

<img src="{{asset('img/escudo50px.png')}}"  >
                <table class="table" border="1">
                  <tr>
                    <th colspan="5" class="head">UNIDAD EDUCATIVA TÉCNICA VIDA NUEVA</th>
                  </tr>
                  <tr>
                    <th colspan="5" class="head">Reporte de cumplimiento de Tareas por Curso </th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Curso</th>
                    <th>Estudiante</th>
                    <th>Cumplido</th>
                    <th>%</th>
                  </tr>
                  <tbody>

                    <?php 
                    $x=1;
                    $aux_cursos="";
                    $cump=0;
                    $ncump=0;
                    $porc=0;
                    ?>
                    @foreach($cursos as $c)
                    <tr>
                      <td>{{$x++}}</td>
                        @if($c->tar_cursos!=$aux_cursos)
                        <td class="cursos" >{{$c->tar_cursos .' '.($cump+$ncump)}}  </td>
                        <?php
                        $cump=0;
                        $ncump=0;
                        $tot=0;
                        $porc=0;
                        $aux_cursos=$c->tar_cursos;
                        ?>
                        @else
                        <td></td>
                        @endif
                      <td>{{$c->est_apellidos .' '.$c->est_nombres }}</td>
                      <td style="text-align:center; " >
                        <?php
                          if($c->tru_adjunto && $c->tru_estado==5){
                          echo 'SI';
                          $cump++;
                          }else{
                          $ncump++;
                          echo 'NO';
                          }
                          if( isset($cursos[($x-1)])){
                            if($cursos[($x-1)]->tar_cursos!=$aux_cursos){
                              $porc=number_format(($cump*100/($cump+$ncump)),2);
                            }
                          }

                          if( ($x-1)==count($cursos) ){
                              $porc=number_format(($cump*100/($cump+$ncump)),2);
                          }
                          $xlprogress="";
                          if($porc>=50 && $porc<70){
                            $xlprogress="xlprogress-bar-warning";
                          }
                          if($porc>=1 && $porc<50){
                            $xlprogress="xlprogress-bar-danger";
                          }
                          if($porc==0){
                            $porc='';
                          }
                        ?>
                      </td>
                      <td class="{{$xlprogress}}">{{$porc}}</td>
                    </tr>
                    @endforeach
                    <?php
                          $xlprogress="";
                          if($tporc>=50 && $tporc<70){
                            $xlprogress="xlprogress-bar-warning";
                          }
                          if($tporc>=1 && $tporc<50){
                            $xlprogress="xlprogress-bar-danger";
                          }
                          if($tporc==0){
                            $tporc='';
                          }
                    ?>
                    <tr>
                      <th colspan="4" style="text-align:right; ">Total %</th>
                      <th class="{{$xlprogress}}">{{$tporc}}</th>
                    </tr>

                  </tbody>


                </table>
