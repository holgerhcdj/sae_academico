<?php
//dd($dt_conf);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Imprimible</title>
  <style>
    /*CODIGO DE VISTA PREVIA*/
/*    html { overflow: auto; padding: 0.5in; }
    html { background: #999; cursor: default; }
    body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
    body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);width: 8.27in;height:auto; }
*/    /*8,25 x11,75*/
   /*CODIGO DE IMPRESION*/
/*CODIGO PROPIO DEL DOCUMENTO*/
    table{
      border-collapse:collapse;        
      font-family:Arial;
      font-size:11px;  
    }
    #tbl_datos{
      float:left; 
      border:solid 1px #ccc;
      margin-left:3%; 
      width:40%; 
    }
    #tbl_estadistica{
      float:left;
      margin-left:1%; 
      border:solid 1px #ccc;
    }
    .cls_nota{
      text-align:right;
    }
    .nota_baja_sup{
      background:#F7D19B; 
    }
    .nota_baja_rem{
      background:#F2807D; 
    }
    .num_est,.por_est{
      text-align:right; 
    }
    th,td{
      padding:5px; 
      border-bottom:solid 1px #ccc;
    }
/*******BARRA DE PROGRESO*****/
.cont_grafico {
  float:left; 
  width:70%; 
  margin-left:2%; 
}



  </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>

<script>

  $(function(){
    const tot_est='{{count($datos)}}';
    const cnt=$(".contador");
    cnt.each(function(){
      let row=$(this).parent();
      let cls_row=$(row).attr('class');
      let nrows=$('.'+cls_row);
      if(nrows.length==1){
        $(nrows).remove();
      }
    });
//********************/////////////
    const cnt_new=$(".contador");
    let n=0;
    cnt_new.each(function(){
      n++;
      $(this).html(n);
    });
//********************/////////////
const materias=$("#tbody_datos").find("tr");
materias.each(function(){
  let clas_row=$(this).attr('class');
  let n_est=$(".mtr"+clas_row);
  $(this).find('.num_est').html(n_est.length);
  $(this).find('.por_est').html( ((n_est.length*100)/tot_est).toFixed(2) );
});
//********************/////////////
grafico();
//["Red", "Blue", "Yellow", "Green", "Purple", "Orange"]

})

function grafico(){
let materias=$('.nm_materia');
let mtrs=[];
let colrs=[];
materias.each(function(){
  mtrs.push( $(this).html() );
});

let nm_estudiantes=$('.por_est');
let nmest=[];
nm_estudiantes.each(function(){
  nmest.push( $(this).html() );
});


    var ctx = document.getElementById("stadistic_graph");
    var stadistic_graph = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: mtrs,
        datasets: [{
          label: 'Porcentaje',
          data: nmest,
          backgroundColor:'rgba(54, 162, 235, 0.2)',
          borderColor:'rgba(54, 162, 235, 1)',
          borderWidth: 0.5
        }]
      },
      options: {
        scales: {

          yAxes: [{
            ticks: {

              min: 0,
              max: 100,
              callback: function(value) {
                return value + "%"
              }
            },
            scaleLabel: {
              display: true,
              labelString: "Percentage"
            }
          }]
        }
      }
    });

}  

</script>
</head>
<body>
  <div>
    <h3 style="text-align:center;margin-top:0px  ">REPORTE DE BAJO RENDIMIENTO</h3>
    <h3 style="text-align:center;margin-top:-10px  ">{{$dt_conf['jornada'].' / '.$dt_conf['curso'].' / '.$dt_conf['paralelo']}}</h3>
  </div>

<table id="tbl_estadistica">
  <tr><th style="background:#0275d8;color:#fff  " colspan="4">CONSOLIDADO MENOR A 7</th></tr>
  <tr>
    <th>Materias</th>
    <th>N° Est ({{count($datos)}})</th>
    <th>Porcentaje %</th>
  </tr>
  <tbody id="tbody_datos">
    @foreach($materias as $m)
    <tr class="{{$m->mtr_id}}">
       <td class="nm_materia">{{$m->mtr_descripcion}}</td>
       <td class="num_est"></td>
       <td class="por_est"></td>
    </tr>
    @endforeach
  </tbody>
</table>
<div class="cont_grafico">
  <canvas id="stadistic_graph" ></canvas>
</div>

<table id="tbl_datos">
  <tr style="background:#0275d8;color:#fff  ">
    <th colspan="4">DETALLE POR ESTUDIANTE</th>
  </tr>
  <tr>
    <th>#</th>
    <th>Estudiante</th>
    <th>Materia</th>
    <th>Promedios</th>
  </tr>
  <?php $x=1;?>
  @foreach($datos as $d)
  <?php $est=explode("&",$d->estudiante); ?>

     <tr class="{{'cls'.$est[1]}}" ><td class="contador"></td> <td>{{$est[0]}}</td> <td></td><td></td> </tr>
     <?php $prm_suma=0;$prom_materia=0;?>
      @foreach($materias as $m)
         <?php 
              $ins1='nt'.$m->mtr_id.'13';
              $ins2='nt'.$m->mtr_id.'14';
              $ins3='nt'.$m->mtr_id.'15';
              $ins4='nt'.$m->mtr_id.'16';
              $ins5='nt'.$m->mtr_id.'17';
              $prm_suma=($d->$ins1+$d->$ins2+$d->$ins3+$d->$ins4+$d->$ins5);
              $prom_materia=number_format($prm_suma/5,2);
         ?>
         @if($prom_materia<7)
         <?php
         if($prom_materia>=5){
           $cls_promedio="nota_baja_sup";
         }else{
           $cls_promedio="nota_baja_rem";
         }
         ?>
            <tr class=" {{'cls'.$est[1]}} "><td></td> <td></td> <td class="{{'mtr'.$m->mtr_id}}" >{{$m->mtr_descripcion}}</td> <td class="cls_nota {{$cls_promedio}} ">{{$prom_materia}}</td> </tr>
         @endif
      @endforeach

  @endforeach
</table>

</body>
</html>

