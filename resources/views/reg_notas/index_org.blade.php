@extends('layouts.app')
@section('scripts')
<?php
$cont_esp="hidden";
$us=Auth::user()->id;
if($us==22 || $us==86){//Lic Alejandro y Lic Javier
    $cont_esp="";
}
?>
<script>
    $(function () {

        j = $("#jor_id").val('0');
            $("#esp_id").val('10');
        $("#btn_buscar").click(function () {

            j = $("#jor_id").val();
            c = $("#cur_id").val();
            m = $("#mtr_id").val();
            mt = $("#mtr_tec_id").val();
            b = $("#bloque").val();
            esp=$("#esp_id").val();
            
            if(c.length>2){
                aux_par=c.substring(2,5);
                if(aux_par=='BGU'){
                    esp=7;
                }else if(aux_par=='BSX'){
                    esp=8;
                }
            }
            cp=c.split('');
                var url = window.location;
                $.ajax({//Cargar los datos 
                    url: url + "/"+j+"&"+cp[0]+"&"+cp[1]+"&"+m+"&"+b+"&"+mt+"&"+esp, //RegNotasController@load_datos (Jor,Cur,Par,Mtr,Bloq,Mtrt,Esp)
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        if($("#mtr_id").val()==1 && $("#mtr_tec_id").val()==0 ){
                            alert('Módulo es Obligatorio');
                            return false;
                        }else if($("#mtr_id").val()==0){
                            alert('Materia es Obligatoria');
                            return false;
                        }else if($("#cur_id").val()==0){
                            alert('Curso es Obligatorio');
                            return false;
                        }else{
                            $(".bloqueo").css('visibility', 'visible');

                        }
                    },
                    success: function (dt,textStatus, jqXHR) {
                        $("#tbl_notas").html(dt);
                        $(".bloqueo").css('visibility', 'hidden');
                         txt_notas();
                         promedios();
                    }

                })                
        });




            ast=20;
            at=28;
            fl=30;
            $("#asistentes").text(ast);
            $("#atrasados").text(at);
            $("#faltantes").text(fl);



///*******PONER OTRO ESTILO AL INSUMO 6 QUE ES LA RECUPERACION**********/////

  //Funcion para cambiar a TAB vertical/*****/////////////
    $('tr').each(function() {
        $(this).find('td').each(function(i) {
            $(this).find('input').attr('tabindex', i+1);
        });
    });
///////////////*****************///////////////////////

        $(document).on('blur', '.txt_notas', function () {
                dt=$(this).attr('id').split('&');
                col=$(this).parent();
                row=$(col).parent();

                if($("#bloque").val()==100){ //Si son notas adicionales
                    tf=0;
                    c=0;
                    $(row).find('input[type=text]').each(function(){
                        dat=$(this).attr('id').split('&');
                        if(dat[0]>0){
                            if($(this).val()>=7 && c==0){
                                tf=parseFloat($(this).val());
                                $("#tfin"+dat[0]).val('7.00');
                                c=1;
                            }

                        }

                    });

                    if(c==0){
                       tq1=parseFloat($("#tq1"+dt[0]).val());
                       tq2=parseFloat($("#tq2"+dt[0]).val());
                       $("#tfin"+dt[0]).val(((tq1+tq2)/2).toFixed(2));
                   }

               }else{ //Son notas Normales

                vl=0;
                pq80=0;
                pq20=0;
                aux=0;
                $(row).find('input[type=text]').each(function(){

                     dat=$(this).attr('id').split('&');

                        if(dat[0]>0){//Si existe algun id
                               vl=(vl*1)+($(this).val()*1);

                               ///Si es la nota de recuperacion
//                               alert(dat[1]);
                                if(dat[1]==12 && $(this).val()>0 ){
                                    aux=1;
                                 }

                                if(dat[1]==9){
                                    pq80= $("#pq_"+dat[0]).val();
                                    pq20=($(this).val()*0.2);
                                }
                                if(dat[1]==10){
                                   pq80= $("#pq_"+dat[0]).val();
                                   pq20=($(this).val()*0.2);
                               }

                         }else{

                            if($("#bloque").val()==7 || $("#bloque").val()==8){ //si es examen quimestral
                                 totq2=((pq80*1)+(pq20*1)).toFixed(2);
                                 $("#tot"+dt[0]).val(totq2);  

                                totq1=$("#tq1"+dt[0]).val();      
                                 tf=(((totq1*1)+(totq2*1))/2).toFixed(2);
                                 $("#tfin"+dt[0]).val(tf);

                            }else{

                                     ct=($("#count").val()*1);
                                     if(aux==0){
                                        ct--;
                                     }

                                    if($("#"+dat[0]).val()<7){

                                        $("#"+dat[0]).addClass(" nota_baja");

                                    }else{

                                        $("#"+dat[0]).removeClass(" nota_baja");
                                        
                                    }


                                    $("#"+dat[0]).val((vl/ct).toFixed(2));      


                            }
                    }
                });

            }

        });

        $(document).on('input', '.txt_notas', function () {
            var vl=parseFloat(this.value);

            if(vl>0 && vl<5){

                $(this).addClass(" remedial");
                $(this).removeClass(" supletorio");

            }else if(vl>=5 && vl<7){

                $(this).addClass(" supletorio");
                $(this).removeClass(" remedial");

            }else{

                $(this).removeClass(" supletorio");
                $(this).removeClass(" remedial");
            }
            
            this.value = this.value.replace(/[^0-9.]/g, '');

        });


        $(document).on('change', '.tx_comprtamiento', function () {
            obj=$(this);
            token=$("#_token").val();
            url=window.location;
            matid=$(obj).attr('mat_id');
            dscid=$(obj).attr('dsc_id');
            if(dscid==undefined){
                dscid=0;
            }
            mtrid=$('#mtr_id').val();
            if(mtrid==1){
                mtrid=$('#mtr_tec_id').val();
            }
            dsc_parcial=$('#bloque').val();
            dsc_tipo=0;
            dsc_nota=$(obj).val();

            $.ajax({
                url: url+'/registra_comportamiento',
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {matid:matid,
                       mtrid:mtrid,
                       dsc_parcial:dsc_parcial,
                       dsc_tipo:dsc_tipo,
                       dsc_nota:dsc_nota,
                       dsc_id:dscid,

                   },
                beforeSend:function(){
                    
                     if(dsc_nota==0){
                        Swal.fire({
                          type: 'error',
                          title: 'Debe seleccionar una opción',
                          text: 'Error'
                      });
                        
                        return false;
                     }

                },
                success:function(dt){

                    $(obj).attr('dsc_id',dt);

                },
                error : function(jqXHR, textStatus, errorThrown) {

                   if (jqXHR.status === 0) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (jqXHR.status == 404) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (jqXHR.status == 500) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (textStatus === 'parsererror') {
                    mensaje("error","Error en Conexión de red","Requested JSON parse failed.");
                    $(obj).val(0);
                } else if (textStatus === 'timeout') {
                    mensaje("error","Error en Conexión de red","Time out error.");
                    $(obj).val(0);
                } else if (textStatus === 'abort') {
                    mensaje("error","Error en Conexión de red","Ajax request aborted.");
                    $(obj).val(0);
                } else {
                    mensaje("error","Error en Conexión de red",'Uncaught Error: ' + jqXHR.responseText);
                    $(obj).val(0);
                }

            }                

            })  

              // this.value = $(this).val().toUpperCase();
              // this.value = this.value.replace(/[^a-eA-E]/g,''); 
        })

        $(document).on('click', '#save', function () {
            
            if(confirm('Los datos serán guardados')){
                $("#tbl_notas").html("");
            }

        });

        $("#jor_id").change(function () {
            var url = window.location;
                $.ajax({
                    url: url + "/cur/0/"+this.value+"&"+$("#cur_id").val(), //RegNotasController@show
                    type: 'GET', 
                    dataType: 'json',
                    beforeSend: function(){
                        $("#tbl_notas").html("");
                    },
                    success: function (datos) {

                        dt="<option value='0'>Seleccione</option>";
                       $(datos).each(function (){
                           dt+='<option value='+this['cur_id']+this['paralelo']+' >'+this['cur_descripcion']+' '+this['paralelo']+'</option>';
                       }); 
                       $('#cur_id').html(dt);

                    }
                });
        });
        
        $("#cur_id").change(function () {
            var url = window.location;
            //alert($(this).val());
                if($(this).val().length>2){
                    vl_cur=$(this).val().substring(2);
                    if(vl_cur=='BGU'){
                        var opt="";
                             opt+="<option value='1' >Parcial 1</option>";
                             opt+="<option value='2' >Parcial 2</option>";
                             opt+="<option value='7' >Examen Periodo I</option>";
                             opt+="<option value='3' >Parcial 3</option>";
                             opt+="<option value='4' >Parcial 4</option>";

                        opt+="<option value='8' >Examen Periodo II</option><option value='100' >Notas Adicionales</option>";
                        $("#bloque").html(opt);
                    }
                }

                $.ajax({
                    url: url + "/cur/1/"+$("#jor_id").val()+"&"+$(this).val(), //RegNotasController@show
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                        $("#tbl_notas").html("");
                    },
                    success: function (datos) {
                        dt="<option value='0'>Seleccione</option>";
                       $(datos).each(function (){
                           dt+='<option value='+this['mtr_id']+' >'+this['mtr_descripcion']+'</option>';
                       }); 
                       $('#mtr_id').html(dt);
                    }
                });
        });

        $("#mtr_tec_id").change(function () {
            $("#tbl_notas").html("");
            dt=$('#mtr_tec_id option:selected').text().split('->');
            $("#n_bloques").val(dt[1]);
            var opt="";
            var x=1;
            while(x<=dt[1]){
                opt+="<option value='"+x+"' >Parcial "+x+"</option>";
                x++;
            }
            opt+="<option value='7' >Examen Final</option><option value='100' >Notas Adicionales</option>";

            $("#bloque").html(opt);            

        });

        $("#mtr_id").change(function () {
            $("#tbl_notas").html("");
            var url = window.location;
            dat=$("#cur_id").val().split('');
            var esp=$("#esp_id").val();
            //alert(dat[0]);
            if($(this).val()==1){ //si es materia tecnica
                $("#mtr_tec").show();
                $("#bloq").show();
                $.ajax({
                    url: url + "/mtr/"+esp+"/"+dat[0],//RegNotasController@mtr_tecnicas
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                        //$("#tbl_notas").html("");
                    },
                    success: function (datos) {
                        dt="<option value='0'>Seleccione</option>";
                       $(datos).each(function (){

                               $("#esp_id").val(this['esp_id']);

                           dt+='<option value='+this['id']+' >'+this['mtr_descripcion']+'->'+this['bloques']+'</option>';
                       }); 

                       $('#mtr_tec_id').html(dt);

                    }
                });

            }else{
                $("#mtr_tec").hide();
                $("#bloq").show();
            }

        });        
    })

