                <table class="table table-hover" id="tbl_datos" style="width:auto; ">
                    <tr>
                      <th class="text-center" colspan="{{(count($materias)*6)+2}}">UNIDAD EDUCATIVA TÉCNICA VIDA NUEVA</th>
                    </tr>
                    <tr>
                      @if($qm=='Q1')
                          <th class="" colspan="{{(count($materias)*6)+2}}">CUADROS DEL 1ER QUIMESTRE BGU</th>
                      @elseif($qm=='Q2')
                          <th class="" colspan="{{(count($materias)*6)+2}}">CUADROS DEL 2DO QUIMESTRE BGU</th>
                      @else
                          <th class="" colspan="{{(count($materias)*6)+2}}">CUADROS DEL FINALES</th>
                      @endif
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
                            //$clsh="bg-info";
                            $clsh="";
                          }else{
                            $clsh="";
                          }
                          ?>
                          <col span="1" class="{{$clsh}}" >
                          @endforeach  
                          <col class="bg-success">                  
                          <col span="3" class="bg-info">                  
                  </colgroup>
                  <tr>
                    <th colspan="2">Estudiante</th>
                    @foreach($materias as $m)
                    <th colspan="1" class="text-center cls_materias" data="{{$m->mtr_id}}" >{{$m->mtr_descripcion}}</th>
                    @endforeach
                    <th>PROM</th>
                    <th colspan="1">Comportamiento</th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th style="color:#fff;" >--------------------------------------------------------</th>
                    @foreach($materias as $m)
                    <th>...</th>
                    @endforeach
                    <th>...</th>
                    <th>...</th>
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

                             if($ep==7){


                                     $tx_p1="pb".$m->mtr_id."1";
                                     $tx_p2="pb".$m->mtr_id."2";
                                     $tex_q1="pb".$m->mtr_id."7";
                                     $nt_p1=number_format($d->$tx_p1,2);
                                     $nt_p2=number_format($d->$tx_p2,2);
                                     $ex_q1=number_format($d->$tex_q1,2);

                                     $prm80=(($nt_p1+$nt_p2)/2)*0.8;
                                     $aux_prfq1=number_format($prm80+(($ex_q1)*0.2),2);

                                     $tx_p1="pb".$m->mtr_id."3";
                                     $tx_p2="pb".$m->mtr_id."4";
                                     $tex_q1="pb".$m->mtr_id."8";
                                     $nt_p1=number_format($d->$tx_p1,2);
                                     $nt_p2=number_format($d->$tx_p2,2);
                                     $ex_q1=number_format($d->$tex_q1,2);

                                     $prm80=(($nt_p1+$nt_p2)/2)*0.8;
                                     $aux_prfq2=number_format($prm80+(($ex_q1)*0.2),2);


                                     if($qm=='Q1'){
                                       $prfq1=$aux_prfq1;
                                     }elseif($qm=='Q2'){
                                       $prfq1=$aux_prfq2;
                                     }elseif($qm=='FIN'){
                                       $prfq1=number_format((($aux_prfq1+$aux_prfq2)/2),3);
                                       $prfq1=substr($prfq1,0,-1);

                                     }


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
                                     $aux_prfq1=number_format($prm80+(($ex_q1)*0.2),2);


                                     $tx_p1="pb".$m->mtr_id."4";
                                     $tx_p2="pb".$m->mtr_id."5";
                                     $tx_p3="pb".$m->mtr_id."6";
                                     $tex_q1="pb".$m->mtr_id."8";
                                     $nt_p1=number_format($d->$tx_p1,2);
                                     $nt_p2=number_format($d->$tx_p2,2);
                                     $nt_p3=number_format($d->$tx_p3,2);
                                     $ex_q1=number_format($d->$tex_q1,2);

                                     $prm80=(($nt_p1+$nt_p2+$nt_p3)/3)*0.8;
                                     $aux_prfq2=number_format($prm80+(($ex_q1)*0.2),2);


                                     if($qm=='Q1'){
                                       $prfq1=$aux_prfq1;
                                     }elseif($qm=='Q2'){
                                       $prfq1=$aux_prfq2;
                                     }elseif($qm=='FIN'){
                                       $prfq1=number_format((($aux_prfq1+$aux_prfq2)/2),3);
                                       $prfq1=substr($prfq1,0,-1);
                                    }


                           }

                            $cls_prfq1="";
                            if($prfq1==0){
                              $prfq1='-';
                            }elseif($prfq1>=5 && $prfq1<7){
                              $cls_prfq1="cls_supl";
                            }elseif($prfq1>0 && $prfq1<5){
                              $cls_prfq1="cls_rem";
                            }
                            
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

                            $prm_est+=$prfq1;

                            $prm_disc_mat.=$prom_c;

                        ?>
                        <td class="{{$cls_prfq1}}"  >
                          <span class="btn_prom {{'prom'.$m->mtr_id}}"  >
                             {{$prfq1}}
                          </span>
                        </td>
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