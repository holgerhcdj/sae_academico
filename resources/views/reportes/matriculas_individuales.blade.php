<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Imprimible</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
  <style>
    /*CODIGO DE VISTA PREVIA*/
    html { overflow: auto; padding: 0.5in; }
    html { background: #999; cursor: default; }
    body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
    /*Ancho 8.27 - alto 11.69*/
    body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);width:8.27in;height:auto; }
    /*CODIGO DE IMPRESION*/
      @media all {
         .saltopagina{
          display: none;
        }
      }

      @media print{
        @page { margin: 0; }
        *{ -webkit-print-color-adjust: exact; }
        html{ background: none; padding: 0; }/*PARA QUE NO APAREZCA LA URL EN LA IMPRESION*/
        body{ box-shadow: none; margin: 0; }
        #logo_institucion{
          display:block; 
        }
        .saltopagina{
          display:block;
          page-break-before:always;
        }
      }     
/*CODIGO PROPIO DEL DOCUMENTO*/
    *{
      font-family:'Times';
     }
    #logo_mineduc{
      width:300px; 
    }
   #footer{
    font-size:10px; 
    text-align:center;  
   }
  
   #header_principal{
    /*font-size:9px;  */
   }
   #header_secondary{
    /*font-size:10px;  */
   }
   th,td{
    padding:3px 2px 3px 8px ; 
   }

  </style>


</head> 
<body>

@foreach($lista as $l)

  <br>
                  <img src="http://181.211.10.10/img/logo_mineduc.png" alt="logo mineduc" id="logo_mineduc" >
                  <div id="header_principal" style="margin-top:10px ">
                    <h4 style="text-align:center;margin-top:0px ">{{$conf['institucion']}}</h4>
                    <h4 style="text-align:center;margin-top:0px ">QUITO - ECUADOR</h4>
                    <h4 style="text-align:center;margin-top:-20px ">Régimen Sierra</h4>
                    <h4 style="text-align:center;margin-top:0px ">AÑO LECTIVO: {{$conf['anio_lectivo']}}</h4>
                    <h4 style="text-align:center;margin-top:0px ">AMIE: {{$conf['amie']}}</h4>
                    <h4 style="text-align:center;margin-top:0px ">GUAMANÍ MATUTINA</h4>
                  </div>
                  <br>
                  <h2 style="text-align:center; ">CERTIFICADO DE MATRÍCULA</h2>
                  <br>
                  <div id="header_secondary" >
                    <p>El/la Reactor/a conjuntamente con el/la secretario/a de la {{$conf['institucion']}} certifican que el(a) señor(ita):</p>
                 </div>
                 <br>
                 <div style="text-align:center;font-weight:bolder;text-align:center;width:100%;">{{$l->est_apellidos.' '.$l->est_nombres}}</div>
                 <br>

                 <p>Previo a los requisitos legales, se matriculó en:</p>
                 <br>
                 <span style="text-align:left;">CURSO:    <strong>{{$conf['curso']}}</strong></span>
                 <br>
                 <br>
                 <br>
                 <span>PARALELO: <strong>"{{$conf['paralelo']}}"</strong>  </span>
                 <br>
                 <br>
                 <div style="text-align:center; "> <span> MATRÍCULA: <strong>{{$l->mat_id}}</strong> </span> <span style="margin-left:20%"> FOLIO: <strong>{{$l->mat_folio}}</strong></span> </div>
                 <br>
                 <br>
                 <span style="float:right; ">Quito D.M. Fecha {{date('Y-m-d')}}</span>
                 <br>
                 <br>
                 <span>Así queda anotado en el libro respectivo.</span>
                 <br>
                 <br>
                 <span>Lo certifican:</span>
                 <div id="footer">
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <span style="border-top:solid 1px;">{{$conf['rector']}}</span> 
                  <span style="margin-left:28%;border-top:solid 1px;">{{$conf['secretaria']}}</span>
                  <br>
                  <span style="font-weight:bolder; ">RECTOR</span> 
                  <span style="margin-left:50%;font-weight:bolder; ">SECRETARIA</span>
                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="saltopagina"></div>

@endforeach



</body>
</html>