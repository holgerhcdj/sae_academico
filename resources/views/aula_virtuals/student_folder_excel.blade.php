<?php
$filename = 'TAREAS-'.$jr->jor_descripcion.'-'.str_replace(" ","",$cr->cur_descripcion).'-'.$par.'.xls';
header("Pragma: public");
header("Expires: 0");
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
 <head>
  <meta charset="UTF-8">
  <style>
    .bg-success,.alert-success{
        background:#2E800A;
        color:#fff; 
    }  
    .bg-warning,.alert-warning{
        background:#EECF71;
        color:#fff; 
    }  
    .bg-danger,.alert-danger{
        background:#BA0A0A;
        color:#fff; 
    }  
  </style>
</head> 

    <section class="content-header" style="margin-left:20%">
        <div style="font-size:25px;">UNIDAD EDUCATIVA TÉCNICA VIDA NUEVA</div>
        <div style="font-size:20px;">Reporte de Cumplimiento de Tareas Aula Virtual hasta: {{date('d/m/Y')}} </div>
        <div>{{'Jornada: '.$jr->jor_descripcion.' Especialidad: Cultural '.' Curso: '.$cr->cur_descripcion.' Paralelo: '.$par}}</div>

    </section>
    <div class="content">
        <div class="box box-primary">

        @if(isset($datos))
            <table class="table table-border" border="1">
                <tr class="bg-primary">
                    <th>#</th>
                    <th>-----------------Estudiante----------------------</th>
                        @foreach($tx_materia as $th)
                        <th>{{$th}}</th>
                        @endforeach
                        <th style="background:#2E800A;color:#fff ">&#10004;</th>
                        <th style="background:#BA0A0A;color:#fff ">&#1061;</th>
                        <th style="background:#fff;color:#000">Tot.Tareas</th>
                        <th >%Completado</th>
                </tr>
                <?php $x=1;?>
                @foreach($datos as $d)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$d->estudiante}}</td>
                    <?php $cump=0;$ncump=0?>
                    @foreach($tx_head as $th)
                    
                    <?php $nota=explode('&',$d->$th)?> 
                                @if( !empty($nota[0]) && $nota[1]==5 )
                                    <?php $cump++;?>
                                    <td style="color:#2E800A">&#10004;</td>
                                @else
                                    <?php $ncump++;?>
                                    <td>-</td>
                                @endif

                    @endforeach
                    <?php 
                        $p_co=number_format(($cump*100/($ncump+$cump)),2);
                        $p_nco=number_format(($ncump*100/($ncump+$cump)),2);
                        $tot=($ncump+$cump);
                        $cls="";
                        if($p_co>=70){
                            $cls="alert-success";
                        }
                        if($p_co>=50 && $p_co<70){
                            $cls="alert-warning";
                        }

                        if($p_co>=0 && $p_co<50){
                            $cls="alert-danger";
                        }
                    ?>

                    <td style="text-align:right;" class="bg-success">{{$cump}}</td>
                    <td style="text-align:right;" class="bg-danger">{{$ncump}}</td>
                    <td style="text-align:right;" class="bg-default">{{($ncump+$cump)}}</td>
                    <td style="text-align:right;" class="{{$cls}}">{{$p_co.' %'}}</td>
                </tr>
                @endforeach
            </table>   
        </div>
        @endif

    </div>

