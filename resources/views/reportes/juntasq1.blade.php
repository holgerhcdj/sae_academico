<?php
if(isset($dtx)){
  ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <style>
      .rpt_ind{
        text-decoration:none;
        color:black;  
      }
      .tx_est      
    </style>
</head>
<body>
    <div style="width:100%;text-align:right;">
       <img src="img/colegio.png" alt="" width="50px;" class="img">
    </div>
<table>
  {!!$dtx!!}
</table>

    </div>
</body>
</html>
<?php

}else{

  ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <style>

*{
  border: 0;
  box-sizing: content-box;
  color: inherit;
  font-family: inherit;
  font-size: inherit;
  font-style: inherit;
  font-weight: inherit;
  line-height: inherit;
  list-style: none;
  margin: 0;
  padding: 0;
  text-decoration: none;
  vertical-align: top;
}

table { width:auto; }
table { border-collapse: collapse; border-spacing: 0px; }

/* page */
html { font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; overflow: auto; padding: 0.2in; }
html { background: #999; cursor: default; }
body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding:0.5in 0.1in 0.1in 0.1in;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }


body { min-width: 29.0cm;
      min-height:21cm; 
     font-family:'Arial';   
    }
table{
    margin-top:-35px; 
}  
table th{
    font-weight:bolder; 
    font-size:11px;
    border:solid 1px #ccc;  
}
table tr td{
    background:#fff;
    border:none; 
    border:solid 1px #ccc;
    font-size:11px;   
}
.t1{
   font-size:18px;  
   text-align:center;
font-weight:bolder; 
}
.t2{
   font-size:15px;  
     text-align:left;
font-weight:bolder;      
}
.nota{
    text-align:right;
    width:30px;
    padding:3px;  
}
.num{
    width:10px;
}
.rpt_ind{
text-decoration:none;
color:black;  
}
.enc_titulo th{
background:#eee;
color:black;  
font-weight:bolder;
border:solid 1px #ccc; 
padding:5px; 
}
.bg-green{
  background:green;
  color:white;
  text-align:center;   
}
.bg-red{
  background:brown;
  color:white; 
  text-align:center;  
}
.img{
    margin-top:-45px;

}
.nota_baja{
    color:brown; 
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
    <div style="width:100%;text-align:right;">
       <img src="img/colegio.png" alt="" width="50px;" class="img">
    </div>
<table>
  {!!$dt!!}
</table>

    </div>
</body>
</html>


  <?php
}
?>



