<?php
//$filename = 'Q1-'.$dt_enc_xls['jor'].'-'.str_replace(' ', '',$dt_enc_xls['esp']).'-'.$dt_enc_xls['cur'].'-'.$dt_enc_xls['par'].".xls";
$filename = 'Reporte_cumplimineto'.date('Y/m/d').'.xls';
header("Pragma: public");
header("Expires: 0");
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
<head>
  <meta charset="UTF-8">
</head>

<style>
  .xlprogress{
    width:150px; 
  }
  .xlprogress-bar-success{
    background:#5cb85c; 
  }
  .xlprogress-bar-warning{
    background:#F0D74E; 
  }
  .xlprogress-bar-danger{
    background:#E90F09; 
  }
  .text-right{
    text-align:right; 
  }
  img{
    position:absolute;
    margin-left:10px;  
    margin-top:5px;  
  }
</style>

<img src="{{asset('img/escudo50px.png')}}"  >
                <table class="table" border="1">
                  <tr>
                    <th colspan="5" class="head">UNIDAD EDUCATIVA TÉCNICA VIDA NUEVA</th>
                  </tr>
                  <tr>
                    <th colspan="5" class="head">Reporte de cumplimiento de Tareas/Docente </th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Profesor</th>
                    <th>Tar.Enviadas</th>
                    <th>Tar.Cumplidas</th>
                    <th>%</th>
                  </tr>
                  <tbody>
                    {!!$rst!!}
                  </tbody>

                </table>
