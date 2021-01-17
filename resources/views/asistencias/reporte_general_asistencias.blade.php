@extends('layouts.app')

@section('content')
<?php
$desde=date('Y-m-d');
$hasta=date('Y-m-d');
if(isset($_POST['btn_buscar'])){
    $desde=$_POST['desde'];
    $hasta=$_POST['hasta'];
}

function porcentaje($a,$at,$f,$fj){
    $t=$a+$at+$f+$fj;
    if($t==0){$t=1;}//Para que no haya division para Cero 0;
    $pa=($a*100/$t);
    $pat=($at*100/$t);
    $pf=($f*100/$t);
    $pfj=($fj*100/$t);
    return [$pa,$pat,$pf,$pfj] ; 
}
function get_nombre_dia($fecha){
   $fechats = strtotime($fecha); //pasamos a timestamp
       switch (date('w', $fechats)){
        case 0: return "Do"; break;
        case 1: return "Lu"; break;
        case 2: return "Ma"; break;
        case 3: return "Mi"; break;
        case 4: return "Ju"; break;
        case 5: return "Vi"; break;
        case 6: return "Sa"; break;
    }
}

?>
    <section class="content-header">
        <h1>
            REPORTE GENERAL DE ASISTENCIAS
        </h1>
    </section>
    <style>
            .rotate_tx{
                writing-mode: vertical-lr;
                transform: rotate(180deg);
                 padding: 5px 0px 5px 0px;/*top right boottom left*/
            }     
            #tbl_reporte th{
                font-weight:100; 
            }
            #tbl_reporte td{
                padding:2px;
                text-align:center;
                border-bottom:solid 1px #ccc;   
                font-size:11px; 
                font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial;
                font-weight:100; 
            }

            #tbdy_detalle tr:hover{
                background:#A8D9EF;   
                cursor:pointer; 
            }
            .falta{
                color:brown;
                font-weight:bolder;  
            }
            .falta_justificada{
                color:#4B9CE7;
                font-weight:bolder;
            }
            .atraso{
                color:#B0B009; 
                font-weight:bolder;  

            }
            .asistencia{
                color:#049028; 
            }
            .weekend{
                background:#eee; 
                color:#A6A6A6; 
            }


            .form-group input[type="checkbox"] {
                display: none;
            }

            .form-group input[type="checkbox"] + .btn-group > label span {
                width: 20px;
            }

            .form-group input[type="checkbox"] + .btn-group > label span:first-child {
                display: none;
            }
            .form-group input[type="checkbox"] + .btn-group > label span:last-child {
                display: inline-block;   
            }

            .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
                display: inline-block;
            }
            .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
                display: none;   
            }    


    </style>

    <script>
        $(function(){
            ast=$(".asistencia").length;
            at=$(".atraso").length;
            fl=$(".falta").length;
            $("#asistentes").text(ast);
            $("#atrasados").text(at);
            $("#faltantes").text(fl);
                var cnv_ast     = $('#graf_ast').get(0).getContext('2d');
                var grf_ast    = new Chart(cnv_ast);
                var dt       = [
                {value: ast,color: '#2FA805',highlight: '#2FA805',label: 'Asistentes'},
                {value: at,color: '#E1D465',highlight: '#E1D465',label: 'Atrasados'},
                {value: fl,color: '#C44444',highlight: '#C44444',label: 'Faltantes'},
                ];
                var op     = {
                  percentageInnerCutout: 50, // This is 0 for Pie charts
                  animationSteps       : 20,
                  animationEasing      : 'linear',
                  animateRotate        : true,
                  animateScale         : true,
                  responsive           : true
               };
               grf_ast.Doughnut(dt,op);            
        })
        $(document).on("click","#fancy-checkbox-default",function(){
            if($(this).prop('checked')==true){
                $(".cls_detalle").show();
            }else{
                $(".cls_detalle").hide();

            }
        });

        $(document).on("submit","#frm_buscador",function(){
            if($('input[name=desde]').val()>$('input[name=hasta]').val()){
                Swal.fire({
                  type: 'info',
                  title: 'Fechas Incorrectas',
                  text: 'La fecha inicial no puede ser mayor que la fecha final'
              })
                return false;
            }

        });

    </script>

    <div class="content" style="margin-top:-10px;">
        <div class="box box-primary" >
            <div class="box-body" >
                <div class="container-fluid" style="margin-top:-10px;">
                    <form action="reporte_general_asistencias" method="POST" id="frm_buscador" onsubmit="return validar()">
                        {{csrf_field()}}
                    <table>
                        <tr>
                            <td>
                                {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::select('esp_id',$esp,null, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::select('cur_id',$cur,null, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::select('paralelo',[
                                'A'=>'A',
                                'B'=>'B',
                                'C'=>'C',
                                'D'=>'D',
                                'E'=>'E',
                                'F'=>'F',
                                'G'=>'G',
                                'H'=>'H',
                                'H'=>'H',
                                'I'=>'I',
                                ],null, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::date('desde',$desde, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::date('hasta',$hasta, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                <div class="[ form-group ]" style="margin-top:15px; ">
                                    <button class="btn btn-primary fa fa-search" name="btn_buscar" value="btn_buscar" style="height:34px;"> Buscar</button>
                                    <input type="checkbox" name="fancy-checkbox-default" id="fancy-checkbox-default" checked="checked" autocomplete="off" />
                                    <div class="[ btn-group ]">
                                        <label for="fancy-checkbox-default" class="[ btn btn-default ]">
                                            <span class="[ glyphicon glyphicon-ok ]"></span>
                                            <span> </span>
                                        </label>
                                        <label for="fancy-checkbox-default" class="[ btn btn-default active ]">
                                            Ver Detalle
                                        </label>
                                    </div>
                                    <button class="btn btn-success fa fa-file-excel-o" name="btn_reporte_excel" value="btn_reporte_excel" style="height:34px;"> Excel</button>
                                </div>
                            </td>
                        </tr>
                    </table> 
                    </form> 
<div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered " border="0" id="tbl_reporte">
                                <tr class="bg-info">
                                    <th>#</th>
                                    <th>Estudiante</th>
                                    @foreach($f_head as $fh)
                                    <?php
                                    $d=get_nombre_dia($fh->f);
                                    $cl='';
                                    if($d=='Do' || $d=='Sa'){
                                        $cl='weekend ';
                                    }
                                    ?>
                                    <th class="text-center cls_detalle {{$cl}}  rotate_tx"    style="width:30px; " >{{$d}}<span class="">{{substr($fh->f,0,10)}}</span></th>
                                    @endforeach    
                                    <th class="" style="background:#6FEF93;padding:5px;   text-align:center; " colspan="2"><span class="">Asist</span></th>
                                    <th class="" style="background:#E1D465;padding:5px;   text-align:center; " colspan="2"><span class="">Atrasos</span></th>
                                    <th class="" style="background:#4B9CE7;padding:5px;   text-align:center;color:#fff  " colspan="2"><span class="">Faltas_J</span></th>
                                    <th class="" style="background:#C44444;padding:5px;   text-align:center;color:#fff  " colspan="2"><span class="">Faltas_I</span></th>
                                </tr>
                                <tbody id="tbdy_detalle">
                                <?php $x=1;?>
                                @foreach($est as $e)
                                <tr>
                                    <td style="width:25px ">{{$x++}}</td>
                                    <td style="text-align:left; ">{{$e->estudiante}}</td>
                                    <?php 
                                    $c=0;
                                    $a=0;
                                    $f=0;
                                    $fj=0;
                                    $at=0;
                                    ?>
                                    @foreach($f_head as $fh)
                                    <?php
                                    $c++;
                                    $dt="f".$c;
                                    $ast='';
                                    $cl='';
                                    if($e->$dt!=null){
                                        if($e->$dt==0){
                                            $ast='&#10004;';
                                            $cl='asistencia';
                                            $a++;
                                        }

                                        if($e->$dt==1){
                                            $ast='F';
                                            $cl='falta';
                                            $f++;
                                        }
                                        if($e->$dt==2){
                                            $ast='A';
                                            $cl='atraso ';
                                            $at++;
                                        }

                                        if($e->$dt==3){
                                            $ast='FJ';
                                            $cl='falta_justificada ';
                                            $fj++;
                                        }                                        
                                    }

                                    $d=get_nombre_dia($fh->f);
                                    $col='';
                                    if($d=='Do' || $d=='Sa'){
                                        $col='weekend ';
                                    }

                                    ?>
                                    <td class="{{ $col}} cls_detalle"><span class="{{$cl}}" >{{$ast}}</span></td>
                                    @endforeach
                                    <td style="background:#21F157;" >
                                        @if($a==0)
                                        {{'-'}}
                                        @else
                                        {{$a}}
                                        @endif
                                    </td>
                                    <td style="background:#fff;" >{{ number_format(porcentaje($a,$at,$f,$fj)[0]).'%' }}</td>
                                    <td style="background:#E1D465;">
                                        @if($at==0)
                                        {{'-'}}
                                        @else
                                        {{$at}}
                                        @endif
                                    </td>
                                    <td style="background:#fff;">{{ number_format(porcentaje($a,$at,$f,$fj)[1]).'%' }} </td>
                                    <td style="background:#4B9CE7;color:#fff ">
                                        @if($fj==0)
                                        {{'-'}}
                                        @else
                                        {{$fj}}
                                        @endif
                                    </td>                                    
                                    <td style="background:#fff;">{{ number_format(porcentaje($a,$at,$f,$fj)[3]).'%' }} </td>
                                    <td style="background:#C44444;color:#fff ">
                                        @if($f==0)
                                        {{'-'}}
                                        @else
                                        {{$f}}
                                        @endif
                                    </td>
                                    <td style="background:#fff;border-right:solid 1px brown  ">{{ number_format(porcentaje($a,$at,$f,$fj)[2]).'%' }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
</div>
        <div hidden class="col-sm-3" style="border:solid 0px; ">
            <div class="chart">
                <canvas id="graf_ast" style="height:200px"></canvas>
            </div>
        </div>
        
<div hidden class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box" style="border-radius:10px;border:solid 1px green;background:#FAF8F8;">
    <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
    <div class="info-box-content">
      <span class="info-box-text" style="font-size:20px;">Asistencias</span>
      <span class="info-box-number" style="font-size:30px;" id="asistentes" >0</span>
  </div>
</div>
</div>
<div hidden class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box" style="border-radius:10px;border:solid 1px #DEBE0D;background:#FAF8F8;">
    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
    <div class="info-box-content">
      <span class="info-box-text" style="font-size:20px;">Atrasos</span>
      <span class="info-box-number" style="font-size:30px;" id="atrasados" >0</span>
  </div>
</div>
</div>
<div hidden class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box" style="border-radius:10px;border:solid 1px red;background:#FAF8F8;">
    <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
    <div class="info-box-content">
      <span class="info-box-text" style="font-size:20px;">Faltas</span>
      <span class="info-box-number" style="font-size:30px;" id="faltantes" >0</span>
  </div>
</div>
</div>


                </div>
            </div>
        </div>
    </div>
@endsection