function mensaje(ico,tit,txt){
    Swal.fire(tit,txt,ico)
}

// function confirmacion(){

// Swal.fire({
//   title: 'Are you sure?',
//   text: "You won't be able to revert this!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Yes, delete it!'
// }).then((result) => {
//   if (result.value) {

//     Swal.fire(
//       'Deleted!',
//       'Your file has been deleted.',
//       'success'
//     )

//   }
// })

// }

function save(obj){
    var url = window.location;
    dt=obj.id.split('&');
    mtr_id = $("#mtr_id").val();//Materia
    quim = $("#quimestre").val();//Quimestre
    parc = $("#bloque").val();//Parcial
    user = $("#usu_id").val();//Usuario
    mt = $("#mtr_tec_id").val();//Materia Tecnica
    nb = $("#n_bloques").val();//Numero de bloques por materia
    //comp=$(obj).parent().parent().find(".tx_comprtamiento").val();
    comp=null;
    datos = dt[0] + "&" + dt[1] + "&" + obj.value + "&" + mtr_id + "&" + quim + "&" + parc + "&" + user+ "&" + $(obj).attr('lang')+"&"+mt+"&"+comp+"&"+nb;
    $.ajax({
        url: url + "/save_notes/"+datos,
        type: 'GET', 
        dataType: 'json',
        beforeSend: function () {

            var us='<?php echo $us?>';
            if(us==22 || us==86){ //Lic Alejandro y Lic Javier
                mensaje("error","Accion No autorizada","Ud. no está autorizado para modificar las notas");
                return false;
            }else{

                    if(obj.value==0){
                        if(prompt("Ingrese Código para eliminar la Nota")!='1714'){
                            mensaje("error","Codigo Incorrecto","Solicite el código al Administrador del Sistema");
                            return false;
                        }
                    }else{
                        if(!(obj.value>0 && obj.value<=10)){
                            mensaje("error","Dato Incorrecto","La NOTA debe ser entre 0 y 10");
                            $(obj).val(0);
                            return false;
                        }

                    }
            //     if(obj.value>0 && obj.value<7){
            //         if(!confirm("Nota Baja Se enviará una Notficación al Representante")){
            //             return false;
            //         }
            //     // mensaje("warning","Nota Baja","Sen enviará una Notficación al Representante");
            // }
        }
//return false;
        },
        success: function (r) {
            $(obj).attr('lang',r['id']);
                promedios();
            if (r==0) {
                alert("Error Verfifique los Valores");
                //$(this).css('border-bottom','dashed 2px brown');
            }
        },
        error : function(jqXHR, textStatus, errorThrown) {

                 if (jqXHR.status === 0) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (jqXHR.status == 404) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (jqXHR.status == 500) {
                    mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                    $(obj).val(0);
                } else if (textStatus === 'parsererror') {
                    mensaje("error","Error en Conexión de red","Requested JSON parse failed.");
                    $(obj).val(0);
                } else if (textStatus === 'timeout') {
                    mensaje("error","Error en Conexión de red","Time out error.");
                    $(obj).val(0);
                } else if (textStatus === 'abort') {
                    mensaje("error","Error en Conexión de red","Ajax request aborted.");
                    $(obj).val(0);
                } else {
                    mensaje("error","Error en Conexión de red",'Uncaught Error: ' + jqXHR.responseText);
                    $(obj).val(0);
                }
        }

    })
}
function txt_notas(){
    $(".txt_notas").each(function(){
        if($(this).val()==0){
            $(this).addClass(" remedial");
        }
    })
}

