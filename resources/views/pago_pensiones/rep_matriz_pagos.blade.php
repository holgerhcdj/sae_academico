<!DOCTYPE html>
<head>
    <meta charset="utf-8">
</head>
<body>
                 <table class="table">
                        <thead>
                            <tr>
                                <th >No</th>
                                <th >Estudiante</th>
                                <th >Jornada</th>
                                <th >Especialidad</th>
                                <th >Curso</th>
                                <th >Paraleo</th>
                                <th >Paraleo T</th>
                                @foreach($txhead as $t)
                                    <th>{{$t}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <?php $x=1;?>
                            @foreach($data as $d)
                            <?php
                            $datos=explode("&",$d->est);
                            ?>
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$datos[0]}}</td>
                                <td>{{$datos[1]}}</td>
                                <td>{{$datos[2]}}</td>
                                <td>{{$datos[3]}}</td>
                                <td>{{$datos[4]}}</td>
                                <td>{{$datos[5]}}</td>

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
                                    <td style="text-align:right;">{{$txt_h}}</td>
                                @endforeach
                            </tr>
                            @endforeach                   
                        </tbody>
                    </table>   
</body>
</html>
