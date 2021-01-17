<style>

html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
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
    td{
        font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;       
        font-size:11px;
        border-bottom:dashed 1px #ccc;  
    }
    th{
        font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;       
        font-size:12px; 
        border-bottom:dashed 1px #ccc;  
    }

@media all {
   .saltopagina{
      display: none;
   }
}
   
@media print{

    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }

   .saltopagina{
      display:block;
      page-break-before:always;
   }
}     
@page { margin:1;}
</style>

{!! htmlspecialchars_decode($result) !!}