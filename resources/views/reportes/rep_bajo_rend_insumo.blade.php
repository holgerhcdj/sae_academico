<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <style>
body { 
     width: 8.3in; 
     min-height: 11.7in;
     font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;   
     font-size:10px;           
    }
table{
    margin-left:-25px; 
}  

table th{
        border:solid 1px;  
}
table tr{
        border-bottom:solid 1px;  
}
.cls_nota{
    text-align:right; 
}
.warning{
   background:yellow;  
}
.danger{
  background:red;   
}
.sin_nota{
  background:#ccc;   
}
.foot i{
    margin-left:15px; 
    font-weight:bolder; 
}
/* cuando vayamos a imprimir ... */
@media print{
    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
</style>
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>    
<script>
</script>   
</head>
<body>
    <img style="width:50px;margin-top:-45px;margin-left:-45px;  " src="{{asset('img/colegio.png')}}" alt="">
    <div style="margin-top:-45px;">
        <div style="width:100%;text-align:right; ">{{'Impreso:'.date('Y-m-d H:s') }}</div>
        <h1 style="background:{{$datos[5]}};color:white  ">REPORTE BAJO RENDIMIENTO ACADÉMICO {{$datos[4]}}</h1>
        <br>
        <span>{{$datos[0].'-'}}</span>
        <span>{{$datos[1].'-'}}</span>
        <span style="font-weight:bolder; ">PARCIAL {{$datos[2].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'}}</span>
        <span style="font-weight:bolder; ">INSUMO {{$datos[3]}}</span>
        <!-- <span style="font-weight:bolder;font-size:12px;color:brown;margin-left:10%;padding:2px;">PROMEDIO:&nbsp;<i id="prom_gen"></i>   </span> -->

    </div>
    <br>
    <table border="0" >
        <tr>
            <th style="width:20px;">#</th>
            <th style="width:120px;">Materia</th>
            <th style="width:200px;">Docente</th>
            <th>Curso</th>
            <th style="width:180px;">Estudiante</th>
            <th style="width:40px;">Nota</th>
        </tr>
        <tbody>
            <?php $x=1;?>
            @if($datos[4]=='SN')
                @foreach($res as $r)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$r->materia}}</td>
                    <td>{{''}}</td>
                    <td>{{$r->curso}}</td>
                    <td>{{$r->estudiante}}</td>
                    <td>{{'SN'}}</td>
                </tr>
                @endforeach
            @else
                @foreach($res as $r)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$r->mtr_descripcion}}</td>
                    <td>{{$r->usu_apellidos.' '.$r->name}}</td>
                    <td>{{$r->cur_descripcion .' '.$r->paralelo}}</td>
                    <td>{{$r->est_apellidos.' '.$r->est_nombres}}</td>
                    <td>{{number_format($r->nota,2)}}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</body>
</html>
