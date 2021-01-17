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
    <style>
            #tbl_reporte td{
/*                padding:2px;
                text-align:center;
                border-bottom:solid 1px #ccc;   
                font-weight:100; 
*/
                font-size:10px; 
                font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial;
            }
            .falta{
                color:brown;
                font-weight:bolder;  
            }
            .atraso{
                color:#B0B009; 
                font-weight:bolder;  

            }
            .falta_justificada{
                color:#4B9CE7;
                font-weight:bolder;
            }            
            .asistencia{
                color:#049028; 
            }
            .weekend{
                background:#eee; 
                color:#A6A6A6; 
            }

    </style>

                            <table  id="tbl_reporte">
                                <tr>
                                    <th colspan="{{count($f_head)+8}}" style="text-align:center;font-weight:bolder;">REPORTE DE ASISTENCIAS</th>
                                </tr>
                                <tr>
                                    <th colspan="{{count($f_head)+8}}" style="text-align:left;font-weight:bolder;  ">{{$datos.'              Del: '.$dt['desde'].'  Al: '.$dt['hasta']}}</th>
                                </tr>
                                <tr>
                                    <th style="width:5px;">#</th>
                                    <th style="width:40px; ">Estudiante</th>
                                    @foreach($f_head as $fh)
                                    <?php
                                    $d=get_nombre_dia($fh->f);
                                    $cl='';
                                    if($d=='Do' || $d=='Sa'){
                                        $cl='weekend ';
                                    }
                                    ?>
                                    <th class="{{$cl}}" style="width:8px; "  >{{substr($fh->f,5,5)}}</th>
                                    @endforeach    
                                    <th style="background:#6FEF93;width:5px;text-align:center; " colspan="2"><span >Asistencias</span></th>
                                    <th style="background:#E1D465;width:5px;text-align:center; " colspan="2"><span >Atrasos</span></th>
                                    <th class="" style="background:#4B9CE7;padding:5px;   text-align:center;color:#fff  " colspan="2"><span class="">Faltas_J</span></th>
                                    <th class="" style="background:#C44444;padding:5px;   text-align:center;color:#fff  " colspan="2"><span class="">Faltas_I</span></th>

                                </tr>
                                <tbody id="tbdy_detalle">
                                <?php $x=1;?>
                                @foreach($est as $e)
                                <tr>
                                    <td>{{$x++}}</td>
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

                                    ?>
                                    <td ><span class="{{$cl}}" style="text-align:center; " >{{$ast}}</span></td>
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
