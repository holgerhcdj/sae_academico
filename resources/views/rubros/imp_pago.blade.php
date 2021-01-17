<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<style>


*[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }

*[contenteditable] { cursor: pointer; }

*[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

span[contenteditable] { display: inline-block; }

/* heading */

h1 { font: bold 100% sans-serif; letter-spacing: 0em;font-size:13px;  text-align: center; text-transform: uppercase; }
h3 { font: bold 100% sans-serif; 
	text-align: center; 
	text-transform: uppercase;
	background:#000;
	color:#fff;
	padding:5px; 
	border-radius:5px; 
	}

/* table */

table { font-size: 75%; table-layout: fixed; width: 80%; }
table { border-collapse: collapse; border-spacing: 0px; }
th, td { border-width: 0px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }

/* page */
html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }
body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.15in;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */
header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { border-radius: 0.25em; margin: 0 0 1em; padding: 0.1em 0; }
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }




body { width: 3.1in;height: 7in;}


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
		<header>
			<h1 style="text-align:left;   ">{{ $rubro[0]->rub_no }}</h1>
			<h1 style="margin-top:-10px ">{{ $rubro[0]->rub_descripcion }}</h1>
			<label style="font-size:10px;margin-left:0.25in "><?php echo "Fecha Impresión: ".date("d-m-Y H:i")?></label>
		</header>

		<table style="width:90%;margin-left:0.25in" >
			<thead>
				<tr>
					<th colspan="3" style="font-weight:bolder">{{ $estudiante[0]->est_apellidos." ".$estudiante[0]->est_nombres }}</th>
				</tr>
				<tr>
					<td colspan="3" style="font-weight:bolder">
						{{$estudiante[0]->jor_descripcion.'/'.$estudiante[0]->cur_descripcion.'/'.$estudiante[0]->mat_paralelot }}
					</t>
				</tr>
				<tr>
					<td colspan="3" style="font-weight:bolder">
						{{$estudiante[0]->esp_descripcion}}
					</t>
				</tr>				
				<tr>
					<th>&nbsp;</th>
				</tr>				
				<tr>
					<th style="border-bottom:dashed 1px; ">N.pago</th>
					<th style="border-bottom:dashed 1px;text-align:center;  ">Fecha</th>
					<th style="border-bottom:dashed 1px;text-align:center;  ">Valor</th>
				</tr>
			</thead>
			<tbody>
				<?php $c=1;$tot=0;?>
				@foreach($pagos as $p)
				<?php $tot+=$p->pgr_monto;?>
					<tr>
						<td align="center">{{ $p->pgr_num }}</td>
						<td align="center">{{ $p->pgr_fecha }}</td>
						<td style="text-align:right" >{{ number_format($p->pgr_monto,2) }}</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" style="font-weight:bolder">Saldo</td>
					<td style="text-align:right;font-weight:bolder" >{{ number_format($rubro[0]->rub_valor-$tot,2) }}</td>
				</tr>
			</tfoot>
		</table>
		<div style="width:50%;margin-top:100px;margin-left:0.25in;font-family:Comic Sans " >
			Firma
		</div>
</body>
</html>
