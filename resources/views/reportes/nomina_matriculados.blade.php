<?php
if($op==1){
$filename='Reporte.xls';
header("Pragma: public");
header("Expires: 0");
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
<style>

html { overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }
body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

body { 
     width: 8.3in; 
     height:auto;
    }
    table{
       border-collapse: collapse;        
    }
.th_head{
  text-align:left; 
}
@media all {
   .saltopagina{
      display: none;
   }
}
   
@media print{

    @page { margin: 0; }
    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }
   .saltopagina{
      display:block;
      page-break-before:always;
   }
}     

    #tbl_datos th, #tbl_datos td{
      font-size:9px; 
    }

   #header_principal{
    font-size:12px;  
   }
   #header_secondary{
    font-size:9px;  
   }
   #footer{
    font-size:9px; 
    text-align:center;  
   }
</style>  
</head>
<body>
  @if($tp_cur==0)
  <!-- Basica -->
  @include('reportes.nomina_matriculados_basica')
  @elseif($tp_cur==1)
  <!-- Bachillerato 1ero y 2do -->
  @include('reportes.nomina_matriculados_bachillerato')
  @else
  <!-- Bachillerato 3ero -->
  @include('reportes.nomina_matriculados_bachillerato_tercero')
  @endif
</body>
</html>

