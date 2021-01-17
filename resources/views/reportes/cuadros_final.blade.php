                <table class="table table-hover" id="tbl_datos" style="width:auto; ">
                    <tr>
                      <th class="text-center" colspan="{{(count($materias)*6)+2}}">UNIDAD EDUCATIVA TÉCNICA VIDA NUEVA</th>
                    </tr>
                    <tr>
                      <th class="" colspan="{{(count($materias)*6)+2}}">REPORTE DE NOTAS POR FIGURA PROFESIONAL CUADRO FINAL</th>
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


                             $prmfinal=number_format( ($prfq1+$prfq2)/2,3);
                             $prmfinal=substr($prmfinal,0,-1);

                             //$prmfinal=number_format( truncar(($prfq1+$prfq2)/2,2),2);
                             // $prmfinal=truncar( ($prfq1+$prfq2)/2,3 ) ;
                             // $prmfinal=number_format($prmfinal,2);

                           $cls_prmfinal="";
                            if($prmfinal==0){
                              $prmfinal='-';
                            }elseif($prmfinal>=5 && $prmfinal<7){
                              $cls_prmfinal="cls_supl";
                            }elseif($prmfinal>0 && $prmfinal<5){
                              $cls_prmfinal="cls_rem";
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

                            $prm_est+=$prmfinal;

                            $prm_disc_mat.=$prom_c;

                        ?>
                        <td class="{{ $cls_prmfinal }}"  >
                          <span class="btn_prom "  >
                             {{$prmfinal}}
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
                        <td class="{{$cls_prm_tot_est}}">{{$prm_tot_est}} </td>
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