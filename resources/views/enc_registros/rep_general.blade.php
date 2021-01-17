<!DOCTYPE html>
<head>
  <meta charset="utf-8">
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('sweetalert/dist/sweetalert2.min.css')}}">
<script src="{{asset('sweetalert/dist/sweetalert2.all.min.js')}}"></script>

<script >
  $(function(){
    // var c=0;
    // $(".porcentaje").each(function(){
    //   var gp=$(this).attr('data');
    //   var vl=$(this).attr('vl');
    //   var cnt=$(".grp_"+gp).length;
    //   var siempre=parseFloat(vl/cnt).toFixed(2);
    //   var ref=parseFloat(siempre/4);
    //   $('.siempre'+gp).attr('data',siempre);
    //   var casi_siempre=parseFloat(siempre-ref).toFixed(2);
    //   $('.casi_siempre'+gp).attr('data',casi_siempre);
    //   var ocacionalmente=parseFloat(casi_siempre-ref).toFixed(2);
    //   $('.ocacionalmente'+gp).attr('data',ocacionalmente);
    //   var a_veces=parseFloat(ocacionalmente-ref).toFixed(2);
    //   $('.a_veces'+gp).attr('data',a_veces);
    //   var nunca=parseFloat(a_veces-ref).toFixed(2);
    //   $('.nunca'+gp).attr('data',nunca);
    //   var tot=0;
    //   $(".resp"+gp).each(function(){
    //      if($(this).text().trim()=='x'){
    //        tot=parseFloat(tot)+parseFloat($(this).attr('data'));
    //      }
    //   });
    //   $(".alc"+gp).text(tot.toFixed(2)+' %');
    // })  

    // var tot_g=0;
    // $(".totales").each(function(){
    //   var vl=parseFloat($(this).text());
    //   var grp=$(this).attr('data');
    //   var us=$("#usu_id").val();
    //   tot_g=parseFloat(tot_g)+parseFloat($(this).text());

    //   token=$('input[name=_token]').val();    
    //   url=window.location;
    //   $.ajax({
    //     url: url+'/registra_totales_encuesta',
    //     headers:{'X-CSRF-TOKEN':token},
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {u:us,v:vl,g:grp},
    //     beforeSend:function(){
    //     },
    //     success:function(dt){
    //     }
    //    })
    // })
    // $("#tot_gen").text(tot_g.toFixed(2)+' %');

  })

</script>  
  <style>
table { border-collapse: collapse; border-spacing: 0px; }
th, td { border-width: 0px; padding: 0.03em; position: relative; text-align: left; }
/* page */
html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }
body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.15in;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
body { width: 8.3in;height:11.7in;}

/* cuando vayamos a imprimir ... */
@media print{
  *{ -webkit-print-color-adjust: exact; }
  html{ background: none; padding: 0; }
  body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
tr{
  border:solid 1px #ccc; 
}
*{
  font-size:10px; 
}
#tbl_dt th{
 border:solid 1px #ccc;   
}
#tbl_dt td{
 border:solid 1px #ccc;   
 text-align:center; 
}
.rotation_tx{
  writing-mode: vertical-lr;
  transform: rotate(180deg);
  padding: 5px 10px 5px 10px;/*top right boottom left*/
  text-align:center;
  vertical-align:middle;  
}

</style>  
</head>
<body>
 <table  id="tbl_dt">
    <tr>
      <th colspan="2" style="text-align:center;font-size:13px ">ENCUESTA DE CLIMA LABORAL (RESUMEN GENERAL)
      </th>
      <th rowspan="5" colspan="5">
        <img src="{{asset('img/logo_fvn.png')}}" width="100px" >
      </th>
    </tr>
    <tr>
      <th colspan="2" style="text-align:center;font-size:13px">FUNDACION VIDA NUEVA</th>
    </tr>
    <tr>
      <th colspan="2" style="text-align:center;font-size:13px">2018-2019</th>
    </tr>
    <tr>
      <th colspan="2" style="text-align:justify;">
       <span style="font-weight:bolder;">Objetivos:</span>
        Valorar la percepción de satisfacción y motivación del personal de la institución para identificar oportunidades de mejora y realizar los ajustes en la estructuctura, procesos, competencias, metas y otros necesarios, a fin de contribuir a un clima laboral óptimo, una sana convivencia armónica y una cultura de paz en la comunidad educativa.
      </th>
    </tr>
    <tr>
      <th colspan="2" style="text-align:left;">
        <span style="font-weight:bolder;">Alcance:</span>
        Todo el personal de la Fundación Vida Nueva, que laboró durante el periodo electrivo 2018 - 2019.
      </th>
    </tr>
    <tr>
      <th ><span class="">#</span></th>
      <th ><span class="">Grupo Valorado</span></th>
      <th style="width:50px;text-align:right; "><span class="">Val Max</span></th>
      <th style="width:50px;text-align:right; "><span class="">Sum</span></th>
      <th style="width:50px;text-align:right; "><span class="">N.Usu</span></th>
      <th style="width:50px;text-align:right; "><span class="">Prom %</span></th>
    </tr>
    <tbody>
      <?php
      $x=1;
      $t=0;
      ?>
      @foreach($rst as $p)
      <?php $t+=$p->prom; ?>
      <tr>
        <td>{{$x++}}</td>
        <td style="text-align:left" >{{$p->grp_descripcion}}</td>
        <td style="text-align:right" >{{$p->grp_valoracion}}</td>
        <td style="text-align:right" >{{number_format($p->sum,2)}}</td>
        <td style="text-align:right" >{{number_format($p->n_user,2)}}</td>
        <td style="text-align:right" >{{number_format($p->prom,2)}} %</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot style="background:#eee ">
      <th colspan="4" style="text-align:right;font-size:17px;">Total Alcanzado:</th>
      <th colspan="3" id="tot_gen" style="font-size:17px;text-align:right;">{{number_format($t,2)}}%</th>
    </tfoot>
  </table>


</body>
</html>