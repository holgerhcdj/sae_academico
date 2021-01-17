<?php
$pa=103.11;
$beca=($pa-$factura->valor);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <style>
table { border-collapse: collapse; border-spacing: 0px; }
th, td { border-width: 0px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
/* page */
html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }
body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.15in;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

body { width: 3.1in;height: 7in;}
/* cuando vayamos a imprimir ... */
@media print{
  *{ -webkit-print-color-adjust: exact; }
  html{ background: none; padding: 0; }
  body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
#tbl_head{
  margin-top:100px;
  margin-left:2px; 
}
#tbl_head td{
  font-size:12px; 
/*  letter-spacing:-1px; */
}
#tbl_detalle th,#tbl_detalle td{
  border: solid 1px;
  text-align:center; 
  font-size:12px; 
}
#tbl_detalle{
  width:100%; 
}
#tbl_foot{
  margin-top:20px;
  margin-left:10px;
  width:95%;   
}
#tbl_foot td{
  font-size:12px; 
}

*{
  font-size:10px; 
}
</style>  
</head>
<body>
<table id="tbl_head" border="0" style="width:100% ">
  <tr>
    <td style="width:20% ">Fecha:</td>
    <td>{{$factura->fecha_pago}}</td>
  </tr>
  <tr>
    <td>Cliente:</td>
    <td>{{$factura->cli_nombre}}</td>
  </tr>
  <tr>
    <td>C.C./RUC:</td>
    <td>{{$factura->cli_ruc}}</td>
  </tr>  
</table>    
<table id='tbl_foot'>
<tr>
  <th colspan="2" style="text-align:center;font-size:14px  ">
    @if($factura->descripcion==1){{'Matricula'}}@endif
    @if($factura->descripcion==2){{'Pensión Septiembre'}}@endif
    @if($factura->descripcion==3){{'Pensión Octubre'}}@endif
    @if($factura->descripcion==4){{'Pensión Noviembre'}}@endif
    @if($factura->descripcion==5){{'Pensión Diciembre'}}@endif
    @if($factura->descripcion==6){{'Pensión Enero'}}@endif
    @if($factura->descripcion==7){{'Pensión Febrero'}}@endif
    @if($factura->descripcion==8){{'Pensión Marzo'}}@endif
    @if($factura->descripcion==9){{'Pensión Abril'}}@endif
    @if($factura->descripcion==10){{'Pensión Mayo'}}@endif
    @if($factura->descripcion==11){{'Pensión Junio'}}@endif
    @if($factura->descripcion==12){{'Pensión Julio'}}@endif
    @if($factura->descripcion==13){{'Pensión Agosto'}}@endif
  </th>
</tr>
  <tr>
    <td>Pensión Autorizada:</td>
    <td style='text-align:right'>{{number_format($pa,2)}}$</td>
  </tr>
  <tr>
    <td>Beca Estudiantil:</td>
    <td style='text-align:right'>-{{number_format($beca,2)}}$</td>
  </tr>
  <tr>
    <td>Descuento pronto pago:</td>
    <td style='text-align:right'>-{{number_format($factura->valor-$factura->valor_pagado,2)}}$</td>
  </tr>
  <tr>
    <td>IVA:</td>
    <td style='text-align:right'>0.00$</td>
  </tr>
  <tr>
    <td>Total a Cancelar:</td>
    <td style='text-align:right;font-weight:bolder;'>{{number_format($factura->valor_pagado,2)}}$</td>
  </tr>
  <tr>
    <td colspan="2">{{$factura->est_apellidos.' '.$factura->est_nombres}}</td>
  </tr>
  <tr>
    <td>{{'( '.$factura->num_fact. ' )'}}</td>
  </tr>
</table>
</body>
</html>