<!DOCTYPE html>
<head>
  <meta charset="utf-8">
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<script >
	$(function(){
		$(".tx_comprtamiento").each(function(){
			$(this).attr('disabled',true);
		})

		$(".txt_notas").each(function(){
			$(this).attr('disabled',true);
			if($(this).val()==0){
				$(this).val('');
			}
		})

	})

</script>  
  <style>
table { border-collapse: collapse; border-spacing: 0px; }
th, td { border-width: 0px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
/* page */
html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }
body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.15in;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
body { width: 8.3in;height:auto;}

/* cuando vayamos a imprimir ... */
@media print{
  *{ -webkit-print-color-adjust: exact; }
  html{ background: none; padding: 0; }
  body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
.txt_notas{
	width:30px; 
	border:none;
	text-align:center;
	background:white;  
}
.btn_descargar{
	display:none;  
}
tr{
	border:solid 1px #ccc; 
}
*{
  font-size:10px; 
}
#tbl_notas th{
 font-size:11px;
 background:#eee;
 border:solid 1px #ccc;   
}
#tbl_head tr{
	border:none; 
}
.rotate_tx{
	writing-mode: vertical-lr;
	transform: rotate(180deg);
	padding: 5px 0px 5px 0px;/*top right boottom left*/
}

</style>  
</head>
<body>
	<table border="0" style="width:92%" id="tbl_head" >
		<tr>
			<th rowspan="2" style="width:100px;text-align:center;">
				<img src="{{asset('img/colegio.png')}}" width="70px">
			</th>
			<td style="text-align:center;font-size:16px;vertical-align:bottom;" colspan="8" >UNIDAD EDUCATIVA TÉNICA VIDA NUEVA</td>
		</tr>
		<tr>
			<td style="text-align:center;vertical-align:top " colspan="8">Educación para un mundo competitivo</td>
		</tr>
		<tr>
			<td style="text-align:left;font-size:14px;font-weight:bolder;   " colspan="8">Reporte de Registro de Notas ( PARCIAL I ) / {{$doc->usu_apellidos.' '.$doc->name}} <span style="font-size:10px;position:absolute;right:0px; ">{{'Impreso:'.date('Y-m-d H:s')}}</span></td>
		</tr>
		<tr>
			<td style="font-weight:bolder;font-size:12px  " >Jornada</td>
			<td >Matutina</td>
			<td style="font-weight:bolder;font-size:12px  " >Curso:</td>
			<td > </td>
			<td style="font-weight:bolder;font-size:12px  " >Especialidad:</td>
			<td ></td>
			<td style="font-weight:bolder;font-size:12px  " >Materia/Modulo:</td>
			<td > </td>
		</tr>
	</table>

{!!$dt!!}


</body>
</html>