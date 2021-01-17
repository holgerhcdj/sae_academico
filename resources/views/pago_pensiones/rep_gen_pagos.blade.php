<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <style>
body { width: 8.5in;
    /* height: 11in */
    }
.cont_table{
    margin-top:-50px; 
    /* height: 11in; */
}
table tbody td{
    font-size:10px;
}
table tbody tr{
    height:10px; 
}

.pagos{
    width:25px; 
    text-align:right;
}
/* cuando vayamos a imprimir ... */
@media print{
    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
</style>    
</head>
<body>
    <span><img width="50px" src="{{ asset('img/logo_institucional_sae.png') }}"></span>
        <header>
            <h3>REPORTE GENERAL DE PAGOS : {{$datos[0].'/'.$datos[1].'/'.$datos[2].' ('.$datos[3].')'}}</h3>
            <label style="font-size:10px; "><?php echo "Fecha Impresión: ".date("d-m-Y H:i")?></label>
        </header>

    <div class="cont_table">
                 <table class="table">
                        <thead>
                            <tr>
                                <th style="width:10px">No</th>
                                <th style="width:250px " >Estudiante</th>
                                @foreach($txhead as $t)
                                    <th>{{$t}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <?php $x=1;?>
                            @foreach($data as $d)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$d->est}}</td>
                                @foreach($txhead as $t)
                                <?php 
                                    $h=strtolower($t);
                                    if(   ($h=='mat' && $d->$h>0)
                                        ||($h=='sep' && $d->$h>0)
                                        ||($h=='oct' && $d->$h>0)
                                        ||($h=='nov' && $d->$h>0)
                                        ||($h=='dic' && $d->$h>0)
                                        ||($h=='ene' && $d->$h>0)
                                        ||($h=='feb' && $d->$h>0)
                                        ||($h=='mar' && $d->$h>0)
                                        ||($h=='abr' && $d->$h>0)
                                        ||($h=='may' && $d->$h>0)
                                        ||($h=='jun' && $d->$h>0)
                                        ||($h=='jul' && $d->$h>0)
                                        ||($h=='ago' && $d->$h>0)
                                        ){
                                        //$Pag="&#10004;";
                                        $txt_h="&#10004;";
                                    }else{
                                        if($d->$h==1){
                                            $txt_h='-';
                                        }else{
                                            $txt_h=$d->$h;
                                        }
                                    } 

                                ?>
                                    <td style="text-align:right; ">{{$txt_h}}</td>
                                @endforeach
                            </tr>
                            @endforeach                   
                        </tbody>
                    </table>   
    </div>
</body>
</html>