function promedios(){
    var c=0;
    var x=0;
    var ex=0;
    var bu=0;
    var rg=0;
    var ins=0;

    $(".promedio").each(function(){
        if(this.value!='0.00'){
            x++;
            c=c+parseFloat(this.value);

            if(parseFloat(this.value)>=8.5){
                ex++;
            }
            if(parseFloat(this.value)>=7 && parseFloat(this.value)<8.5 ){
                bu++;
            }
            if(parseFloat(this.value)>=5 && parseFloat(this.value)<7 ){
                rg++;
            }
            if(parseFloat(this.value)>0 && parseFloat(this.value)<5 ){
                ins++;
            }
        }
    })

$("#excelentes").css('width',(ex*100/x)+'%');
$("#buenos").css('width',(bu*100/x)+'%');
$("#regulares").css('width',(rg*100/x)+'%');
$("#insuficientes").css('width',(ins*100/x)+'%');

$("#tgx").html('<b>'+ex+'</b>/'+x);
$("#tgb").html('<b>'+bu+'</b>/'+x);
$("#tgr").html('<b>'+rg+'</b>/'+x);
$("#tgi").html('<b>'+ins+'</b>/'+x);

 diagrama_gaus(ex,bu,rg,ins);

 if(x>0){
    $("#promedio_g").text((c/x).toFixed(2));
 }else{
    $("#promedio_g").text((c).toFixed(2));
}

}

