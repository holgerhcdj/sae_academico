<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <style>
body { width: 21.0cm;
     height: 14.8cm; 
     font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;   
     font-size:16px;           
    }
table{
    margin-top:-35px; 
}  
table th{
        background:#fff;
        border:none; 
/*        border:solid 2px;  */
}
table tr{
        background:#fff;
        border:none; 
/*        border-bottom:solid 1px;  */
}

span{
    margin-left:5px; 
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
<table border="0" >
<tr>
    <th>
        <img src="{{asset('img/colegio.png')}}" width="80px" >    
    </th>
</tr>
<tr>
    <th colspan="4" style="font-weight:bolder;font-size:20px;text-align:center;   ">RECIBO DE AUSENCIA DE LABORES</th>
</tr>
<tr>
    <td colspan='2'>Colaborador: {{$permisosVacaciones[0]->name.' '.$permisosVacaciones[0]->usu_apellidos}} </td>
    <td colspan="2">{{$permisosVacaciones[0]->tipo==0?'Permiso':'Vacación'}}</td>
</tr>
<tr>
    <td>Desde:</td>
    <td>{{$permisosVacaciones[0]->f_desde.' '.$permisosVacaciones[0]->h_desde}}</td>
    <td>Hasta:</td>
    <td>{{$permisosVacaciones[0]->f_hasta.' '.$permisosVacaciones[0]->h_hasta}}</td>
</tr>
<tr>
    <td>Motivo:</td>
    <td>{{$permisosVacaciones[0]->motivo}}</td>
    <td>Reemplazo:</td>
    <td>{{$permisosVacaciones[0]->reemplazo}}</td>
</tr>
<tr>
    <td>Observaciones:</td>
    <td colspan="3">{{$permisosVacaciones[0]->obs}}</td>
</tr>
</table>
</body>
</html>
