<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
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
.meses{
    display:none; 
}
.pagos_h{
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
<script>
    $(function(){

        np=0;
        tc=0;
        np=0;
        tc=($(".cnt").length*$("#mes").val()); //TOTAL GENERAL
        tp=0;
        $(".pagos").each(function(){
             if($(this).html().trim()!='-'){
                 tp++;
             }
        });
        np=tc-tp;
        t=tp*100/tc;
        if(t>100){
            t=100;
        }
        $("#prog").val(t);
        $("#txt_prog").text(t.toFixed(2)+"%");

    })
</script>  
</head>
<body>
                {!! Form::select('mes',[
                    '9'=>'Abr',
                    '10'=>'May','11'=>'Jun','12'=>'Jul','13'=>'Ago'],null,['class'=>'form-control meses','id'=>'mes']) !!}    

    <span><img width="50px" src="{{ asset('img/logo_institucional_sae.png') }}"></span>
            <label style="font-size:10px; "><?php echo "Fecha Impresión: ".date("d-m-Y H:i")?></label>
        <header>
            <h3>REPORTE DE PAGO PENSIONES: {{ $datos[0].' / '.$datos[1].' / '.$datos[2] }}</h3>

            <label for="">
                Dirigente:
                @if(!empty($dirigente))
                {{$dirigente[0]->usu_apellidos.' '.$dirigente[0]->name}}
                @else
                {{'No Asignado'}}
                @endif
            </label>
            <progress max="100" value="" id="prog" style="margin-top:0px;"></progress>
            <b id="txt_prog"></b>

        </header>
<br>
    <div class="cont_table">
                 <table class="table">
                        <thead>
                            <tr>
                                <th style="width:15px"></th>
                                <th >Estudiante</th>
                                <th class="pagos_h">Mat</th>
                                <th class="pagos_h">Sep</th>
                                <th class="pagos_h">Oct</th>
                                <th class="pagos_h">Nov</th>
                                <th class="pagos_h">Dic</th>
                                <th class="pagos_h">Ene</th>
                                <th class="pagos_h">Feb</th>
                                <th class="pagos_h">Mar</th>
                                <th class="pagos_h">Abr</th>
                                <th class="pagos_h">May</th>
                                <th class="pagos_h">Jun</th>
                                <th class="pagos_h">Jul</th>
                                <th class="pagos_h">Ago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c=1;
                                // $Pag="<i class='fa fa-check text-success cls_chk'></i>";
                                $Pag="&#10004;";
                                $Apag="<i class='text-success cls_chk'>A</i>";
                                $fa=date("m");
                           ?>
                            @foreach($pagoPensiones as $p)
                                    <?php
                                      $dt=explode("&",$p->est);
                                    ?>
                            <tr>
                                <td class="cnt">{{$c++}}</td>
                            <td>
                                <i class="btn btn-primary btn-xs fa fa-chevron-circle-right btn_acuerdo" data='{{$dt[1]}}' data-toggle="modal" data-target="#mdl_acuerdo"  ></i>
                                {{$dt[0]}}
                            </td>
                                <td class="pagos">{!!$Pag!!}</td>
                                <td class="pagos">{!!$p->s==0?'-':'';!!} {!!$p->s==1?$Pag:'';!!} {!!$p->s==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->o==0?'-':'';!!} {!!$p->o==1?$Pag:'';!!} {!!$p->o==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->n==0?'-':'';!!} {!!$p->n==1?$Pag:'';!!} {!!$p->n==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->d==0?'-':'';!!} {!!$p->d==1?$Pag:'';!!} {!!$p->d==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->e==0?'-':'';!!} {!!$p->e==1?$Pag:'';!!} {!!$p->e==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->f==0?'-':'';!!} {!!$p->f==1?$Pag:'';!!} {!!$p->f==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->mz==0?'-':'';!!} {!!$p->mz==1?$Pag:'';!!} {!!$p->mz==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->a==0?'-':'';!!} {!!$p->a==1?$Pag:'';!!} {!!$p->a==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->my==0?'-':'';!!} {!!$p->my==1?$Pag:'';!!} {!!$p->my==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->j==0?'-':'';!!} {!!$p->j==1?$Pag:'';!!} {!!$p->j==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->jl==0?'-':'';!!} {!!$p->jl==1?$Pag:'';!!} {!!$p->jl==2?$Apag:'';!!}</td>
                                <td class="pagos">{!!$p->ag==0?'-':'';!!} {!!$p->ag==1?$Pag:'';!!} {!!$p->ag==2?$Apag:'';!!}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>   
    </div>
</body>
</html>