function valida_descarga(obj){

    $(obj).find('input[class=inp_datos]').val($('#cont_table').html());
//return false;
}


function diagrama_gaus(ex,bu,ml,ins){

  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  var salesChart       = new Chart(salesChartCanvas);
  var salesChartData = {
    labels  : ['1','5','7','8.5','10'],
    datasets: [
      {
        label               : 'Promedios',
        fillColor           : '#0779A9',
        strokeColor         : 'rgb(210, 214, 222)',
        pointColor          : 'rgb(210, 214, 222)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgb(220,220,220)',
        data                : [ins,ml,bu,ex]
      }

    ]
  };

  var salesChartOptions = {
    // Boolean - If we should show the scale at all
    showScale               : true,
    // Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : false,
    // String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    // Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    // Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    // Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    // Boolean - Whether the line is curved between points
    bezierCurve             : true,
    // Number - Tension of the bezier curve between points
    bezierCurveTension      : 0.3,
    // Boolean - Whether to show a dot for each point
    pointDot                : false,
    // Number - Radius of each point dot in pixels
    pointDotRadius          : 4,
    // Number - Pixel width of point dot stroke
    pointDotStrokeWidth     : 1,
    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius : 20,
    // Boolean - Whether to show a stroke for datasets
    datasetStroke           : true,
    // Number - Pixel width of dataset stroke
    datasetStrokeWidth      : 2,
    // Boolean - Whether to fill the dataset with a color
    datasetFill             : true,
    // String - A legend template
    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio     : true,
    // Boolean - whether to make the chart responsive to window resizing
    responsive              : true
  };
  salesChart.Line(salesChartData, salesChartOptions);
}

