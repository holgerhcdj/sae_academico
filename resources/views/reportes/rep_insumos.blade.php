<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <style>
body { 
     width: 8.3in; 
     height: 11.7in;
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
    $(function() {
        var m7=$(".warning").length;
        var m5=$(".danger").length;
        var sn=$(".sin_nota").length;
        $("#Menores7").text(m7);
        $("#Menores5").text(m5);
        $("#sin_nota").text(sn);

        var sum=0;
        var t=$(".cls_nota").length;
        $(".cls_nota").each(function(){
            if($(this).text()!='-'){
                sum=sum+parseFloat($(this).text());
            }

        });
        $("#prom_gen").text((sum/t).toFixed(2));
        //alert(sum/t);
    })
</script>   
</head>
<body>
    <img style="width:50px;margin-top:-45px;margin-left:-45px;  " src="{{asset('img/colegio.png')}}" alt="">
    <div style="margin-top:-45px;">
        <div style="width:100%;text-align:right; ">{{'Impreso:'.date('Y-m-d H:s') }}</div>
        <h1 style="background:black;color:white  ">REPORTE DE NOTAS POR INSUMO</h1>
        <br>
        <span>{{$datos[0].'-'}}</span>
        <span>{{$datos[1].'-'}}</span>
        <span>{{$datos[2]}}</span>
        <span>{{$datos[3].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'}}</span>
        <span style="font-weight:bolder; ">PARCIAL {{$datos[4].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'}}</span>
        <span style="font-weight:bolder; ">
            INSUMO 
            @if($datos[5]==8)
            {{'5'}}            
            @elseif($datos[5]==12)
            {{'6'}}
            @else
            {{ $datos[5] }}
            @endif
                </span>
        <span style="font-weight:bolder;font-size:12px;color:brown;margin-left:10%;padding:2px;">PROMEDIO:&nbsp;<i id="prom_gen"></i>   </span>
    </div>
    <br>
<table border="0" >
    <tr>
        <th style="width:5px;">#</th>
        <th style="width:180px;">Estudiante</th>
        @foreach($materias as $m)
        <th style="border:solid 1px #000;font-size:6px;width:30px;   " >{{$m->mtr_descripcion}}</th>
        @endforeach
    </tr>
{!!$res!!}
</table>
    </div>
    <br>
<span class="foot" style="background:yellow ">Menor 7:<i id="Menores7"></i></span>
<br><br>
<span class="foot" style="background:red ">Menor 5:<i id="Menores5"></i></span>
<br><br>
<span class="foot" style="background:#ccc ">Sin Nota:<i id="sin_nota"></i></span>

</body>

</html>
