<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Imprimible</title>
  <style>
    /*CODIGO DE VISTA PREVIA*/
    html { overflow: auto; padding: 0.5in; }
    html { background: #999; cursor: default; }
    body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
    body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);width: 8.27in;height:auto; }
   /*CODIGO DE IMPRESION*/
/*CODIGO PROPIO DEL DOCUMENTO*/
    table{
      border-collapse: collapse;        
    }
    #tbl_datos th, #tbl_datos td{
      border:solid 1px #000;
    }
    .cls_nota{
      text-align:right;
    }
    .nota_baja{
      background:red; 
    }
    .cls_fila_nota{
      background:#eee; 
    }
  </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>  
<script>

  $(function(){

    const tbl=$("#tbl_datos");
    const rows=$(tbl).find("tr");
    let materias=materias_encabezado(rows[0]);
    console.log(materias);
    let res="";
    $(rows)[rows.length-1].remove();
    $(rows)[0].remove();
    $(rows)[1].remove();
    const rows_new=$(tbl).find("tr");

    rows_new.each(function(){
            res+=escribe_notas(materias,$(this))
    });

})


  function escribe_notas(materias,rw){
     let rst="";
     let cols=$(rw).find("td");
     let nm=(cols[1].innerHTML);
     let i=0;
     let j=0;
     let n_mtr=0;
     cols.each(function(){
        //console.log(this.innerHTML);
if(i!=cols.length-1){

        if(i>0){
          if(i==1){
            //Nombre del estudiante
            $("#tbl_reporte").append( `<tr><td>${ this.innerHTML } <td colspan=3 ></td> </tr>` );
          }else{
            nota=(this.innerHTML);
            cls_nota="";
            cls_fila_nota="cls_fila_nota";
            if(nota<7){
              cls_nota="nota_baja";
              cls_fila_nota="";
            }
            j++;
            if(j==1){ ///Materias
              $("#tbl_reporte").append( `<tr class='${cls_fila_nota}'> <td></td> <td>${materias[n_mtr]}</td> <td>Ins${j}</td> <td class='cls_nota ${cls_nota}' >${ nota }</td> </tr>` );
            }else{
                if(j==6){///Promedio
                  $("#tbl_reporte").append( `<tr class='${cls_fila_nota}'> <td></td> <td> </td> <td>Prom:</td> <td class='cls_nota ${cls_nota}'>${ nota }</td> </tr>` );
                  j=0;
                  n_mtr++;
                }else{ ///Insumo
                  $("#tbl_reporte").append( `<tr class='${cls_fila_nota}'> <td></td> <td> </td> <td>Ins${j}</td> <td class='cls_nota ${cls_nota}'>${ nota }</td> </tr>` );
                }

            }
          }

        }
        i++;

     }

     });
  }


  function materias_encabezado(rw){
    let materias=[];
    let cols=$(rw).find("th");
    let x=0;
    cols.each(function(){
      if(x>0){
        materias.push($(this).html());
      }
      x++;
    });
    return materias;
  }



</script>
</head>
<div hidden>
  {!!$resultado!!}
</div>
<body>
<table id="tbl_reporte" border="1">
  <tr>
    <th>Estudiante</th>
    <th>Materia</th>
    <th>Insumo</th>
    <th>Nota</th>
  </tr>
  
</table>

</body>
</html>