</script>
<style>
            .bloqueo{
                background:rgba(245, 245, 245, 0.4);
                position:absolute;
                width:83%;
                height:85%;
                z-index:9999;
                text-align:center;
                visibility:hidden; 
            }
            .bloqueo img{
                width: 120px;
                margin-top:10%; 
            }
            #tbl_notas tbody tr:hover{
                background:#9BC8D2; 
            }
            #tbl_notas thead{
                color:#00748E; 
            }
            #tbl_notas tbody td{
              border-bottom:solid 1px #B8E8F3;  
            }
            #tbl_notas thead tr th{
                text-align:center;
                border:solid 1px #75B5C3;
                vertical-align:bottom;
                font-size:11px;     
                font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;             
            }
            #tbl_notas tbody tr td input{
                width:50px; 
                text-align:right; 
            }
            .txt_prom{
                background:#eee; 
            }
            .nota_baja{
                color:brown;
                font-weight:bold;
                border:solid 2px brown;  
            }
            .rotate_tx{
                writing-mode: vertical-lr;
                transform: rotate(180deg);
                 padding: 5px 0px 5px 0px;/*top right boottom left*/
            }
            .supletorio{
               color:#8F7304;
               border-bottom:solid 2px #F5D839;
            }
            .remedial{
               color:brown;
               border-bottom:solid 2px brown;
            }
        </style>
@endsection

@section('content')
<section class="content-header">
    <h1 class="pull-left">
        REGISTRO DE NOTAS 
    </h1>
