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
body { width:10cm;height:auto;}

/* cuando vayamos a imprimir ... */
@media print{
  *{ -webkit-print-color-adjust: exact; }
  html{ background: none; padding: 0; }
  body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}

tr{
	/* border:solid 1px #ccc;  */
}
*{
  font-size:10px; 
}

</style>  
</head>
<body>
	<table border="0" style="width:100%" >
		<tr>
			<th  colspan="2" style="text-align:center;font-size:18px; ">Ticket</th>
		</tr>
		<tr>
			<th colspan="2" ><span style="font-weight:bolder ">Numero: </span>{{$venta->fac_numero}}</th>
		</tr>
		<tr>
			<th colspan="2" ><span style="font-weight:bolder ">C.C/RUC: </span>{{$venta->cli_ced_ruc}}</th>
		</tr>
		<tr>
			<th colspan="2" ><span style="font-weight:bolder ">Clientes: </span>{{$venta->cli_apellidos.' '.$venta->cli_nombres}}</th>
		</tr>
		<tr>
			<th colspan="2" ><span style="font-weight:bolder ">Teléfono: </span>{{$venta->cli_telefono}}</th>
		</tr>
		<tr>
			<th colspan="2" ><span style="font-weight:bolder ">Email: </span>{{$venta->cli_email}}</th>
		</tr>
		<tr>
			<th colspan="2" ><span style="font-weight:bolder ">Dirección: </span>{{$venta->cli_direccion}}</th>
		</tr>

		<tr>
			<th colspan="2" style="text-align:center;font-size:14px " >{{$venta->pro_descripcion}}</th>
		</tr>
		<tr>
			<td>Tiempo:</td>
			<td style="text-align:right;width:70px ">{{$venta->dfc_cantidad.' min'}}</td>
		</tr>
		<tr>
			<td>Valor:</td>
			<td style="text-align:right">{{number_format($venta->dfc_precio_unit,2)}} $</td>
		</tr>
		<tr>
			<th style="font-size:14px" >Valor Total:</th>
			<th style="text-align:right;font-size:14px ">{{number_format($venta->dfc_precio_total,2)}} $</th>
		</tr>

	</table>

</body>
</html>