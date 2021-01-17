<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>

<script>
  $(function() {
    var datos=$("select[name=jor_id] option:selected").text()+' - '+$("select[name=esp_id] option:selected").text()+' - '+$("input[name=fecha]").val();
    $("#datos_tbl").text(datos);
  })
</script>

<style>
    table { font-size: 75%; table-layout: fixed; width: 100%; }
    table { border-collapse: collapse; border-spacing: 0px; }
    th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
    th, td { border-radius: 0.25em; border-style: solid; }
    th { background: #EEE; border-color: #BBB; }
    td { border-color: #DDD; }

    html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
    html { background: #999; cursor: default; }
    body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
    body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* cuando vayamos a imprimir ... */
@media print{
  *{ -webkit-print-color-adjust: exact; }
  html{ background: none; padding: 0; }
  body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
/*.txt_notas{
  width:30px; 
  border:none;
text-align:center; */
}

#datos_tbl{
  padding-bottom:5px;
  font-weight:bolder;
  font-size:18px;    

}
#header{
  text-align:center;
  padding-bottom:5px;
  font-weight:bolder;
  font-size:20px;    

}
#logo_colegio{
  position:absolute; 
  right:50px; 
  top:60px; 
  width:60px; 
}
#impreso{
  font-size:10px; 
  float:right;
  margin-right:15px; 
}
</style>
<div id="header">
  REPORTE GENERAL DE ASISTENCIAS
  <img src="{{asset('img/colegio.png')}}" id="logo_colegio">
  <span id="impreso">{{'Impreso:'.date('Y-m-d H:s')}}</span>
</div>
<div id="datos_tbl">
  
</div>
<div hidden >
  {!! $dt['datos_tbl'] !!}
</div>
<table>
{!! $dt['datos'] !!}
</table>

<div style="font-weight:bolder;font-size:18px;background:#eee;padding:5px;color:#D19B0A " >{!! $dt['dt_est'] !!}</div>
<div style="background:#eee;padding:5px;color:#107702  ">{!! $dt['dt_ast'] !!}</div>
<div style="background:#eee;padding:5px;color:brown  ">{!! $dt['dt_flt'] !!}</div>
<div style="background:#eee;padding:5px;color:#8A7F04  ">{!! $dt['dt_atr'] !!}</div>