</section>
<div class="content">

    <div class="clearfix"></div>
        @include('flash::message')
    <div class="clearfix"></div>
    
    <div class="bloqueo">
        <img src="{{asset('img/loading.gif')}}" class="user-image" alt="User Image"/>
    </div>


    <div class="box box-primary">
        <div class="box-body">
            <form action="cargar.frm_notas" method="POST" id='frm_data'>
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token()}}">
                <input type="hidden" name="usu_id" id="usu_id" value="{{Auth::user()->id}}" />
                <input type="hidden" name="n_bloques" id="n_bloques" value="6"  />
                <div class="form-group col-sm-2">
                    {!! Form::label('jor_id', 'Jornada:') !!}
                    {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                </div>

                <div class="form-group col-sm-2" <?php echo $cont_esp?> >
                    {!! Form::label('esp_id', 'Especialidad:') !!}
                    {!! Form::select('esp_id',$esp,null,['class'=>'form-control','id'=>'esp_id']) !!}    
                </div>                
                <div class="form-group col-sm-2">
                    {!! Form::label('cur_id', 'Curso:') !!}
                    {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::label('mtr_id', 'Materia:') !!}
                    {!! Form::select('mtr_id',$mtr,null,['class'=>'form-control']) !!}    
                </div>
                <div class="form-group col-sm-2" id="mtr_tec" hidden>
                    {!! Form::label('mtr_tec_id', 'Modulo:') !!}
                    {{ Form::select('mtr_tec_id', [
                        '0' => 'Seleccione',            
                        ],null,['class' => 'form-control']) }}    
                </div>
                <div class="form-group col-sm-2" id="bloq" hidden>
                    {!! Form::label('bloque', 'Bloque/Parcial:') !!}
                    <select name="bloque" id="bloque" class="form-control">
                        <option value="1">Parcial 1</option>
                        <option value="2">Parcial 2</option>
                        <option value="3">Parcial 3</option>
                        <option value="7">Examen Quim I</option>
                        <option value="4">Parcial 4</option>
                        <option value="5">Parcial 5</option>
                        <option value="6">Parcial 6</option>
                        <option value="8">Examen Quim II</option>
                        <option value="100">Notas Adicionales</option>
                    </select>

                </div>

                <div class="form-group col-sm-2" hidden>
                    {!! Form::label('quimestre', 'Quimestre:') !!}
                    {{ Form::select('quimestre', [
                        '0' => 'Seleccione',
                        '1' => 'Primero I',            
                        '2' => 'Segundo II',            
                        ],null,['class' => 'form-control']) }}    
                </div>
                <div class="form-group col-sm-2">
                    <i id="btn_buscar" class="btn btn-primary" style="margin-top:25px ">Buscar</i>
                </div>
            </form>
        </div>
        <div class="row container-fluid">
            <div class="table-responsive col-lg-6 col-md-12 " id="cont_table">
                <table id="tbl_notas" border="0">
                    
                </table>
            </div>

            <!-- /.box-header -->
                <div class="col-lg-3 col-md-12">
                  <p class="text-center">
                    <strong>Campana de Gauss</strong>
                  </p>
                  <div class="chart">
                    <canvas id="salesChart" style="height: 180px;"></canvas>
                  </div>
                </div>

                <div class="col-lg-3 col-md-12">
                  <p class="text-center">
                    <strong>Porcentaje de Notas del Curso</strong>
                 </p>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Mayor a 8.5</span>
                    <span class="progress-number" id='tgx'></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" id="excelentes" ></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Entre 7 y 8.5</span>
                    <span class="progress-number" id='tgb'></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" id="buenos" ></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Entre 5 a 7</span>
                    <span class="progress-number" id='tgr' ></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" id="regulares" ></div>
                    </div>
                  </div>                  

                  <div class="progress-group">
                    <span class="progress-text">Menor a 5</span>
                    <span class="progress-number" id='tgi' ></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" id="insuficientes" ></div>
                    </div>
                  </div>                  
                  <!-- /.progress-group -->
                </div>

                <div class="col-lg-2 col-md-12">
                  <div class="info-box" style="border-radius:10px;border:solid 1px red;background:#FAF8F8;">
                    <span class="info-box-icon bg-info"><i class="fa fa-bar-chart text-green"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size:20px;">Promedio</span>
                        <span class="info-box-number" style="font-size:30px;" id="promedio_g" >0</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-12">
                <form action='regNotas.descarga_archivo' class="text-right" onsubmit='return valida_descarga(this)' method='POST' target='_blank' >
                    <input type='hidden' name='inp_datos' class='inp_datos'  />
                    {{csrf_field()}}
                    <button type='submit' style="margin-top:20px" class='btn btn-info fa fa-print btn_descargar'>Imprimir Reporte</button>
                </form>
            </div>


        </div>
    </div>
    <input class="btn btn-warning " type="submit" name="save" id="save" value="Guardar" /> 
</div>
@endsection
